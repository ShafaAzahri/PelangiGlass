<?php

namespace App\Filament\Resources\GalleryItems;

use App\Filament\Resources\GalleryItems\Pages\CreateGalleryItem;
use App\Filament\Resources\GalleryItems\Pages\EditGalleryItem;
use App\Filament\Resources\GalleryItems\Pages\ListGalleryItems;
use App\Models\GalleryItem;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GalleryItemResource extends Resource
{
    protected static ?string $model = GalleryItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|\UnitEnum|null $navigationGroup = 'Konten & Media';

    protected static ?string $navigationLabel = 'Galeri Foto';

    protected static ?string $modelLabel = 'Dokumentasi';

    protected static ?string $pluralModelLabel = 'Galeri Dokumentasi';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Kategori Galeri')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('title')
                    ->label('Judul Dokumentasi')
                    ->placeholder('Contoh: Ganti Kaca Depan Fortuner')
                    ->maxLength(200),
                TextInput::make('car_model')
                    ->label('Tipe Mobil')
                    ->placeholder('Contoh: Toyota Fortuner GR')
                    ->maxLength(150),
                Placeholder::make('current_image_preview')
                    ->label('Foto Saat Ini')
                    ->content(function (?GalleryItem $record) {
                        if (! $record || empty($record->image_url)) {
                            return new \Illuminate\Support\HtmlString('<span class="text-xs text-gray-400">Belum ada foto yang terpasang</span>');
                        }
                        $url = e($record->image_url);
                        return new \Illuminate\Support\HtmlString("
                            <div class='flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 max-w-xl'>
                                <img src='{$url}' alt='Preview Foto' class='h-20 w-28 object-cover rounded-lg shadow-sm border border-gray-300 dark:border-gray-600' />
                                <div class='text-xs space-y-1'>
                                    <div class='font-semibold text-gray-800 dark:text-gray-200'>Foto aktif saat ini</div>
                                    <div class='text-gray-500 dark:text-gray-400 text-[11px] truncate max-w-xs'>{$url}</div>
                                    <div class='text-emerald-600 dark:text-emerald-400 text-[11px] font-medium'>✓ Terpasang. Kosongkan upload jika tidak ingin mengganti.</div>
                                </div>
                            </div>
                        ");
                    })
                    ->visible(fn (?GalleryItem $record) => $record !== null && !empty($record->image_url)),
                FileUpload::make('image_path')
                    ->label('Upload Foto Baru')
                    ->image()
                    ->directory('gallery')
                    ->required(fn (string $operation, ?GalleryItem $record) => $operation === 'create' && empty($record?->image_path))
                    ->dehydrated(fn ($state) => filled($state))
                    ->helperText('Kosongkan upload ini jika tidak ingin mengubah foto yang sudah ada.'),
                Textarea::make('description')
                    ->label('Deskripsi Pekerjaan')
                    ->rows(2)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Tampilkan di Website')
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
                    ->label('Foto')
                    ->width(80)
                    ->height(55)
                    ->extraImgAttributes(['class' => 'object-cover rounded-md shadow-xs'])
                    ->defaultImageUrl(fn (GalleryItem $record) => $record->image_url),
                TextColumn::make('title')
                    ->label('Judul Pengerjaan')
                    ->searchable()
                    ->sortable()
                    ->description(fn (GalleryItem $record) => $record->car_model),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Aktif'),
                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
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
            'index' => ListGalleryItems::route('/'),
            'create' => CreateGalleryItem::route('/create'),
            'edit' => EditGalleryItem::route('/{record}/edit'),
        ];
    }
}
