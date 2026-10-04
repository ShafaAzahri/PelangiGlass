<?php

namespace App\Filament\Resources\ActivityLogs;

use App\Filament\Resources\ActivityLogs\Pages\ListActivityLogs;
use App\Models\ActivityLog;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan Sistem';

    protected static ?string $navigationLabel = 'Catatan Aktivitas (Log)';

    protected static ?string $modelLabel = 'Catatan Aktivitas';

    protected static ?string $pluralModelLabel = 'Catatan Aktivitas (Audit Log)';

    protected static ?int $navigationSort = 4;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Waktu Kejadian')
                    ->dateTime('d M Y, H:i')
                    ->description(fn (ActivityLog $record) => $record->created_at->diffForHumans())
                    ->sortable(),
                TextColumn::make('causer_name')
                    ->label('Admin / Pengguna')
                    ->icon(Heroicon::OutlinedUser)
                    ->weight('bold')
                    ->searchable(),
                TextColumn::make('action')
                    ->label('Tindakan')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('subject_type')
                    ->label('Modul')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('description')
                    ->label('Ringkasan Aktivitas')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->fontFamily('mono')
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('action')
                    ->label('Filter Tindakan')
                    ->options([
                        'Dibuat' => 'Dibuat (Create)',
                        'Diperbarui' => 'Diperbarui (Update)',
                        'Dihapus' => 'Dihapus (Delete)',
                    ]),
                SelectFilter::make('subject_type')
                    ->label('Filter Modul')
                    ->options([
                        'Produk' => 'Produk',
                        'Layanan' => 'Layanan',
                        'Promo' => 'Promo',
                        'Artikel' => 'Artikel',
                        'Banner Beranda' => 'Banner Beranda',
                        'Pengaturan Workshop' => 'Pengaturan Workshop',
                        'Pesan Masuk' => 'Pesan Masuk',
                    ]),
            ])
            ->recordActions([
                Action::make('view_details')
                    ->label('Lihat Detail')
                    ->icon(Heroicon::OutlinedEye)
                    ->button()
                    ->color('gray')
                    ->modalHeading(fn (ActivityLog $record) => 'Detail Log: ' . $record->action . ' ' . $record->subject_type)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalContent(function (ActivityLog $record): HtmlString {
                        $props = $record->properties ?? [];
                        $html = "<div style='font-size: 13px; line-height: 1.5; color: #1e293b;'>";
                        $html .= "<div style='padding: 10px 14px; background: rgba(30, 41, 59, 0.05); border-radius: 8px; margin-bottom: 14px;'>";
                        $html .= "<strong>Pelaku:</strong> " . e($record->causer_name) . "<br>";
                        $html .= "<strong>Waktu:</strong> " . e($record->created_at->format('d M Y, H:i:s')) . " (" . e($record->created_at->diffForHumans()) . ")<br>";
                        $html .= "<strong>IP Address:</strong> " . e($record->ip_address ?? 'Localhost') . "<br>";
                        $html .= "<strong>Keterangan:</strong> " . e($record->description);
                        $html .= "</div>";

                        if (isset($props['old']) && isset($props['new'])) {
                            $html .= "<h4 style='font-weight: 700; margin-bottom: 8px;'>Perubahan Field:</h4>";
                            $html .= "<table style='width: 100%; border-collapse: collapse; font-size: 12px;'>";
                            $html .= "<thead><tr style='background: #f1f5f9; text-align: left;'><th style='padding: 6px 8px; border: 1px solid #cbd5e1;'>Kolom</th><th style='padding: 6px 8px; border: 1px solid #cbd5e1;'>Sebelum</th><th style='padding: 6px 8px; border: 1px solid #cbd5e1;'>Sesudah</th></tr></thead><tbody>";
                            foreach ($props['new'] as $key => $newVal) {
                                $oldVal = $props['old'][$key] ?? '-';
                                $oldStr = is_array($oldVal) ? json_encode($oldVal) : (string) $oldVal;
                                $newStr = is_array($newVal) ? json_encode($newVal) : (string) $newVal;
                                $html .= "<tr>";
                                $html .= "<td style='padding: 6px 8px; border: 1px solid #e2e8f0; font-weight: 600;'>" . e($key) . "</td>";
                                $html .= "<td style='padding: 6px 8px; border: 1px solid #e2e8f0; color: #dc2626; background: #fef2f2;'>" . e(Str::limit($oldStr, 120)) . "</td>";
                                $html .= "<td style='padding: 6px 8px; border: 1px solid #e2e8f0; color: #16a34a; background: #f0fdf4;'>" . e(Str::limit($newStr, 120)) . "</td>";
                                $html .= "</tr>";
                            }
                            $html .= "</tbody></table>";
                        } elseif (isset($props['attributes'])) {
                            $html .= "<h4 style='font-weight: 700; margin-bottom: 8px;'>Atribut Data:</h4>";
                            $html .= "<pre style='background: #0f172a; color: #f8fafc; padding: 12px; border-radius: 8px; font-size: 11px; overflow-x: auto; max-height: 250px;'>" . e(json_encode($props['attributes'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) . "</pre>";
                        }

                        $html .= "</div>";
                        return new HtmlString($html);
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivityLogs::route('/'),
        ];
    }
}
