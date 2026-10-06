<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageAbout extends Page
{
    protected string $view = 'filament.pages.manage-about';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Konten';

    protected static ?string $navigationLabel = 'Tentang Kami';

    protected static ?string $title = 'Kelola Konten Tentang Kami';

    protected static ?int $navigationSort = 1;

    public ?array $data = [];

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

        $this->form->fill([
            // Tab 1: Sejarah & Metrik
            'about_story_title' => $settings['about_story_title'] ?? 'Lebih dari '.($settings['years_experience'] ?? '30+').' Tahun Melayani Purwokerto',
            'about_story_p1' => $settings['about_story_p1'] ?? 'Berdiri sejak 1992, Pelangi Glass hadir sebagai solusi kaca otomotif terpercaya di Purwokerto dan Banyumas. Dirintis dengan semangat pelayanan terbaik, kami telah melayani puluhan ribu pelanggan selama lebih dari tiga dekade.',
            'about_story_p2' => $settings['about_story_p2'] ?? 'Dengan pengalaman panjang dan tim teknisi yang terus berkembang, kami berkomitmen menghadirkan kualitas kerja yang presisi, produk bergaransi resmi, serta layanan yang ramah dan transparan bagi setiap pelanggan.',
            'about_stat_founded' => $settings['about_stat_founded'] ?? '1992',
            'years_experience' => $settings['years_experience'] ?? '30+',
            'about_stat_customers' => $settings['about_stat_customers'] ?? '10.000+',
            'about_stat_warranty' => $settings['about_stat_warranty'] ?? '100%',

            // Tab 2: Visi Perusahaan
            'about_vision_title' => $settings['about_vision_title'] ?? 'Visi Kami',
            'about_vision_statement' => $settings['about_vision_statement'] ?? 'Menjadi perusahaan kaca otomotif terdepan, terbesar, dan terpercaya di Jawa Tengah melalui inovasi teknologi dan standar pelayanan unggul, dengan komitmen pada kualitas layanan dan kesejahteraan karyawan.',
            'about_vision_pillars' => is_array($pillars) ? $pillars : $defaultPillars,

            // Tab 3: Misi Perusahaan
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
            $group = $key === 'years_experience' ? 'general' : 'about';
            Setting::set($key, $formattedValue, $group);
        }
        Setting::clearCache();

        Notification::make()
            ->title('Berhasil Disimpan')
            ->body('Konten halaman Tentang Kami telah berhasil diperbarui dan langsung tampil di website.')
            ->success()
            ->send();
    }
}
