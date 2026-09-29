<?php

namespace App\Filament\Resources\Inquiries;

use App\Enums\InquiryStatus;
use App\Filament\Resources\Inquiries\Pages\CreateInquiry;
use App\Filament\Resources\Inquiries\Pages\EditInquiry;
use App\Filament\Resources\Inquiries\Pages\ListInquiries;
use App\Models\Inquiry;
use BackedEnum;
use Filament\Actions\Action;
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

class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxArrowDown;

    protected static string|\UnitEnum|null $navigationGroup = 'Interaksi Pelanggan';

    protected static ?string $navigationLabel = 'Pesan Masuk (Leads)';

    protected static ?string $modelLabel = 'Pesan Masuk';

    protected static ?string $pluralModelLabel = 'Pesan Masuk (Leads)';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', InquiryStatus::NEW)->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Pengirim')
                    ->required()
                    ->maxLength(150),
                TextInput::make('phone_number')
                    ->label('Nomor WhatsApp / HP')
                    ->required()
                    ->maxLength(50),
                TextInput::make('email')
                    ->label('Alamat Email')
                    ->email()
                    ->maxLength(150),
                Select::make('status')
                    ->label('Status Tindak Lanjut')
                    ->options(InquiryStatus::class)
                    ->default(InquiryStatus::NEW)
                    ->required(),
                Textarea::make('message')
                    ->label('Isi Pesan Pertanyaan')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                Textarea::make('admin_notes')
                    ->label('Catatan Internal Admin / Teknisi')
                    ->placeholder('Contoh: Sudah dihubungi via WA, berencana ganti kaca depan Avanza hari Rabu.')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Pengirim')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Inquiry $record) => $record->email),
                TextColumn::make('phone_number')
                    ->label('No. WhatsApp')
                    ->searchable(),
                TextColumn::make('message')
                    ->label('Ringkasan Pesan')
                    ->limit(50),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Diterima')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options(InquiryStatus::class),
            ])
            ->recordUrl(fn (Inquiry $record) => static::getUrl('edit', ['record' => $record]))
            ->recordActions([
                Action::make('replyWhatsApp')
                    ->label('Balas WA')
                    ->icon(Heroicon::OutlinedChatBubbleLeftRight)
                    ->color('gray')
                    ->url(fn (Inquiry $record) => $record->whatsapp_url)
                    ->openUrlInNewTab()
                    ->action(function (Inquiry $record) {
                        if ($record->status === InquiryStatus::NEW || $record->status === InquiryStatus::READ) {
                            $record->update(['status' => InquiryStatus::CONTACTED]);
                        }
                    }),
                Action::make('markAsRead')
                    ->label('Tandai Dibaca')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('gray')
                    ->visible(fn (Inquiry $record) => $record->status === InquiryStatus::NEW)
                    ->action(fn (Inquiry $record) => $record->update(['status' => InquiryStatus::READ])),
                EditAction::make()
                    ->label('Buka'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => ListInquiries::route('/'),
            'create' => CreateInquiry::route('/create'),
            'edit' => EditInquiry::route('/{record}/edit'),
        ];
    }
}
