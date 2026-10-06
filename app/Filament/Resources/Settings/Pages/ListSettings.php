<?php

namespace App\Filament\Resources\Settings\Pages;

use App\Filament\Resources\Settings\SettingResource;
use App\Models\Setting;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    protected ?string $heading = 'Pengaturan Informasi Workshop';

    // public function getSubheading(): ?string
    // {
    //     return 'Kelola profil bengkel, kontak WhatsApp, jam operasional, dan akun media sosial. Perubahan teks di sini langsung otomatis tampil di website Pelangi Glass.';
    // }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua Pengaturan')
                ->badge(Setting::count()),
            'general' => Tab::make('Profil Bengkel')
                ->icon(Heroicon::OutlinedBuildingStorefront)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('group', 'general'))
                ->badge(Setting::where('group', 'general')->count()),
            'contact' => Tab::make('Kontak & WhatsApp')
                ->icon(Heroicon::OutlinedPhone)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('group', 'contact'))
                ->badge(Setting::where('group', 'contact')->count()),
            'operational' => Tab::make('Jam Operasional')
                ->icon(Heroicon::OutlinedClock)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('group', 'operational'))
                ->badge(Setting::where('group', 'operational')->count()),
            'social' => Tab::make('Media Sosial & Peta')
                ->icon(Heroicon::OutlinedGlobeAlt)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('group', 'social'))
                ->badge(Setting::where('group', 'social')->count()),
        ];
    }
}
