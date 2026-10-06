<?php

namespace App\Filament\Widgets;

use App\Enums\InquiryStatus;
use App\Filament\Resources\Inquiries\InquiryResource;
use App\Models\Inquiry;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestInquiriesWidget extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(Inquiry::query()->latest())
            ->heading('Pesan Masuk Terbaru (Calon Pelanggan / Leads)')
            ->description('5 pesan terbaru yang masuk melalui formulir kontak website Pelangi Glass')
            ->paginated([5])
            ->defaultPaginationPageOption(5)
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Pengirim')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (Inquiry $record) => $record->email ?: 'Tidak ada email'),
                TextColumn::make('phone_number')
                    ->label('No. WhatsApp')
                    ->icon(Heroicon::OutlinedPhone)
                    ->iconColor('gray'),
                TextColumn::make('message')
                    ->label('Isi Pesan')
                    ->limit(65)
                    ->wrap(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Waktu Masuk')
                    ->since()
                    ->sortable(),
            ])
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
                Action::make('viewInquiry')
                    ->label('Buka')
                    ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->color('gray')
                    ->url(fn (Inquiry $record) => InquiryResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
