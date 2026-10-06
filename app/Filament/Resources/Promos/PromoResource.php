<?php

namespace App\Filament\Resources\Promos;

use App\Filament\Resources\Promos\Pages\CreatePromo;
use App\Filament\Resources\Promos\Pages\EditPromo;
use App\Filament\Resources\Promos\Pages\ListPromos;
use App\Models\Promo;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
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
                        Grid::make(3)->schema([
                            Select::make('category')
                                ->label('Kategori Promo')
                                ->options([
                                    'Kaca Film' => 'Kaca Film',
                                    'Ganti Kaca' => 'Ganti Kaca',
                                    'Perbaikan Kaca' => 'Perbaikan Kaca',
                                    'Aksesoris & Perawatan' => 'Aksesoris & Perawatan',
                                ])
                                ->required(),
                            TextInput::make('code')
                                ->label('Kode Kupon / Promo')
                                ->placeholder('Contoh: FILMPREMIUM25')
                                ->required(),
                            TextInput::make('badge')
                                ->label('Badge Khusus')
                                ->placeholder('Contoh: Terlaris, Hemat, Bonus'),
                        ]),
                        Textarea::make('desc')
                            ->label('Deskripsi Ringkas Promo')
                            ->rows(3)
                            ->required(),
                        Grid::make(2)->schema([
                            TextInput::make('original_price')
                                ->label('Harga Asli / Sebelum Promo')
                                ->placeholder('Contoh: Rp 2.800.000'),
                            TextInput::make('promo_price')
                                ->label('Harga Promo Spesial')
                                ->placeholder('Contoh: Rp 2.100.000'),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('discount_percent')
                                ->label('Diskon (%)')
                                ->placeholder('Contoh: 25%'),
                            TextInput::make('discount')
                                ->label('Keterangan Hemat')
                                ->placeholder('Contoh: Hemat Rp 700.000'),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('valid_until')
                                ->label('Masa Berlaku')
                                ->placeholder('Contoh: 31 Oktober 2026')
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
                    ->weight('bold')
                    ->description(fn (Promo $record) => 'Kode: '.($record->code ?? '-')),
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
