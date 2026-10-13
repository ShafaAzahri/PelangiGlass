<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageAbout extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Konten';

    protected static ?string $navigationLabel = 'Profil Bengkel';

    protected static ?string $title = 'Kelola Profil Bengkel';

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

        $defaultPillars = [
            ['title' => 'Kualitas Terbaik', 'desc' => 'Produk dan material untuk keamanan Anda'],
            ['title' => 'Inovasi Teknologi', 'desc' => 'Berinovasi mengikuti teknologi terkini'],
            ['title' => 'Pelayanan Unggul', 'desc' => 'Layanan cepat, ramah, dan profesional'],
            ['title' => 'Terpercaya Selalu', 'desc' => 'Pilihan tepat dengan hasil terbaik & bergaransi'],
        ];

        $defaultMissions = [
            ['text' => 'Menjamin kesejahteraan, keselamatan, dan pengembangan karyawan sebagai fondasi utama keberlanjutan perusahaan.'],
            ['text' => 'Mengembangkan kompetensi teknisi dan tim pelayanan melalui pelatihan rutin, sertifikasi profesional, dan standar kerja yang jelas.'],
            ['text' => 'Menyediakan produk kaca otomotif berkualitas tinggi dan bersertifikasi dengan standar keamanan yang teruji sesuai kebutuhan pelanggan.'],
            ['text' => 'Memastikan setiap proses layanan berjalan cepat, presisi, dan aman melalui penerapan SOP, disiplin keselamatan, serta pemanfaatan teknologi yang relevan.'],
            ['text' => 'Membangun jaringan layanan yang luas dan mudah dijangkau di Purwokerto, Jawa Tengah, hingga wilayah strategis nasional.'],
            ['text' => 'Menciptakan pengalaman pelanggan terbaik melalui pelayanan yang ramah, responsif, edukatif, informatif, dan solutif, termasuk penguatan after-sales dan CRM.'],
            ['text' => 'Mengembangkan kemitraan strategis dan menjalankan praktik bisnis berkelanjutan yang bertanggung jawab terhadap lingkungan.'],
        ];

        $rawPillars = $settings['about_vision_pillars'] ?? null;
        $pillars = $rawPillars ? json_decode($rawPillars, true) : $defaultPillars;

        $rawMissions = $settings['about_missions'] ?? null;
        $missions = $rawMissions ? json_decode($rawMissions, true) : $defaultMissions;

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
            // Tab 1: Sejarah & Metrik
            'about_story_title' => $settings['about_story_title'] ?? 'Lebih dari '.($settings['years_experience'] ?? '30+').' Tahun Melayani Purwokerto',
            'about_story_p1' => $settings['about_story_p1'] ?? 'Berdiri sejak 1992, Pelangi Glass hadir sebagai solusi kaca otomotif terpercaya di Purwokerto dan Banyumas. Dirintis dengan semangat pelayanan terbaik, kami telah melayani puluhan ribu pelanggan selama lebih dari tiga dekade.',
            'about_story_p2' => $settings['about_story_p2'] ?? 'Dengan pengalaman panjang dan tim teknisi yang terus berkembang, kami berkomitmen menghadirkan kualitas kerja yang presisi, produk bergaransi resmi, serta layanan yang ramah dan transparan bagi setiap pelanggan.',
            'about_stat_founded' => $settings['about_stat_founded'] ?? '1992',
            'years_experience' => $settings['years_experience'] ?? '30+',
            'about_stat_customers' => $settings['about_stat_customers'] ?? '10.000+',
            'about_stat_warranty' => $settings['about_stat_warranty'] ?? '100%',

            // Tab 2: Fasilitas Ruang Tunggu
            'waiting_room_facilities_title' => $settings['waiting_room_facilities_title'] ?? 'FASILITAS RUANG TUNGGU PELANGGAN',
            'waiting_room_facilities' => is_array($facilities) ? $facilities : $defaultFacilities,

            // Tab 3: Visi Perusahaan
            'about_vision_title' => $settings['about_vision_title'] ?? 'Visi Kami',
            'about_vision_statement' => $settings['about_vision_statement'] ?? 'Menjadi perusahaan kaca otomotif terdepan, terbesar, dan terpercaya di Jawa Tengah melalui inovasi teknologi dan standar pelayanan unggul, dengan komitmen pada kualitas layanan dan kesejahteraan karyawan.',
            'about_vision_pillars' => is_array($pillars) ? $pillars : $defaultPillars,

            // Tab 4: Misi Perusahaan
            'about_mission_title' => $settings['about_mission_title'] ?? 'Misi Kami',
            'about_missions' => is_array($missions) ? $missions : $defaultMissions,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        // Tab 1: Sejarah & Metrik
                        Tab::make('Sejarah & Metrik')
                            ->icon(Heroicon::OutlinedBuildingStorefront)
                            ->schema([
                                Section::make('Narasi Profil & Sejarah Workshop')
                                    ->description('Paragraf pembuka tentang perjalanan Pelangi Glass')
                                    ->icon(Heroicon::OutlinedDocumentText)
                                    ->schema([
                                        TextInput::make('about_story_title')
                                            ->label('Judul Utama Bagian Sejarah')
                                            ->placeholder('Contoh: Lebih dari 30+ Tahun Melayani Purwokerto')
                                            ->required()
                                            ->maxLength(255),
                                        Textarea::make('about_story_p1')
                                            ->label('Paragraf Pertama (Sejarah Awal Berdiri)')
                                            ->rows(3)
                                            ->required(),
                                        Textarea::make('about_story_p2')
                                            ->label('Paragraf Kedua (Komitmen & Dedikasi Layanan)')
                                            ->rows(3)
                                            ->required(),
                                    ]),

                                Section::make('4 Metrik Angka Statistik Utama')
                                    ->description('Angka-angka pencapaian yang tampil dalam 4 kartu ringkas')
                                    ->icon(Heroicon::OutlinedChartBar)
                                    ->schema([
                                        Grid::make(4)->schema([
                                            TextInput::make('about_stat_founded')
                                                ->label('Tahun Berdiri')
                                                ->placeholder('1992')
                                                ->required(),
                                            TextInput::make('years_experience')
                                                ->label('Lama Pengalaman (Beranda & Tentang)')
                                                ->placeholder('30+')
                                                ->helperText('Otomatis tersinkron di Beranda dan Tentang Kami.')
                                                ->required(),
                                            TextInput::make('about_stat_customers')
                                                ->label('Pelanggan Dilayani')
                                                ->placeholder('10.000+')
                                                ->required(),
                                            TextInput::make('about_stat_warranty')
                                                ->label('Garansi Pekerjaan')
                                                ->placeholder('100%')
                                                ->required(),
                                        ]),
                                    ]),
                            ]),

                        // Tab 2: Fasilitas Ruang Tunggu
                        Tab::make('Fasilitas Ruang Tunggu')
                            ->icon(Heroicon::OutlinedSparkles)
                            ->schema([
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
                            ]),

                        // Tab 2: Visi & Nilai
                        Tab::make('Visi Perusahaan')
                            ->icon(Heroicon::OutlinedSparkles)
                            ->schema([
                                Section::make('Pernyataan Visi Utama')
                                    ->description('Kalimat visi utama yang tampil di kartu gradien biru')
                                    ->icon(Heroicon::OutlinedEye)
                                    ->schema([
                                        TextInput::make('about_vision_title')
                                            ->label('Judul Bagian Visi')
                                            ->placeholder('Visi Kami')
                                            ->required(),
                                        Textarea::make('about_vision_statement')
                                            ->label('Pernyataan Kalimat Visi Lengkap')
                                            ->rows(4)
                                            ->required()
                                            ->helperText('Gunakan kalimat yang menginspirasi arah masa depan bengkel Pelangi Glass.'),
                                    ]),

                                Section::make('Pilar Nilai Visi Perusahaan')
                                    ->description('4 pilar penopang visi (Kualitas, Inovasi, Pelayanan, Terpercaya)')
                                    ->icon(Heroicon::OutlinedCube)
                                    ->schema([
                                        Repeater::make('about_vision_pillars')
                                            ->label('Daftar Pilar Nilai')
                                            ->addActionLabel('+ Tambah Pilar Nilai')
                                            ->schema([
                                                Grid::make(2)->schema([
                                                    TextInput::make('title')
                                                        ->label('Nama Pilar')
                                                        ->placeholder('Contoh: Kualitas Terbaik')
                                                        ->required(),
                                                    TextInput::make('desc')
                                                        ->label('Deskripsi Singkat')
                                                        ->placeholder('Contoh: Produk dan material untuk keamanan Anda')
                                                        ->required(),
                                                ]),
                                            ])
                                            ->defaultItems(4)
                                            ->collapsible(),
                                    ]),
                            ]),

                        // Tab 3: Misi Perusahaan
                        Tab::make('Misi Perusahaan')
                            ->icon(Heroicon::OutlinedRocketLaunch)
                            ->schema([
                                Section::make('Daftar Misi Pelangi Glass')
                                    ->description('Poin-poin misi operasional bengkel (dapat ditambah, diubah, atau dihapus)')
                                    ->icon(Heroicon::OutlinedListBullet)
                                    ->schema([
                                        TextInput::make('about_mission_title')
                                            ->label('Judul Bagian Misi')
                                            ->placeholder('Misi Kami')
                                            ->required(),
                                        Repeater::make('about_missions')
                                            ->label('Butir-Butir Kalimat Misi')
                                            ->addActionLabel('+ Tambah Butir Misi')
                                            ->schema([
                                                Textarea::make('text')
                                                    ->label('Kalimat Misi')
                                                    ->placeholder('Ketik poin misi di sini...')
                                                    ->rows(2)
                                                    ->required(),
                                            ])
                                            ->defaultItems(7)
                                            ->reorderable()
                                            ->collapsible(),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach ($state as $key => $value) {
            $formattedValue = is_array($value) ? json_encode(array_values($value)) : (string) $value;
            $group = in_array($key, ['years_experience', 'waiting_room_facilities', 'waiting_room_facilities_title']) ? 'general' : 'about';
            Setting::set($key, $formattedValue, $group);
        }
        Setting::clearCache();

        Notification::make()
            ->title('Berhasil Disimpan')
            ->body('Profil Bengkel telah berhasil diperbarui dan langsung tampil di website.')
            ->success()
            ->send();
    }
}
