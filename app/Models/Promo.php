<?php

namespace App\Models;

use App\Traits\HasAutoCleanupFiles;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory, HasAutoCleanupFiles, LogsActivity;

    protected string $activitySubjectName = 'Promo';

    protected array $fileFields = ['img'];

    protected $fillable = [
        'name',
        'slug',
        'category',
        'desc',
        'img',
        'badge',
        'original_price',
        'promo_price',
        'discount_percent',
        'discount',
        'code',
        'valid_until',
        'vehicle_compatibility',
        'benefits',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'benefits' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->img)) {
            return asset('banner1.png');
        }

        if (str_starts_with($this->img, 'http://') || str_starts_with($this->img, 'https://')) {
            return $this->img;
        }

        $cleanPath = ltrim($this->img, '/');

        if (file_exists(public_path('storage/' . $cleanPath))) {
            return asset('storage/' . $cleanPath);
        }

        if (file_exists(public_path($cleanPath))) {
            return asset($cleanPath);
        }

        return asset('storage/' . $cleanPath);
    }
}
