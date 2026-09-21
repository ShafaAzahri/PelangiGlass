<?php

namespace App\Filament\Resources\Settings;

use App\Filament\Resources\Settings\Pages\CreateSetting;
use App\Filament\Resources\Settings\Pages\EditSetting;
use App\Filament\Resources\Settings\Pages\ListSettings;
use App\Models\Setting;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAdjustmentsHorizontal;

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan Sistem';

    protected static ?string $navigationLabel = 'Pengaturan Workshop';

    protected static ?string $modelLabel = 'Pengaturan';

    protected static ?string $pluralModelLabel = 'Pengaturan Workshop';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->label('Kunci Pengaturan (Key)')
                    ->required()
                    ->maxLength(100)
                    ->disabled(fn (?Setting $record) => $record !== null),
                Select::make('group')
                    ->label('Grup Pengaturan')
                    ->options([
                        'general' => 'Umum / Profil',
                        'contact' => 'Kontak & WhatsApp',
                        'operational' => 'Jam Operasional',
                        'social' => 'Media Sosial',
                    ])
                    ->required(),
                Textarea::make('value')
                    ->label('Nilai Pengaturan (Value)')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Kunci (Key)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('value')
                    ->label('Nilai (Value)')
                    ->limit(60),
                TextColumn::make('group')
                    ->label('Grup')
                    ->badge()
                    ->color('info')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('group')
                    ->label('Grup')
                    ->options([
                        'general' => 'Umum',
                        'contact' => 'Kontak',
                        'operational' => 'Operasional',
                        'social' => 'Media Sosial',
                    ]),
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
            'index' => ListSettings::route('/'),
            'create' => CreateSetting::route('/create'),
            'edit' => EditSetting::route('/{record}/edit'),
        ];
    }
}
