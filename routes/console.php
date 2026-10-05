<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * Scheduled Tasks & Background Maintenance
 */

// Daily prune of soft deleted or old models (e.g., ActivityLog older than 90 days)
Schedule::command('model:prune')->dailyAt('02:00');

// Daily prune of failed queue jobs and batches older than 48 hours
Schedule::command('queue:prune-failed --hours=48')->dailyAt('02:30');
Schedule::command('queue:prune-batches --hours=48')->dailyAt('02:45');

// Hourly cleanup of stale cache tags (when applicable)
Schedule::command('cache:prune-stale-tags')->hourly();
