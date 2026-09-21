<?php

namespace App\Filament\Resources\HeroBanners;

use App\Filament\Resources\HeroBanners\Pages\CreateHeroBanner;
use App\Filament\Resources\HeroBanners\Pages\EditHeroBanner;
use App\Filament\Resources\HeroBanners\Pages\ListHeroBanners;
use App\Models\HeroBanner;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class HeroBannerResource extends Resource
{
    protected static ?string $model = HeroBanner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan Sistem';

    protected static ?string $navigationLabel = 'Banner Beranda';

    protected static ?string $modelLabel = 'Banner';

    protected static ?string $pluralModelLabel = 'Banner Beranda';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Utama Banner')
                    ->maxLength(255),
                TextInput::make('subtitle')
                    ->label('Subjudul / Narasi')
                    ->maxLength(255),
                Placeholder::make('current_image_preview')
                    ->label('Preview Gambar Banner Saat Ini')
                    ->content(function (?HeroBanner $record) {
                        if (! $record || empty($record->image_url)) {
                            return new \Illuminate\Support\HtmlString('<span class="text-xs text-gray-400">Belum ada gambar yang terpasang</span>');
                        }
                        $url = e($record->image_url);
                        return new \Illuminate\Support\HtmlString("
                            <div class='flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 max-w-xl'>
                                <img src='{$url}' alt='Preview Banner' class='h-20 w-36 object-cover rounded-lg shadow-sm border border-gray-300 dark:border-gray-600' />
                                <div class='text-xs space-y-1'>
                                    <div class='font-semibold text-gray-800 dark:text-gray-200'>Banner aktif saat ini</div>
                                    <div class='text-gray-500 dark:text-gray-400 text-[11px] truncate max-w-xs'>{$url}</div>
                                    <div class='text-emerald-600 dark:text-emerald-400 text-[11px] font-medium'>✓ Terpasang. Kosongkan upload di bawah jika tidak ingin mengganti.</div>
                                </div>
                            </div>
                        ");
                    })
                    ->visible(fn (?HeroBanner $record) => $record !== null && !empty($record->image_url)),
                FileUpload::make('image_path')
                    ->label('Upload File Gambar Banner')
                    ->image()
                    ->directory('banners')
                    ->required(fn (string $operation, ?HeroBanner $record) => $operation === 'create' && empty($record?->image_path))
                    ->dehydrated(fn ($state) => filled($state))
                    ->helperText('Format: JPG/PNG/WEBP. Kosongkan jika tidak ingin mengubah gambar banner yang sudah ada.'),
                TextInput::make('button_text')
                    ->label('Teks Tombol CTA')
                    ->placeholder('Contoh: Konsultasi Sekarang')
                    ->maxLength(100),
                TextInput::make('button_url')
                    ->label('Link URL Tujuan Tombol')
                    ->placeholder('Contoh: /#kontak atau https://wa.me/...')
                    ->maxLength(255),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
                TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Gambar Preview')
                    ->width(140)
                    ->height(75)
                    ->extraImgAttributes(['class' => 'object-cover rounded-lg shadow-xs'])
                    ->defaultImageUrl(asset('banner1.png')),
                TextColumn::make('title')
                    ->label('Judul Banner')
                    ->searchable()
                    ->description(fn (HeroBanner $record) => $record->subtitle),
                TextColumn::make('button_text')
                    ->label('Tombol CTA')
                    ->badge()
                    ->color('info'),
                ToggleColumn::make('is_active')
                    ->label('Aktif'),
                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
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
            'index' => ListHeroBanners::route('/'),
            'create' => CreateHeroBanner::route('/create'),
            'edit' => EditHeroBanner::route('/{record}/edit'),
        ];
    }
}
