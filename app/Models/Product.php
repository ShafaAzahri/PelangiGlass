<?php

namespace App\Models;

use App\Enums\ProductBadge;
use App\Traits\HasAutoCleanupFiles;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasAutoCleanupFiles, LogsActivity;

    protected string $activitySubjectName = 'Produk';

    protected array $fileFields = ['main_image', 'gallery_images'];

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'badge',
        'vehicle_compatibility',
        'short_description',
        'full_description',
        'estimated_price',
        'main_image',
        'gallery_images',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'badge' => ProductBadge::class,
            'estimated_price' => 'decimal:2',
            'gallery_images' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->main_image)) {
            return asset('banner-tint.jpg');
        }

        if (str_starts_with($this->main_image, 'http://') || str_starts_with($this->main_image, 'https://')) {
            return $this->main_image;
        }

        $cleanPath = ltrim($this->main_image, '/');

        if (file_exists(public_path('storage/' . $cleanPath))) {
            return asset('storage/' . $cleanPath);
        }

        if (file_exists(public_path($cleanPath))) {
            return asset($cleanPath);
        }

        return asset('storage/' . $cleanPath);
    }
}
