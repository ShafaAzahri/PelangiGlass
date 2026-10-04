<?php

namespace App\Filament\Resources\ActivityLogs\Pages;

use App\Filament\Resources\ActivityLogs\ActivityLogResource;
use Filament\Resources\Pages\ListRecords;

class ListActivityLogs extends ListRecords
{
    protected static string $resource = ActivityLogResource::class;

    protected ?string $heading = 'Catatan Aktivitas Admin (Audit Log)';

    public function getSubheading(): ?string
    {
        return 'Rekam jejak seluruh aktivitas penambahan, pengubahan, dan penghapusan data CMS oleh pengguna atau sistem.';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
