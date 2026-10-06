<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    /** @var array<string, string|null>|null */
    protected static ?array $cachedSettings = null;

    public static function allKeyed(): array
    {
        if (static::$cachedSettings !== null) {
            return static::$cachedSettings;
        }

        try {
            static::$cachedSettings = static::pluck('value', 'key')->toArray();
        } catch (\Throwable $e) {
            static::$cachedSettings = [];
        }

        return static::$cachedSettings;
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        $settings = static::allKeyed();

        return $settings[$key] ?? $default;
    }

    public static function set(string $key, ?string $value, string $group = 'general'): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
        static::clearCache();
    }

    public static function clearCache(): void
    {
        static::$cachedSettings = null;
    }

    public static function cleanWhatsapp(?string $default = '6281390288875'): string
    {
        $raw = static::get('whatsapp', $default) ?? $default ?? '';
        $clean = preg_replace('/[^0-9]/', '', $raw);
        if (str_starts_with($clean, '0')) {
            $clean = '62'.substr($clean, 1);
        }

        return $clean ?: ($default ?? '6281390288875');
    }

    public static function whatsappUrl(string $text = '', ?string $defaultNumber = null): string
    {
        $number = static::cleanWhatsapp($defaultNumber);
        $encodedText = urlencode($text);

        return "https://wa.me/{$number}".($encodedText !== '' ? "?text={$encodedText}" : '');
    }

    public static function humanName(string $key): string
    {
        return match ($key) {
            'site_name' => 'Nama Bengkel / Website',
            'tagline' => 'Slogan / Tagline',
            'phone' => 'Nomor Telepon Kantor',
            'whatsapp' => 'Nomor WhatsApp Resmi',
            'address' => 'Alamat Lengkap Workshop',
            'operational_hours' => 'Jam Buka (Senin – Jumat)',
            'operational_hours_weekend' => 'Jam Buka (Sabtu & Minggu)',
            'instagram' => 'Akun Instagram',
            'facebook' => 'Halaman Facebook',
            'youtube' => 'Channel YouTube',
            'google_maps_embed' => 'Link Peta Google Maps',
            'years_experience' => 'Lama Pengalaman Workshop (Beranda & Tentang)',
            default => ucwords(str_replace('_', ' ', $key)),
        };
    }

    public static function humanDescription(string $key): string
    {
        return match ($key) {
            'site_name' => 'Nama brand atau workshop yang tampil di header & footer',
            'tagline' => 'Kalimat slogan bengkel di bawah judul utama',
            'phone' => 'Nomor telepon untuk panggilan telepon kantor bengkel',
            'whatsapp' => 'Nomor tujuan tombol WhatsApp konsultasi (awali dengan 62)',
            'address' => 'Alamat fisik bengkel yang tampil di halaman kontak dan footer',
            'operational_hours' => 'Jadwal jam kerja operasional bengkel di hari kerja',
            'operational_hours_weekend' => 'Jadwal jam buka di akhir pekan atau info janji temu',
            'instagram' => 'Username atau tautan akun Instagram resmi bengkel',
            'facebook' => 'Tautan / link ke halaman Facebook Pelangi Glass',
            'youtube' => 'Tautan / link ke channel YouTube resmi bengkel',
            'google_maps_embed' => 'URL sematan (embed) peta lokasi workshop dari Google Maps',
            'years_experience' => 'Lama pengalaman bengkel melayani pelanggan (contoh: 30+). Otomatis sinkron di halaman Beranda dan Tentang Kami.',
            default => 'Pengaturan konfigurasi website',
        };
    }

    public static function humanGroup(string $group): string
    {
        return match ($group) {
            'general' => 'Profil Bengkel',
            'contact' => 'Kontak & WhatsApp',
            'operational' => 'Jam Buka',
            'social' => 'Media Sosial',
            default => ucfirst($group),
        };
    }
}
