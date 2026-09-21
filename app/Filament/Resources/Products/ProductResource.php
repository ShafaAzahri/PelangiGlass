<?php

namespace App\Filament\Resources\Products;

use App\Enums\ProductBadge;
use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Pages\EditProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Models\Product;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
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
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingBag;

    protected static string|\UnitEnum|null $navigationGroup = 'Katalog & Servis';

    protected static ?string $navigationLabel = 'Katalog Produk';

    protected static ?string $modelLabel = 'Produk';

    protected static ?string $pluralModelLabel = 'Katalog Produk';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('name')
                    ->label('Nama Produk')
                    ->required()
                    ->maxLength(200)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->label('Slug URL')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(220),
                Select::make('badge')
                    ->label('Badge / Status Promo')
                    ->options(ProductBadge::class),
                TextInput::make('vehicle_compatibility')
                    ->label('Kesesuaian Tipe Mobil')
                    ->placeholder('Contoh: Toyota Avanza 2019–2024 / Semua Mobil')
                    ->maxLength(255),
                TextInput::make('estimated_price')
                    ->label('Harga Estimasi (Rp)')
                    ->numeric()
                    ->prefix('Rp')
                    ->placeholder('Kosongkan bila sistem menampilkan "Tanya Estimasi via WA"'),
                Textarea::make('short_description')
                    ->label('Deskripsi Singkat')
                    ->rows(2)
                    ->columnSpanFull(),
                RichEditor::make('full_description')
                    ->label('Deskripsi Lengkap / Spesifikasi')
                    ->columnSpanFull(),
                Placeholder::make('current_main_image_preview')
                    ->label('Preview Foto Utama')
                    ->content(function (?Product $record): ?HtmlString {
                        if (!$record || empty($record->image_url)) {
                            return null;
                        }
                        $url = e($record->image_url);
                        return new HtmlString("
                            <div class='flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 max-w-xl'>
                                <img src='{$url}' alt='Preview Foto Produk' class='h-20 w-28 object-cover rounded-lg shadow-sm border border-gray-300 dark:border-gray-600' />
                                <div class='text-xs space-y-1'>
                                    <div class='font-semibold text-gray-800 dark:text-gray-200'>Foto utama aktif saat ini</div>
                                    <div class='text-gray-500 dark:text-gray-400 text-[11px] truncate max-w-xs'>{$url}</div>
                                    <div class='text-emerald-600 dark:text-emerald-400 text-[11px] font-medium'>✓ Terpasang. Kosongkan upload jika tidak ingin mengganti.</div>
                                </div>
                            </div>
                        ");
                    })
                    ->visible(fn (?Product $record) => $record !== null && !empty($record->image_url)),
                FileUpload::make('main_image')
                    ->label('Upload Foto Utama Baru')
                    ->image()
                    ->directory('products')
                    ->dehydrated(fn ($state) => filled($state))
                    ->helperText('Kosongkan upload ini jika tidak ingin mengubah foto yang sudah ada.'),
                FileUpload::make('gallery_images')
                    ->label('Galeri Foto Tambahan')
                    ->multiple()
                    ->reorderable()
                    ->image()
                    ->directory('products/gallery')
                    ->dehydrated(fn ($state) => filled($state)),
                Toggle::make('is_active')
                    ->label('Aktif / Tampilkan di Web')
                    ->default(true),
                TextInput::make('sort_order')
                    ->label('Urutan Tampilan')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('main_image')
                    ->label('Foto')
                    ->width(80)
                    ->height(55)
                    ->extraImgAttributes(['class' => 'object-cover rounded-md shadow-xs'])
                    ->defaultImageUrl(fn (Product $record) => $record->image_url),
                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Product $record) => $record->vehicle_compatibility),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                TextColumn::make('badge')
                    ->label('Badge')
                    ->badge(),
                TextColumn::make('estimated_price')
                    ->label('Harga')
                    ->money('IDR', locale: 'id')
                    ->placeholder('Tanya Estimasi')
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
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
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
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
