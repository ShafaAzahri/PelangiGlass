<?php

namespace App\Models;

use App\Traits\HasAutoCleanupFiles;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promo extends Model
{
    use HasAutoCleanupFiles, HasFactory, LogsActivity;

    protected string $activitySubjectName = 'Promo';

    protected array $fileFields = ['img'];

    protected $appends = ['image_url'];

    protected $fillable = [
        'product_id',
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
        'start_date',
        'end_date',
        'vehicle_compatibility',
        'benefits',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'benefits' => 'array',
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->img)) {
            return '/images/banner1.png';
        }

        if (str_starts_with($this->img, 'http://') || str_starts_with($this->img, 'https://')) {
            return $this->img;
        }

        $cleanPath = ltrim($this->img, '/');

        if (file_exists(public_path('storage/'.$cleanPath))) {
            return '/storage/'.$cleanPath;
        }

        if (file_exists(public_path($cleanPath))) {
            return '/'.$cleanPath;
        }

        return '/storage/'.$cleanPath;
    }
}
