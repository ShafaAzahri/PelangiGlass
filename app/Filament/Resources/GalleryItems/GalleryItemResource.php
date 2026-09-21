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
            ->columns(['lg' => 3, 'default' => 1])
            ->components([
                Section::make('Detail Pengerjaan')
                    ->description('Informasi kendaraan dan hasil pengerjaan')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->columnSpan(['lg' => 2, 'default' => 1])
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Dokumentasi')
                            ->placeholder('Contoh: Pemasangan V-KOOL Toyota Fortuner')
                            ->required()
                            ->maxLength(200),
                        Grid::make(2)->schema([
                            Select::make('category_id')
                                ->label('Kategori Galeri')
                                ->relationship('category', 'name')
                                ->required()
                                ->searchable()
                                ->preload(),
                            TextInput::make('car_model')
                                ->label('Tipe / Model Mobil')
                                ->placeholder('Contoh: Toyota Fortuner GR')
                                ->maxLength(150),
                        ]),
                        Textarea::make('description')
                            ->label('Deskripsi Pekerjaan')
                            ->placeholder('Catatan atau spesifikasi singkat pengerjaan...')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Section::make('Foto & Tampilan')
                    ->description('Upload foto dan pengaturan status')
                    ->icon(Heroicon::OutlinedPhoto)
                    ->columnSpan(['lg' => 1, 'default' => 1])
                    ->schema([
                        Placeholder::make('current_image_preview')
                            ->label('Foto Aktif Saat Ini')
                            ->content(function (?GalleryItem $record): ?HtmlString {
                                if (! $record || empty($record->image_url)) {
                                    return null;
                                }
                                $url = e($record->image_url);
                                return new HtmlString("
                                    <div style='display: flex; align-items: center; gap: 12px; padding: 10px; background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 10px; margin-bottom: 8px;'>
                                        <img src='{$url}' alt='Foto' style='width: 72px; height: 54px; min-width: 72px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(255, 255, 255, 0.2); display: block;' />
                                        <div style='font-size: 11px; line-height: 1.35; overflow: hidden;'>
                                            <div style='font-weight: 600; color: #f8fafc; margin-bottom: 2px;'>Foto Terpasang</div>
                                            <div style='color: #22c55e; font-weight: 500;'>✓ Aktif di website</div>
                                        </div>
                                    </div>
                                ");
                            })
                            ->visible(fn (?GalleryItem $record) => $record !== null && !empty($record->image_url)),
                        FileUpload::make('image_path')
                            ->label('Upload / Ganti Foto')
                            ->image()
                            ->disk('public')
                            ->directory('gallery')
                            ->imagePreviewHeight('180')
                            ->required(fn (string $operation, ?GalleryItem $record) => $operation === 'create' && empty($record?->image_path))
                            ->dehydrated(fn ($state) => filled($state))
                            ->helperText('Kosongkan upload ini jika tidak ingin mengubah foto yang sudah ada.'),
                        Grid::make(2)->schema([
                            Toggle::make('is_active')
                                ->label('Aktif di Web')
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
