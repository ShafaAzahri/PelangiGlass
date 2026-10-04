<?php

namespace App\Traits;

use App\Services\ImageOptimizerService;
use Illuminate\Support\Facades\Storage;

trait HasAutoCleanupFiles
{
    public static function bootHasAutoCleanupFiles(): void
    {
        static::updating(function ($model) {
            foreach ($model->getFileFields() as $field) {
                if ($model->isDirty($field)) {
                    $original = $model->getOriginal($field);
                    $current = $model->getAttribute($field);

                    if (is_array($original) || is_array($current)) {
                        $oldList = is_array($original) ? $original : [];
                        $newList = is_array($current) ? $current : [];
                        $removed = array_diff($oldList, $newList);
                        foreach ($removed as $file) {
                            static::deleteStoredFile($file);
                        }
                    } else {
                        if (!empty($original) && $original !== $current) {
                            static::deleteStoredFile($original);
                        }
                    }
                }
            }
        });

        $deleteEvent = method_exists(static::class, 'bootSoftDeletes') ? 'forceDeleted' : 'deleted';

        static::$deleteEvent(function ($model) {
            foreach ($model->getFileFields() as $field) {
                $value = $model->getAttribute($field);
                if (is_array($value)) {
                    foreach ($value as $file) {
                        static::deleteStoredFile($file);
                    }
                } else {
                    static::deleteStoredFile($value);
                }
            }
        });

        static::saving(function ($model) {
            foreach ($model->getFileFields() as $field) {
                if ($model->isDirty($field)) {
                    $value = $model->getAttribute($field);
                    if (is_array($value)) {
                        $converted = [];
                        foreach ($value as $file) {
                            $converted[] = static::processStoredFileToWebP($file);
                        }
                        $model->setAttribute($field, $converted);
                    } else {
                        if (!empty($value)) {
                            $model->setAttribute($field, static::processStoredFileToWebP($value));
                        }
                    }
                }
            }
        });
    }

    protected static function deleteStoredFile(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        // Never attempt to delete external URLs
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return;
        }

        $cleanPath = ltrim($path, '/');

        $disk = Storage::disk('public');
        if ($disk->exists($cleanPath)) {
            // Protect static default template files located directly in root storage
            $isRootDefault = in_array($cleanPath, [
                'banner1.png',
                'banner2.png',
                'workshop-illustration.jpg',
                'logo.png',
            ]);

            if (!$isRootDefault) {
                $disk->delete($cleanPath);
            }
        }
    }

    protected static function processStoredFileToWebP(?string $path): ?string
    {
        if (empty($path)) {
            return $path;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $cleanPath = ltrim($path, '/');

        if (in_array($cleanPath, [
            'banner1.png',
            'banner2.png',
            'workshop-illustration.jpg',
            'logo.png',
        ])) {
            return $cleanPath;
        }

        $fullPath = Storage::disk('public')->path($cleanPath);
        if (file_exists($fullPath)) {
            $newFullPath = ImageOptimizerService::convertToWebP($fullPath);
            if ($newFullPath) {
                $dir = dirname($cleanPath);
                $newFilename = basename($newFullPath);
                return ($dir !== '.' ? $dir . '/' : '') . $newFilename;
            }
        }

        return $cleanPath;
    }

    public function getFileFields(): array
    {
        return property_exists($this, 'fileFields') ? $this->fileFields : [];
    }
}
