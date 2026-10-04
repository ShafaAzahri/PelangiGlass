<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    public static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            $name = $model->getActivityLogSubjectName();
            $title = $model->getActivityLogTitle();

            ActivityLog::record(
                action: 'Dibuat',
                subjectType: $name,
                description: "Menambahkan {$name} baru: '{$title}'",
                subject: $model,
                properties: [
                    'attributes' => array_diff_key($model->getAttributes(), array_flip(['password', 'remember_token'])),
                ]
            );
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            // Ignore timestamps only
            unset($changes['updated_at']);

            if (empty($changes)) {
                return;
            }

            $name = $model->getActivityLogSubjectName();
            $title = $model->getActivityLogTitle();

            $old = [];
            foreach ($changes as $key => $newValue) {
                if (in_array($key, ['password', 'remember_token'])) continue;
                $old[$key] = $model->getOriginal($key);
            }

            ActivityLog::record(
                action: 'Diperbarui',
                subjectType: $name,
                description: "Memperbarui {$name}: '{$title}'",
                subject: $model,
                properties: [
                    'old' => $old,
                    'new' => array_diff_key($changes, array_flip(['password', 'remember_token'])),
                ]
            );
        });

        $deleteEvent = method_exists(static::class, 'bootSoftDeletes') ? 'deleted' : 'deleted';

        static::$deleteEvent(function ($model) {
            $name = $model->getActivityLogSubjectName();
            $title = $model->getActivityLogTitle();

            ActivityLog::record(
                action: 'Dihapus',
                subjectType: $name,
                description: "Menghapus {$name}: '{$title}'",
                subject: $model,
                properties: [
                    'attributes' => array_diff_key($model->getAttributes(), array_flip(['password', 'remember_token'])),
                ]
            );
        });
    }

    public function getActivityLogTitle(): string
    {
        return $this->name
            ?? $this->title
            ?? $this->question
            ?? $this->key
            ?? ('#' . $this->getKey());
    }

    public function getActivityLogSubjectName(): string
    {
        if (property_exists($this, 'activitySubjectName')) {
            return $this->activitySubjectName;
        }

        return class_basename(static::class);
    }
}
