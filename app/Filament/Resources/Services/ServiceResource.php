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
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static string|\UnitEnum|null $navigationGroup = 'Katalog & Servis';

    protected static ?string $navigationLabel = 'Layanan & Servis';

    protected static ?string $modelLabel = 'Layanan';

    protected static ?string $pluralModelLabel = 'Layanan & Servis';

    protected static ?int $navigationSort = 4;

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
                    ->label('Nama Layanan')
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
                    ->label('Badge Keunggulan')
                    ->options(ServiceBadge::class),
                TextInput::make('warranty_period')
                    ->label('Masa Garansi')
                    ->placeholder('Contoh: Garansi Kebocoran 1 Tahun')
                    ->maxLength(100),
                TextInput::make('estimated_duration')
                    ->label('Estimasi Durasi')
                    ->placeholder('Contoh: 1 – 2 Jam')
                    ->maxLength(100),
                Textarea::make('description')
                    ->label('Deskripsi Singkat')
                    ->rows(2)
                    ->columnSpanFull(),
                RichEditor::make('process_steps')
                    ->label('Langkah Proses Pengerjaan / SOP')
                    ->columnSpanFull(),
                FileUpload::make('image_path')
                    ->label('Foto Layanan')
                    ->image()
                    ->directory('services'),
                Toggle::make('is_featured')
                    ->label('Tampilkan di Beranda (Unggulan)')
                    ->default(false),
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
                    ->label('Foto')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nama Layanan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                TextColumn::make('badge')
                    ->label('Badge')
                    ->badge(),
                TextColumn::make('warranty_period')
                    ->label('Garansi')
                    ->badge()
                    ->color('success'),
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
