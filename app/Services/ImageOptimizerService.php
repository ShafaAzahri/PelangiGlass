<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class ImageOptimizerService
{
    /**
     * Converts an image file to modern WebP format in-place.
     * - Fixes smartphone EXIF auto-orientation
     * - Resizes if exceeding $maxWidth or $maxHeight (Lanczos filter)
     * - Compresses to WebP (quality 82%), deletes old file if not WebP
     * - Returns the new absolute path (ending in .webp), or null on failure.
     */
    public static function convertToWebP(string $absolutePath, int $maxWidth = 1600, int $maxHeight = 1600, int $quality = 82): ?string
    {
        if (! file_exists($absolutePath) || is_dir($absolutePath)) {
            return null;
        }

        $mime = @mime_content_type($absolutePath);
        if (! $mime || ! str_starts_with($mime, 'image/')) {
            return null;
        }

        if (str_contains($mime, 'svg') || str_contains($mime, 'gif')) {
            return null;
        }

        $dir = dirname($absolutePath);
        $filenameWithoutExt = pathinfo($absolutePath, PATHINFO_FILENAME);
        $newWebpPath = $dir.DIRECTORY_SEPARATOR.$filenameWithoutExt.'.webp';
        // 1. Primary Engine: Native PHP GD (Zero subprocess overhead, standard in Docker runtime)
        if (function_exists('imagewebp') && function_exists('imagecreatetruecolor')) {
            $converted = static::convertUsingGd($absolutePath, $newWebpPath, $maxWidth, $maxHeight, $quality);
            if ($converted) {
                if (realpath($absolutePath) !== realpath($newWebpPath) && file_exists($newWebpPath)) {
                    @unlink($absolutePath);
                }

                return $newWebpPath;
            }
        }

        // 2. Fallback Engine: Python3 with Pillow (Local environment / advanced Lanczos)
        $pythonScript = <<<'PYTHON'
import sys, os
from PIL import Image, ImageOps

if len(sys.argv) < 6:
    sys.exit(1)

src = sys.argv[1]
dest = sys.argv[2]
max_w = int(sys.argv[3])
max_h = int(sys.argv[4])
quality = int(sys.argv[5])

try:
    if not os.path.exists(src):
        sys.exit(1)

    with Image.open(src) as img:
        try:
            img = ImageOps.exif_transpose(img)
        except Exception:
            pass

        w, h = img.size
        if w > max_w or h > max_h:
            img.thumbnail((max_w, max_h), Image.Resampling.LANCZOS)

        if img.mode not in ['RGB', 'RGBA']:
            img = img.convert('RGBA' if 'transparency' in img.info or img.mode == 'P' else 'RGB')

        img.save(dest, format='WEBP', quality=quality, method=6)

    if os.path.abspath(src) != os.path.abspath(dest) and os.path.exists(dest):
        os.remove(src)

    print("OK")
except Exception as e:
    sys.stderr.write(f"WebP conversion error: {e}\n")
    sys.exit(1)
PYTHON;

        $tempFile = tempnam(sys_get_temp_dir(), 'imgwebp_').'.py';
        file_put_contents($tempFile, $pythonScript);

        $escapedSrc = escapeshellarg($absolutePath);
        $escapedDest = escapeshellarg($newWebpPath);
        $cmd = "python3 {$tempFile} {$escapedSrc} {$escapedDest} {$maxWidth} {$maxHeight} {$quality} 2>&1";

        exec($cmd, $output, $exitCode);
        @unlink($tempFile);

        if ($exitCode !== 0 || ! file_exists($newWebpPath)) {
            Log::warning('WebP conversion failed for '.$absolutePath.': '.implode("\n", $output));

            return null;
        }

        return $newWebpPath;
    }

    /**
     * Converts image to WebP using native PHP GD library.
     */
    protected static function convertUsingGd(string $src, string $dest, int $maxWidth, int $maxHeight, int $quality): bool
    {
        try {
            $info = @getimagesize($src);
            if (! $info) {
                return false;
            }

            [$width, $height, $type] = $info;

            $image = match ($type) {
                IMAGETYPE_JPEG => @imagecreatefromjpeg($src),
                IMAGETYPE_PNG => @imagecreatefrompng($src),
                IMAGETYPE_WEBP => @imagecreatefromwebp($src),
                IMAGETYPE_BMP => @imagecreatefrombmp($src),
                default => null,
            };

            if (! $image) {
                return false;
            }

            if (in_array($type, [IMAGETYPE_PNG, IMAGETYPE_WEBP])) {
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
            }

            if ($width > $maxWidth || $height > $maxHeight) {
                $ratio = min($maxWidth / $width, $maxHeight / $height);
                $newWidth = (int) round($width * $ratio);
                $newHeight = (int) round($height * $ratio);

                $resized = imagecreatetruecolor($newWidth, $newHeight);
                if (in_array($type, [IMAGETYPE_PNG, IMAGETYPE_WEBP])) {
                    imagealphablending($resized, false);
                    imagesavealpha($resized, true);
                }

                imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagedestroy($image);
                $image = $resized;
            }

            $success = @imagewebp($image, $dest, $quality);
            imagedestroy($image);

            return $success && file_exists($dest);
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Fallback in-place optimizer.
     */
    public static function optimize(string $absolutePath, int $maxWidth = 1600, int $maxHeight = 1600, int $quality = 82): bool
    {
        return static::convertToWebP($absolutePath, $maxWidth, $maxHeight, $quality) !== null;
    }
}
