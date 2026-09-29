<?php

namespace App\Filament\Resources\Services;

use App\Enums\ServiceBadge;
use App\Filament\Resources\Services\Pages\CreateService;
use App\Filament\Resources\Services\Pages\EditService;
use App\Filament\Resources\Services\Pages\ListServices;
use App\Models\Service;
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

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static string|\UnitEnum|null $navigationGroup = 'Katalog & Servis';

    protected static ?string $navigationLabel = 'Layanan & Servis';

    protected static ?string $modelLabel = 'Layanan';

    protected static ?string $pluralModelLabel = 'Layanan & Servis';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['lg' => 3, 'default' => 1])
            ->components([
                Section::make('Informasi Layanan')
                    ->description('Detail nama, kategori, dan deskripsi pengerjaan')
                    ->icon(Heroicon::OutlinedWrenchScrewdriver)
                    ->columnSpan(['lg' => 2, 'default' => 1])
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Layanan')
                            ->placeholder('Contoh: Paket Ganti Kaca Depan')
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
                                ->label('Badge Keunggulan')
                                ->options(ServiceBadge::class),
                            TextInput::make('warranty_period')
                                ->label('Masa Garansi')
                                ->placeholder('Contoh: Garansi 1 Tahun')
                                ->maxLength(100),
                            TextInput::make('estimated_duration')
                                ->label('Estimasi Durasi')
                                ->placeholder('Contoh: 1 – 2 Jam')
                                ->maxLength(100),
                        ]),
                        Textarea::make('description')
                            ->label('Deskripsi Singkat')
                            ->placeholder('Ringkasan manfaat dan spesifikasi layanan...')
                            ->rows(3)
                            ->columnSpanFull(),
                        RichEditor::make('process_steps')
                            ->label('Langkah Proses Pengerjaan / SOP')
                            ->columnSpanFull(),
                    ]),

                Section::make('Foto & Publikasi')
                    ->description('Upload foto layanan dan visibilitas')
                    ->icon(Heroicon::OutlinedPhoto)
                    ->columnSpan(['lg' => 1, 'default' => 1])
                    ->schema([
                        Placeholder::make('current_image_preview')
                            ->label('Foto Layanan Aktif')
                            ->content(function (?Service $record): ?HtmlString {
                                if (! $record || empty($record->image_url)) {
                                    return null;
                                }
                                $url = e($record->image_url);
                                return new HtmlString("
                                    <div style='display: flex; align-items: center; gap: 12px; padding: 10px; background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 10px; margin-bottom: 8px;'>
                                        <img src='{$url}' alt='Layanan' style='width: 72px; height: 54px; min-width: 72px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(255, 255, 255, 0.2); display: block;' />
                                        <div style='font-size: 11px; line-height: 1.35; overflow: hidden;'>
                                            <div style='font-weight: 600; color: #f8fafc; margin-bottom: 2px;'>Foto Terpasang</div>
                                            <div style='color: #22c55e; font-weight: 500;'>✓ Aktif di website</div>
                                        </div>
                                    </div>
                                ");
                            })
                            ->visible(fn (?Service $record) => $record !== null && !empty($record->image_url)),
                        FileUpload::make('image_path')
                            ->label('Upload / Ganti Foto')
                            ->image()
                            ->disk('public')
                            ->directory('services')
                            ->imagePreviewHeight('180')
                            ->dehydrated(fn ($state) => filled($state))
                            ->helperText('Kosongkan upload ini jika tidak ingin mengubah foto layanan yang sudah ada.'),
                        Toggle::make('is_featured')
                            ->label('Layanan Unggulan (Beranda)')
                            ->default(false),
                        Toggle::make('is_active')
                            ->label('Aktif di Website')
                            ->default(true),
                        TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),
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
                    ->defaultImageUrl(fn (Service $record) => $record->image_url),
                TextColumn::make('name')
                    ->label('Nama Layanan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('badge')
                    ->label('Badge')
                    ->badge(),
                TextColumn::make('warranty_period')
                    ->label('Garansi')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('estimated_duration')
                    ->label('Durasi'),
                ToggleColumn::make('is_featured')
                    ->label('Unggulan'),
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
            'index' => ListServices::route('/'),
            'create' => CreateService::route('/create'),
            'edit' => EditService::route('/{record}/edit'),
        ];
    }
}
