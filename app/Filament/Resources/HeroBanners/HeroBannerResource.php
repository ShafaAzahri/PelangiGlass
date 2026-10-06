<?php

namespace App\Filament\Resources\HeroBanners;

use App\Filament\Resources\HeroBanners\Pages\CreateHeroBanner;
use App\Filament\Resources\HeroBanners\Pages\EditHeroBanner;
use App\Filament\Resources\HeroBanners\Pages\ListHeroBanners;
use App\Models\HeroBanner;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

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
            ->columns(['lg' => 3, 'default' => 1])
            ->components([
                Section::make('Informasi Teks Banner')
                    ->description('Teks judul, deskripsi, dan tombol CTA')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->columnSpan(['lg' => 2, 'default' => 1])
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Utama Banner')
                            ->placeholder('Contoh: Spesialis Kaca Mobil Terpercaya')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('subtitle')
                            ->label('Subjudul / Narasi Pendukung')
                            ->placeholder('Contoh: Pelayanan cepat, rapi, dan bergaransi resmi sejak 1992')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Grid::make(2)->schema([
                            TextInput::make('button_text')
                                ->label('Teks Tombol CTA')
                                ->placeholder('Contoh: Konsultasi Sekarang')
                                ->maxLength(100),
                            TextInput::make('button_url')
                                ->label('Link URL Tujuan')
                                ->placeholder('Contoh: /#kontak atau https://wa.me/...')
                                ->maxLength(255),
                        ]),
                    ]),

                Section::make('Gambar & Status')
                    ->description('File visual banner dan urutan tampil')
                    ->icon(Heroicon::OutlinedPhoto)
                    ->columnSpan(['lg' => 1, 'default' => 1])
                    ->schema([
                        Placeholder::make('current_image_preview')
                            ->label('Preview Banner Aktif')
                            ->content(function (?HeroBanner $record): ?HtmlString {
                                if (! $record || empty($record->image_url)) {
                                    return null;
                                }
                                $url = e($record->image_url);

                                return new HtmlString("
                                    <div style='display: flex; align-items: center; gap: 12px; padding: 10px; background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 10px; margin-bottom: 8px;'>
                                        <a href='{$url}' target='_blank' rel='noopener noreferrer' title='Klik untuk melihat banner ukuran penuh' style='display: block; cursor: pointer;'>
                                            <img src='{$url}' alt='Banner' style='width: 90px; height: 50px; min-width: 90px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(255, 255, 255, 0.2); display: block;' />
                                        </a>
                                        <div style='font-size: 11px; line-height: 1.4; overflow: hidden;'>
                                            <div style='font-weight: 600; color: #f8fafc; margin-bottom: 2px;'>Banner Terpasang</div>
                                            <a href='{$url}' target='_blank' rel='noopener noreferrer' style='color: #60a5fa; text-decoration: underline; font-weight: 500; display: inline-flex; align-items: center; gap: 4px;'>
                                                🔍 Lihat Resolusi Penuh ↗
                                            </a>
                                        </div>
                                    </div>
                                ");
                            })
                            ->visible(fn (?HeroBanner $record) => $record !== null && ! empty($record->image_url)),
                        FileUpload::make('image_path')
                            ->label('Upload / Ganti Gambar')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg'])
                            ->maxSize(10240)
                            ->disk('public')
                            ->directory('banners')
                            ->imagePreviewHeight('160')
                            ->openable()
                            ->downloadable()
                            ->required(fn (string $operation, ?HeroBanner $record) => $operation === 'create' && empty($record?->image_path))
                            ->dehydrated(fn ($state) => filled($state))
                            ->helperText('💡 Rekomendasi Ukuran: 2048 × 768 px (Rasio 8:3 Landscape Lebar). Format: JPG, PNG, atau WebP (Maks. 5 MB). Otomatis dioptimalkan.'),
                        Grid::make(2)->schema([
                            Toggle::make('is_active')
                                ->label('Aktif')
                                ->default(true),
                            TextInput::make('sort_order')
                                ->label('Urutan')
                                ->numeric()
                                ->default(0),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Gambar Preview')
                    ->width(140)
                    ->height(75)
                    ->extraImgAttributes([
                        'class' => 'object-cover rounded-lg shadow-xs cursor-pointer hover:opacity-80 transition',
                        'title' => 'Klik untuk preview gambar',
                    ])
                    ->defaultImageUrl(asset('images/banner1.png'))
                    ->action(
                        Action::make('preview_banner')
                            ->modalHeading(fn (HeroBanner $record) => 'Preview Banner: '.$record->title)
                            ->modalSubmitAction(false)
                            ->modalCancelActionLabel('Tutup')
                            ->modalContent(fn (HeroBanner $record) => new HtmlString("
                                <div style='display: flex; flex-direction: column; align-items: center; gap: 12px; padding: 8px;'>
                                    <img src='{$record->image_url}' alt='{$record->title}' style='max-height: 65vh; max-width: 100%; border-radius: 8px; object-fit: contain; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);' />
                                    <a href='{$record->image_url}' target='_blank' rel='noopener noreferrer' style='color: #60a5fa; text-decoration: underline; font-size: 13px; font-weight: 500;'>
                                        Buka di tab baru (Resolusi Asli) ↗
                                    </a>
                                </div>
                            "))
                    ),
                TextColumn::make('title')
                    ->label('Judul Banner')
                    ->searchable()
                    ->description(fn (HeroBanner $record) => $record->subtitle),
                TextColumn::make('button_text')
                    ->label('Tombol CTA')
                    ->badge()
                    ->color('gray'),
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
