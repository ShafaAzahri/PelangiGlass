<?php

namespace App\Filament\Resources\Settings;

use App\Filament\Resources\Settings\Pages\CreateSetting;
use App\Filament\Resources\Settings\Pages\EditSetting;
use App\Filament\Resources\Settings\Pages\ListSettings;
use App\Models\Setting;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAdjustmentsHorizontal;

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan Sistem';

    protected static ?string $navigationLabel = 'Pengaturan Workshop';

    protected static ?string $modelLabel = 'Pengaturan';

    protected static ?string $pluralModelLabel = 'Pengaturan Workshop';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konfigurasi Pengaturan Workshop')
                    ->description('Kelola identitas bengkel, kontak, jam buka operasional, dan media sosial')
                    ->icon(Heroicon::OutlinedAdjustmentsHorizontal)
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('key')
                                ->label('Nama Pengaturan')
                                ->options([
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
                                    'years_experience' => 'Lama Pengalaman Workshop',
                                ])
                                ->required()
                                ->disabled(fn (?Setting $record) => $record !== null)
                                ->helperText(fn (?Setting $record) => $record ? Setting::humanDescription($record->key) : 'Pilih pengaturan yang ingin dikonfigurasi.'),
                            Select::make('group')
                                ->label('Kategori Pengaturan')
                                ->options([
                                    'general' => 'Profil Bengkel',
                                    'contact' => 'Kontak & WhatsApp',
                                    'operational' => 'Jam Buka',
                                    'social' => 'Media Sosial',
                                ])
                                ->required(),
                        ]),
                        Textarea::make('value')
                            ->label('Isi / Teks Pengaturan')
                            ->placeholder('Masukkan isi pengaturan di sini...')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Perubahan teks ini akan otomatis tampil di bagian terkait pada website utama.'),
                    ]),
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
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('value')
                    ->label('Isi / Nilai')
                    ->limit(80)
                    ->wrap(),
                TextColumn::make('group')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Setting::humanGroup($state))
                    ->color(fn (string $state): string => match ($state) {
                        'general' => 'primary',
                        'contact' => 'success',
                        'operational' => 'warning',
                        'social' => 'info',
                        default => 'gray',
                    })
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
                EditAction::make()->label('Ubah'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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
            'create' => CreateSetting::route('/create'),
            'edit' => EditSetting::route('/{record}/edit'),
        ];
    }
}
