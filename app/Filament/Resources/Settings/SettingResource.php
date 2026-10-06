<?php

namespace App\Filament\Resources\Settings;

use App\Filament\Resources\Settings\Pages\ListSettings;
use App\Models\Setting;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAdjustmentsHorizontal;

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan Sistem';

    protected static ?string $navigationLabel = 'Pengaturan Workshop';

    protected static ?string $modelLabel = 'Pengaturan';

    protected static ?string $pluralModelLabel = 'Pengaturan Workshop';

    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Placeholder::make('info')
                    ->label('Keterangan Pengaturan')
                    ->content(fn (?Setting $record): ?HtmlString => $record ? new HtmlString("
                        <div style='padding: 10px 14px; background: rgba(37, 99, 235, 0.08); border-left: 4px solid #2563eb; border-radius: 6px; font-size: 13px; color: #1e293b; line-height: 1.45;'>
                            <div style='font-weight: 700; color: #1e40af; margin-bottom: 2px;'>".e(Setting::humanName($record->key)).' ('.e(Setting::humanGroup($record->group)).")</div>
                            <div style='color: #475569;'>".e(Setting::humanDescription($record->key)).'</div>
                        </div>
                    ') : null),
                Textarea::make('value')
                    ->label('Nilai / Teks Pengaturan Baru')
                    ->rows(fn (?Setting $record) => $record && in_array($record->key, ['address', 'google_maps_embed']) ? 4 : 2)
                    ->required()
                    ->helperText(function (?Setting $record) {
                        if (! $record) {
                            return 'Teks ini akan otomatis tersimpan dan langsung tampil di website utama.';
                        }

                        return match ($record->key) {
                            'whatsapp' => 'Format nomor WhatsApp internasional tanpa tanda + atau spasi, contoh: 6281390288875.',
                            'phone' => 'Nomor telepon kantor, contoh: +62 813-9028-8875.',
                            'google_maps_embed' => 'Link URL sematan iframe dari Google Maps (biasanya diawali https://maps.google.com/...).',
                            'years_experience' => 'Lama pengalaman bengkel, contoh: 30+ atau 32 Tahun.',
                            'operational_hours' => 'Jam operasional hari kerja, contoh: Senin – Jumat, 08.30 – 16.30 WIB.',
                            'operational_hours_weekend' => 'Jam operasional akhir pekan, contoh: Sabtu & Minggu: Tutup (Janji Temu via WA).',
                            'instagram' => 'Username atau link Instagram, contoh: @pelangiglassofficial.',
                            default => 'Teks ini akan otomatis tersimpan dan langsung tampil di website utama.',
                        };
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Nama Pengaturan')
                    ->formatStateUsing(fn (string $state): string => Setting::humanName($state))
                    ->description(fn (Setting $record): string => Setting::humanDescription($record->key))
                    ->icon(fn (Setting $record): BackedEnum => match ($record->group) {
                        'general' => Heroicon::OutlinedBuildingStorefront,
                        'contact' => Heroicon::OutlinedPhone,
                        'operational' => Heroicon::OutlinedClock,
                        'social' => Heroicon::OutlinedGlobeAlt,
                        default => Heroicon::OutlinedAdjustmentsHorizontal,
                    })
                    ->iconColor('gray')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('value')
                    ->label('Nilai / Konten Saat Ini')
                    ->limit(75)
                    ->wrap()
                    ->copyable()
                    ->copyMessage('Nilai disalin ke clipboard'),
                TextColumn::make('group')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Setting::humanGroup($state))
                    ->color('gray')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('group')
                    ->label('Kategori')
                    ->options([
                        'general' => 'Profil Bengkel',
                        'contact' => 'Kontak & WhatsApp',
                        'operational' => 'Jam Buka',
                        'social' => 'Media Sosial',
                    ]),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Ubah')
                    ->icon(Heroicon::OutlinedPencilSquare)
                    ->color('gray')
                    ->modalHeading(fn (Setting $record): string => 'Ubah: '.Setting::humanName($record->key))
                    ->modalDescription(fn (Setting $record): string => Setting::humanDescription($record->key))
                    ->modalSubmitActionLabel('Simpan Perubahan')
                    ->modalWidth('lg')
                    ->form([
                        Placeholder::make('info')
                            ->label('Petunjuk Pengaturan')
                            ->content(fn (Setting $record): HtmlString => new HtmlString("
                                <div style='padding: 10px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-left: 3px solid #64748b; border-radius: 6px; font-size: 13px; color: #334155; line-height: 1.45;'>
                                    <div style='font-weight: 700; color: #0f172a; margin-bottom: 2px;'>".e(Setting::humanName($record->key)).' ('.e(Setting::humanGroup($record->group)).")</div>
                                    <div style='color: #64748b;'>".e(Setting::humanDescription($record->key)).'</div>
                                </div>
                            ')),
                        Textarea::make('value')
                            ->label('Nilai / Teks Pengaturan Baru')
                            ->rows(fn (Setting $record) => in_array($record->key, ['address', 'google_maps_embed']) ? 4 : 2)
                            ->required()
                            ->helperText(function (Setting $record) {
                                return match ($record->key) {
                                    'whatsapp' => 'Format nomor WhatsApp internasional tanpa tanda + atau spasi, contoh: 6281390288875.',
                                    'phone' => 'Nomor telepon kantor, contoh: +62 813-9028-8875.',
                                    'google_maps_embed' => 'Link URL sematan iframe dari Google Maps (biasanya diawali https://maps.google.com/...).',
                                    'years_experience' => 'Lama pengalaman bengkel, contoh: 30+ atau 32 Tahun.',
                                    'operational_hours' => 'Jam operasional hari kerja, contoh: Senin – Jumat, 08.30 – 16.30 WIB.',
                                    'operational_hours_weekend' => 'Jam operasional akhir pekan, contoh: Sabtu & Minggu: Tutup (Janji Temu via WA).',
                                    'instagram' => 'Username atau link Instagram, contoh: @pelangiglassofficial.',
                                    default => 'Teks ini akan otomatis tersimpan dan langsung tampil di website utama.',
                                };
                            }),
                    ]),
            ])
            ->toolbarActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSettings::route('/'),
        ];
    }
}
