<?php

namespace App\Filament\Resources\Inquiries\Pages;

use App\Enums\InquiryStatus;
use App\Filament\Resources\Inquiries\InquiryResource;
use App\Models\Inquiry;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInquiry extends EditRecord
{
    protected static string $resource = InquiryResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if ($this->record instanceof Inquiry && $this->record->status === InquiryStatus::NEW) {
            $this->record->update(['status' => InquiryStatus::READ]);
            $data['status'] = InquiryStatus::READ->value;
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
