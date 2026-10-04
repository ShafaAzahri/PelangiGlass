<?php

namespace App\Filament\Resources\Testimonials;

use App\Filament\Resources\Testimonials\Pages\CreateTestimonial;
use App\Filament\Resources\Testimonials\Pages\EditTestimonial;
use App\Filament\Resources\Testimonials\Pages\ListTestimonials;
use App\Models\Testimonial;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleBottomCenterText;

    protected static string|\UnitEnum|null $navigationGroup = 'Interaksi Pelanggan';

    protected static ?string $navigationLabel = 'Testimoni Pelanggan';

    protected static ?string $modelLabel = 'Testimoni';

    protected static ?string $pluralModelLabel = 'Testimoni Pelanggan';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('customer_name')
                    ->label('Nama Pelanggan')
                    ->required()
                    ->maxLength(150),
                TextInput::make('car_model')
                    ->label('Tipe / Merek Mobil')
                    ->placeholder('Contoh: Honda HR-V 2022')
                    ->maxLength(150),
                TextInput::make('service_rendered')
                    ->label('Layanan yang Dikerjakan')
                    ->placeholder('Contoh: Pasang Kaca Film V-KOOL')
                    ->maxLength(150),
                Select::make('rating')
                    ->label('Rating Bintang')
                    ->options([
                        5 => '⭐⭐⭐⭐⭐ (5 Bintang)',
                        4 => '⭐⭐⭐⭐ (4 Bintang)',
                        3 => '⭐⭐⭐ (3 Bintang)',
                        2 => '⭐⭐ (2 Bintang)',
                        1 => '⭐ (1 Bintang)',
                    ])
                    ->default(5)
                    ->required(),
                TextInput::make('avatar_color')
                    ->label('Warna Inisial Avatar (Hex)')
                    ->default('#2563eb'),
                Textarea::make('review_text')
                    ->label('Isi Ulasan / Testimoni')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                Toggle::make('is_featured')
                    ->label('Tampilkan di Beranda')
                    ->default(true),
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
                TextColumn::make('customer_name')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Testimonial $record) => "{$record->car_model} • {$record->service_rendered}"),
                TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state))
                    ->sortable(),
                TextColumn::make('review_text')
                    ->label('Kutipan Ulasan')
                    ->limit(60),
                ToggleColumn::make('is_featured')
                    ->label('Unggulan'),
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
            'index' => ListTestimonials::route('/'),
            'create' => CreateTestimonial::route('/create'),
            'edit' => EditTestimonial::route('/{record}/edit'),
        ];
    }
}
