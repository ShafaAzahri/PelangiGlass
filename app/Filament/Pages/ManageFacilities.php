<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageFacilities extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Konten';

    protected static ?string $navigationLabel = 'Fasilitas Ruang Tunggu';

    protected static ?string $title = 'Kelola Fasilitas Ruang Tunggu';

    protected static ?int $navigationSort = 2;

    public ?array $data = [];

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make($this->getFormActions())
                            ->alignment($this->getFormActionsAlignment())
                            ->key('form-actions'),
                    ]),
            ]);
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label('Simpan Perubahan')
            ->submit('save')
            ->keyBindings(['mod+s']);
    }

    public function mount(): void
    {
        $settings = Setting::allKeyed();

        $defaultFacilities = [
            ['name' => 'Free Coffee & Teh', 'icon' => 'coffee', 'is_active' => true],
            ['name' => 'Free Charging', 'icon' => 'charging', 'is_active' => true],
            ['name' => 'Air Panas & Dingin', 'icon' => 'water', 'is_active' => true],
            ['name' => 'TV LED Hiburan', 'icon' => 'tv', 'is_active' => true],
            ['name' => 'Kipas Angin', 'icon' => 'fan', 'is_active' => true],
        ];

        $rawFacilities = $settings['waiting_room_facilities'] ?? null;
        $facilities = $rawFacilities ? json_decode($rawFacilities, true) : $defaultFacilities;

        $this->form->fill([
            'waiting_room_facilities_title' => $settings['waiting_room_facilities_title'] ?? 'FASILITAS RUANG TUNGGU PELANGGAN',
            'waiting_room_facilities' => is_array($facilities) ? $facilities : $defaultFacilities,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Judul Bagian Fasilitas')
                    ->description('Teks judul yang tampil di atas deretan kartu fasilitas beranda')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->schema([
                        TextInput::make('waiting_room_facilities_title')
                            ->label('Judul Bagian')
                            ->placeholder('FASILITAS RUANG TUNGGU PELANGGAN')
                            ->default('FASILITAS RUANG TUNGGU PELANGGAN')
                            ->required()
                            ->maxLength(150),
                    ]),

                Section::make('Daftar Fasilitas Pelanggan')
                    ->description('Kelola item fasilitas yang tersedia di ruang tunggu workshop Pelangi Glass. Fasilitas yang aktif akan langsung muncul di halaman beranda.')
                    ->icon(Heroicon::OutlinedSparkles)
                    ->schema([
                        Repeater::make('waiting_room_facilities')
                            ->label('Daftar Fasilitas')
                            ->addActionLabel('+ Tambah Fasilitas Baru')
                            ->itemLabel(function (array $state): ?string {
                                $name = $state['name'] ?? null;
                                if (! filled($name)) {
                                    return 'Fasilitas Baru';
                                }
                                $iconMap = [
                                    'coffee' => '☕',
                                    'charging' => '🔌',
                                    'water' => '🚰',
                                    'tv' => '📺',
                                    'fan' => '💨',
                                    'wifi' => '📶',
                                    'ac' => '❄️',
                                    'sofa' => '🛋️',
                                    'toilet' => '🚻',
                                    'parking' => '🅿️',
                                    'check' => '✓',
                                ];
                                $emoji = $iconMap[$state['icon'] ?? 'check'] ?? '✓';
                                $status = isset($state['is_active']) && ! $state['is_active'] ? ' (Nonaktif)' : '';

                                return "{$emoji} {$name}{$status}";
                            })
                            ->schema([
                                Grid::make(12)->schema([
                                    TextInput::make('name')
                                        ->label('Nama Fasilitas')
                                        ->placeholder('Contoh: Free Coffee & Teh')
                                        ->required()
                                        ->columnSpan(['default' => 12, 'md' => 6]),
                                    Select::make('icon')
                                        ->label('Pilihan Ikon')
                                        ->options([
                                            'coffee' => '☕ Kopi & Teh',
                                            'charging' => '🔌 Colokan / Charging',
                                            'water' => '🚰 Air Panas & Dingin',
                                            'tv' => '📺 TV LED Hiburan',
                                            'fan' => '💨 Kipas Angin',
                                            'wifi' => '📶 Free Wi-Fi',
                                            'ac' => '❄️ Ruangan Ber-AC',
                                            'sofa' => '🛋️ Sofa Nyaman',
                                            'toilet' => '🚻 Toilet Bersih',
                                            'parking' => '🅿️ Parkir Luas',
                                            'check' => '✓ Ceklis / Umum',
                                        ])
                                        ->default('check')
                                        ->required()
                                        ->columnSpan(['default' => 12, 'md' => 4]),
                                    Toggle::make('is_active')
                                        ->label('Tampilkan')
                                        ->default(true)
                                        ->columnSpan(['default' => 12, 'md' => 2]),
                                ]),
                            ])
                            ->defaultItems(5)
                            ->reorderable()
                            ->collapsible()
                            ->cloneable(),
                    ]),
            ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $title = $state['waiting_room_facilities_title'] ?? 'FASILITAS RUANG TUNGGU PELANGGAN';
        $facilities = $state['waiting_room_facilities'] ?? [];

        Setting::set('waiting_room_facilities_title', (string) $title, 'general');
        Setting::set('waiting_room_facilities', json_encode(array_values($facilities)), 'general');
        Setting::clearCache();

        Notification::make()
            ->title('Berhasil Disimpan')
            ->body('Daftar fasilitas ruang tunggu pelanggan telah berhasil diperbarui dan langsung tampil di website.')
            ->success()
            ->send();
    }
}
