<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Resources\Services\ServiceResource;
use App\Services\DataImportService;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\HtmlString;
class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('importCsv')
                ->label('Import CSV / Excel')
                ->icon(Heroicon::OutlinedArrowUpTray)
                ->color('gray')
                ->modalHeading('Import Data Layanan dari File CSV / Excel')
                ->modalDescription('Unggah file spreadsheet (CSV atau XLSX) untuk menambahkan banyak layanan sekaligus.')
                ->modalSubmitActionLabel('Mulai Import')
                ->form([
                    Placeholder::make('template_info')
                        ->label('Format Kolom')
                        ->content(new HtmlString("
                            <div style='padding: 10px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-left: 3px solid #64748b; border-radius: 6px; font-size: 13px; line-height: 1.5; color: #334155;'>
                                Format kolom spreadsheet: <strong>nama_layanan, kategori, garansi, durasi, deskripsi</strong>.<br>
                                <a href='/admin/template/services-csv' target='_blank' style='color: #2563eb; font-weight: 700; text-decoration: underline; margin-top: 6px; display: inline-block;'>
                                    📥 Unduh Contoh Template CSV Layanan
                                </a>
                            </div>
                        ")),
                    FileUpload::make('file')
                        ->label('Pilih File CSV / Excel')
                        ->acceptedFileTypes([
                            'text/csv',
                            'text/plain',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            '.csv',
                            '.xlsx',
                            '.xls',
                        ])
                        ->maxSize(5120)
                        ->disk('local')
                        ->directory('temp-imports')
                        ->required()
                        ->helperText('Pastikan baris pertama berisi nama kolom seperti pada contoh template (Maks. 5 MB).'),
                ])
                ->action(function (array $data): void {
                    $path = storage_path('app/' . $data['file']);
                    if (!file_exists($path)) {
                        $path = storage_path('app/private/' . $data['file']);
                    }
                    $count = DataImportService::importServices($path);
                    @unlink($path);

                    Notification::make()
                        ->title('Berhasil Mengimpor Layanan')
                        ->body("{$count} layanan berhasil ditambahkan / diperbarui ke database.")
                        ->success()
                        ->send();
                }),
            CreateAction::make()->label('Tambah Layanan Baru'),
        ];
    }
}
