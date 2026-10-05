<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory, Prunable;
    protected $fillable = [
        'user_id',
        'causer_name',
        'subject_type',
        'subject_id',
        'action',
        'description',
        'properties',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the prunable model query (retain logs for 90 days).
     */
    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subDays(90));
    }

    protected function casts(): array
    {
        return [
            'properties' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function record(
        string $action,
        string $subjectType,
        string $description,
        mixed $subject = null,
        array $properties = []
    ): static {
        $user = auth()->user();

        return static::create([
            'user_id' => $user?->id,
            'causer_name' => $user?->name ?? 'Sistem',
            'subject_type' => $subjectType,
            'subject_id' => $subject ? (string) ($subject->id ?? $subject) : null,
            'action' => $action,
            'description' => $description,
            'properties' => $properties,
            'ip_address' => request()?->ip(),
            'user_agent' => request()?->userAgent(),
        ]);
    }
}
