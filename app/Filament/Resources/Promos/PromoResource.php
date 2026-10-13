<?php

namespace App\Filament\Resources\Promos;

use App\Filament\Resources\Promos\Pages\CreatePromo;
use App\Filament\Resources\Promos\Pages\EditPromo;
use App\Filament\Resources\Promos\Pages\ListPromos;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Promo;
use BackedEnum;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
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
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class PromoResource extends Resource
{
    protected static ?string $model = Promo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|\UnitEnum|null $navigationGroup = 'Interaksi Pelanggan';

    protected static ?string $navigationLabel = 'Promo & Penawaran';

    protected static ?string $modelLabel = 'Promo';

    protected static ?string $pluralModelLabel = 'Promo & Penawaran';

    protected static ?int $navigationSort = 1;

    public static function calculateDiscount(callable $set, ?string $originalPrice, ?string $discountPercent): void
    {
        if (! $originalPrice || ! $discountPercent) {
            return;
        }

        $cleanOriginal = (int) preg_replace('/[^\d]/', '', $originalPrice);
        $cleanPercent = (float) preg_replace('/[^\d.]/', '', $discountPercent);

        if ($cleanOriginal > 0 && $cleanPercent > 0) {
            $hemat = (int) round($cleanOriginal * ($cleanPercent / 100));
            $promoPrice = $cleanOriginal - $hemat;

            $set('promo_price', 'Rp '.number_format($promoPrice, 0, ',', '.'));
            $set('discount_percent', $cleanPercent.'%');
            $set('badge', $cleanPercent.'%');
            $set('discount', null);
        }
    }

    public static function syncValidUntil(callable $set, ?string $start, ?string $end): void
    {
        if ($start && $end) {
            $startDate = Carbon::parse($start)->translatedFormat('d F Y');
            $endDate = Carbon::parse($end)->translatedFormat('d F Y');
            $set('valid_until', "{$startDate} s/d {$endDate}");
        } elseif ($end) {
            $set('valid_until', Carbon::parse($end)->translatedFormat('d F Y'));
        } elseif ($start) {
            $set('valid_until', Carbon::parse($start)->translatedFormat('d F Y'));
        }
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['lg' => 3, 'default' => 1])
            ->components([
                Section::make('Informasi Promo & Diskon')
                    ->description('Detail penawaran promo spesial pelanggan')
                    ->icon(Heroicon::OutlinedSparkles)
                    ->columnSpan(['lg' => 2, 'default' => 1])
                    ->schema([
                        Select::make('product_id')
                            ->label('Pilih Produk yang Ingin Dipromosikan (Opsional)')
                            ->helperText('Pilih produk dari database untuk mengisi otomatis nama, kategori, foto, deskripsi, harga asli, dan tipe mobil.')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if (! $state) {
                                    return;
                                }

                                $product = Product::with('category')->find($state);
                                if (! $product) {
                                    return;
                                }

                                $set('name', 'Promo '.$product->name);
                                $set('slug', Str::slug('promo-'.$product->name));

                                if ($product->category?->name) {
                                    $set('category', $product->category->name);
                                }

                                $desc = $product->short_description ?: $product->full_description;
                                if ($desc) {
                                    $set('desc', $desc);
                                }

                                if ($product->vehicle_compatibility) {
                                    $set('vehicle_compatibility', $product->vehicle_compatibility);
                                }

                                if ($product->estimated_price) {
                                    $formatted = 'Rp '.number_format($product->estimated_price, 0, ',', '.');
                                    $set('original_price', $formatted);
                                    static::calculateDiscount($set, $formatted, $get('discount_percent'));
                                }

                                if ($product->main_image) {
                                    $set('img', $product->main_image);
                                }

                                if (! $get('valid_until')) {
                                    $set('valid_until', now()->translatedFormat('d F Y').' s/d '.now()->addMonth()->translatedFormat('d F Y'));
                                }
                                if (! $get('start_date')) {
                                    $set('start_date', now()->toDateString());
                                }
                                if (! $get('end_date')) {
                                    $set('end_date', now()->addMonth()->toDateString());
                                }
                            }),
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Nama Promo')
                                ->required()
                                ->maxLength(150)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($set, ?string $state) => $set('slug', Str::slug($state))),
                            TextInput::make('slug')
                                ->label('URL Slug')
                                ->required()
                                ->unique(ignoreRecord: true),
                        ]),
                        Select::make('category')
                            ->label('Kategori Promo')
                            ->options(fn () => array_unique(array_merge(
                                [
                                    'Kaca Film' => 'Kaca Film',
                                    'Ganti Kaca' => 'Ganti Kaca',
                                    'Perbaikan Kaca' => 'Perbaikan Kaca',
                                    'Aksesoris & Perawatan' => 'Aksesoris & Perawatan',
                                ],
                                ProductCategory::pluck('name', 'name')->toArray()
                            )))
                            ->searchable()
                            ->required(),
                        Textarea::make('desc')
                            ->label('Deskripsi Ringkas Promo')
                            ->rows(3)
                            ->required(),
                        Grid::make(3)->schema([
                            TextInput::make('original_price')
                                ->label('Harga Asli')
                                ->placeholder('Contoh: Rp 2.800.000')
                                ->helperText('Harga sebelum promo.')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, callable $set, callable $get) => static::calculateDiscount($set, $state, $get('discount_percent'))),
                            TextInput::make('discount_percent')
                                ->label('Potongan Diskon (%)')
                                ->placeholder('Contoh: 20')
                                ->suffix('%')
                                ->helperText('Ketik angka diskon, harga promo akan terhitung otomatis.')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, callable $set, callable $get) => static::calculateDiscount($set, $get('original_price'), $state)),
                            TextInput::make('promo_price')
                                ->label('Harga Promo Spesial')
                                ->placeholder('Contoh: Rp 2.240.000')
                                ->helperText('Terhitung otomatis setelah diskon diterapkan.')
                                ->required(),
                        ]),
                        Grid::make(2)->schema([
                            DatePicker::make('start_date')
                                ->label('Mulai Berlaku Dari Tanggal')
                                ->native(false)
                                ->displayFormat('d F Y')
                                ->default(now())
                                ->required()
                                ->live()
                                ->afterStateUpdated(fn ($state, callable $set, callable $get) => static::syncValidUntil($set, $state, $get('end_date'))),
                            DatePicker::make('end_date')
                                ->label('Berlaku Sampai Tanggal')
                                ->native(false)
                                ->displayFormat('d F Y')
                                ->default(now()->addMonth())
                                ->required()
                                ->live()
                                ->afterStateUpdated(fn ($state, callable $set, callable $get) => static::syncValidUntil($set, $get('start_date'), $state)),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('valid_until')
                                ->label('Keterangan Masa Berlaku di Web')
                                ->placeholder('Contoh: 13 Oktober 2026 s/d 13 November 2026')
                                ->helperText('Otomatis terisi dari rentang tanggal mulai s/d berakhir di atas.')
                                ->default(now()->translatedFormat('d F Y').' s/d '.now()->addMonth()->translatedFormat('d F Y'))
                                ->required(),
                            TextInput::make('vehicle_compatibility')
                                ->label('Kesesuaian Tipe Mobil')
                                ->placeholder('Contoh: Universal (Semua Tipe Mobil)')
                                ->default('Universal (Semua Tipe Mobil)'),
                        ]),
                        TagsInput::make('benefits')
                            ->label('Keuntungan & Fasilitas Promo (Benefits)')
                            ->placeholder('Ketik poin keuntungan lalu tekan Enter...')
                            ->helperText('Contoh: Garansi resmi 5 tahun, Gratis Wiper Bosch, Pemasangan di ruang ber-AC.'),
                    ]),

                Section::make('Foto & Publikasi')
                    ->description('File visual dan status tayang di web')
                    ->icon(Heroicon::OutlinedPhoto)
                    ->columnSpan(['lg' => 1, 'default' => 1])
                    ->schema([
                        Placeholder::make('current_image_preview')
                            ->label('Foto Promo Saat Ini')
                            ->content(function (?Promo $record): ?HtmlString {
                                if (! $record || empty($record->image_url)) {
                                    return null;
                                }
                                $url = e($record->image_url);

                                return new HtmlString("
                                    <div style='display: flex; align-items: center; gap: 12px; padding: 10px; background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 10px; margin-bottom: 8px;'>
                                        <a href='{$url}' target='_blank' rel='noopener noreferrer' title='Klik untuk melihat foto ukuran penuh' style='display: block; cursor: pointer;'>
                                            <img src='{$url}' alt='Promo' style='width: 72px; height: 54px; min-width: 72px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(255, 255, 255, 0.2); display: block;' />
                                        </a>
                                        <div style='font-size: 11px; line-height: 1.4; overflow: hidden;'>
                                            <div style='font-weight: 600; color: #f8fafc; margin-bottom: 2px;'>Foto Terpasang</div>
                                            <a href='{$url}' target='_blank' rel='noopener noreferrer' style='color: #60a5fa; text-decoration: underline; font-weight: 500; display: inline-flex; align-items: center; gap: 4px;'>
                                                🔍 Lihat Resolusi Penuh ↗
                                            </a>
                                        </div>
                                    </div>
                                ");
                            })
                            ->visible(fn (?Promo $record) => $record !== null && ! empty($record->image_url)),
                        FileUpload::make('img')
                            ->label('Upload / Ganti Foto Promo')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg'])
                            ->maxSize(10240)
                            ->disk('public')
                            ->directory('promos')
                            ->imagePreviewHeight('180')
                            ->openable()
                            ->downloadable()
                            ->dehydrated(fn ($state) => filled($state))
                            ->helperText('Rekomendasi ukuran: 800 x 600 piksel (rasio 4:3) atau 1200 x 675 piksel (rasio 16:9). Format yang didukung: JPG, JPEG, PNG, WebP. Ukuran file maksimal: 10 MB.'),
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
                ImageColumn::make('img')
                    ->label('Foto')
                    ->width(80)
                    ->height(55)
                    ->extraImgAttributes([
                        'class' => 'object-cover rounded-md shadow-xs cursor-pointer hover:opacity-80 transition',
                        'title' => 'Klik untuk preview gambar',
                    ])
                    ->defaultImageUrl(fn (Promo $record) => $record->image_url)
                    ->action(
                        Action::make('preview_promo_img')
                            ->modalHeading(fn (Promo $record) => 'Preview Promo: '.$record->name)
                            ->modalSubmitAction(false)
                            ->modalCancelActionLabel('Tutup')
                            ->modalContent(fn (Promo $record) => new HtmlString("
                                <div style='display: flex; flex-direction: column; align-items: center; gap: 12px; padding: 8px;'>
                                    <img src='{$record->image_url}' alt='{$record->name}' style='max-height: 65vh; max-width: 100%; border-radius: 8px; object-fit: contain; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);' />
                                    <a href='{$record->image_url}' target='_blank' rel='noopener noreferrer' style='color: #60a5fa; text-decoration: underline; font-size: 13px; font-weight: 500;'>
                                        Buka di tab baru (Resolusi Asli) ↗
                                    </a>
                                </div>
                            "))
                    ),
                TextColumn::make('name')
                    ->label('Nama Promo')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('product.name')
                    ->label('Produk')
                    ->placeholder('Promo Umum')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('discount_percent')
                    ->label('Diskon')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('promo_price')
                    ->label('Harga Promo')
                    ->description(fn (Promo $record) => $record->original_price ? 'Normal: '.$record->original_price : null),
                TextColumn::make('valid_until')
                    ->label('Masa Berlaku')
                    ->badge()
                    ->color('gray'),
                ToggleColumn::make('is_active')
                    ->label('Aktif'),
            ])
            ->filters([
                SelectFilter::make('product_id')
                    ->label('Produk Terkait')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'Kaca Film' => 'Kaca Film',
                        'Ganti Kaca' => 'Ganti Kaca',
                        'Perbaikan Kaca' => 'Perbaikan Kaca',
                        'Aksesoris & Perawatan' => 'Aksesoris & Perawatan',
                    ]),
            ])
            ->recordActions([
                ReplicateAction::make()
                    ->label('Duplikat')
                    ->color('gray')
                    ->excludeAttributes(['slug'])
                    ->beforeReplicaSaved(function (Promo $replica): void {
                        $replica->name = $replica->name.' (Copy)';
                        $replica->slug = Str::slug($replica->name.'-'.Str::random(5));
                    }),
                EditAction::make()->label('Ubah')->color('gray'),
                DeleteAction::make()->label('Hapus')->color('gray'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPromos::route('/'),
            'create' => CreatePromo::route('/create'),
            'edit' => EditPromo::route('/{record}/edit'),
        ];
    }
}
