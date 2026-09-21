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
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
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
            ->columns(['lg' => 3, 'default' => 1])
            ->components([
                Section::make('Informasi Produk')
                    ->description('Nama, kategori, kesesuaian mobil, dan harga')
                    ->icon(Heroicon::OutlinedShoppingBag)
                    ->columnSpan(['lg' => 2, 'default' => 1])
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Produk')
                            ->placeholder('Contoh: Kaca Film V-KOOL VK 40')
                            ->required()
                            ->maxLength(200)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', Str::slug($state))),
                        Grid::make(2)->schema([
                            Select::make('category_id')
                                ->label('Kategori')
                                ->relationship('category', 'name')
                                ->required()
                                ->searchable()
                                ->preload(),
                            TextInput::make('slug')
                                ->label('Slug URL')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(220),
                        ]),
                        Grid::make(3)->schema([
                            Select::make('badge')
                                ->label('Badge / Status')
                                ->options(ProductBadge::class),
                            TextInput::make('vehicle_compatibility')
                                ->label('Kesesuaian Mobil')
                                ->placeholder('Contoh: Toyota Avanza / Semua Mobil')
                                ->maxLength(255),
                            TextInput::make('estimated_price')
                                ->label('Harga Estimasi (Rp)')
                                ->numeric()
                                ->prefix('Rp')
                                ->placeholder('Opsional (WA)'),
                        ]),
                        Textarea::make('short_description')
                            ->label('Deskripsi Singkat')
                            ->placeholder('Spesifikasi ringkas produk...')
                            ->rows(3)
                            ->columnSpanFull(),
                        RichEditor::make('full_description')
                            ->label('Deskripsi Lengkap / Spesifikasi Detail')
                            ->columnSpanFull(),
                    ]),

                Section::make('Foto & Tampilan')
                    ->description('Foto utama, galeri produk, dan status')
                    ->icon(Heroicon::OutlinedPhoto)
                    ->columnSpan(['lg' => 1, 'default' => 1])
                    ->schema([
                        Placeholder::make('current_main_image_preview')
                            ->label('Foto Utama Aktif')
                            ->content(function (?Product $record): ?HtmlString {
                                if (!$record || empty($record->image_url)) {
                                    return null;
                                }
                                $url = e($record->image_url);
                                return new HtmlString("
                                    <div style='display: flex; align-items: center; gap: 12px; padding: 10px; background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 10px; margin-bottom: 8px;'>
                                        <img src='{$url}' alt='Produk' style='width: 72px; height: 54px; min-width: 72px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(255, 255, 255, 0.2); display: block;' />
                                        <div style='font-size: 11px; line-height: 1.35; overflow: hidden;'>
                                            <div style='font-weight: 600; color: #f8fafc; margin-bottom: 2px;'>Foto Utama Terpasang</div>
                                            <div style='color: #22c55e; font-weight: 500;'>✓ Aktif di website</div>
                                        </div>
                                    </div>
                                ");
                            })
                            ->visible(fn (?Product $record) => $record !== null && !empty($record->image_url)),
                        FileUpload::make('main_image')
                            ->label('Upload / Ganti Foto Utama')
                            ->image()
                            ->disk('public')
                            ->directory('products')
                            ->imagePreviewHeight('180')
                            ->dehydrated(fn ($state) => filled($state))
                            ->helperText('Kosongkan upload ini jika tidak ingin mengubah foto utama.'),
                        FileUpload::make('gallery_images')
                            ->label('Galeri Foto Tambahan')
                            ->multiple()
                            ->reorderable()
                            ->image()
                            ->disk('public')
                            ->directory('products/gallery')
                            ->imagePreviewHeight('120')
                            ->dehydrated(fn ($state) => filled($state)),
                        Toggle::make('is_active')
                            ->label('Aktif / Tampilkan di Web')
                            ->default(true),
                        TextInput::make('sort_order')
                            ->label('Urutan Tampilan')
                            ->numeric()
                            ->default(0),
                    ]),
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
