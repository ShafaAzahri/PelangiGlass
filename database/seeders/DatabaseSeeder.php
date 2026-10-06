<?php

namespace Database\Seeders;

use App\Enums\ArticleStatus;
use App\Enums\ProductBadge;
use App\Enums\ServiceBadge;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Faq;
use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use App\Models\HeroBanner;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Promo;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Super Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@pelangiglass.com'],
            [
                'name' => 'Admin Pelangi Glass',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // 2. Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'Pelangi Glass Purwokerto', 'group' => 'general'],
            ['key' => 'tagline', 'value' => 'Spesialis Kaca Mobil & Kaca Film Resmi Sejak 1992', 'group' => 'general'],
            ['key' => 'phone', 'value' => '+62 813-9028-8875', 'group' => 'contact'],
            ['key' => 'whatsapp', 'value' => '6281390288875', 'group' => 'contact'],
            ['key' => 'address', 'value' => 'Purwokerto, Banyumas, Jawa Tengah', 'group' => 'contact'],
            ['key' => 'operational_hours', 'value' => 'Senin – Jumat, 08.30 – 16.30 WIB', 'group' => 'operational'],
            ['key' => 'operational_hours_weekend', 'value' => 'Sabtu & Minggu: Tutup (Janji Temu via WA)', 'group' => 'operational'],
            ['key' => 'instagram', 'value' => '@pelangiglassofficial', 'group' => 'social'],
            ['key' => 'facebook', 'value' => 'https://facebook.com', 'group' => 'social'],
            ['key' => 'youtube', 'value' => 'https://youtube.com', 'group' => 'social'],
            ['key' => 'google_maps_embed', 'value' => 'https://maps.google.com/maps?q=pelangi+glass+purwokerto&t=&z=15&ie=UTF8&iwloc=&output=embed', 'group' => 'general'],
            ['key' => 'years_experience', 'value' => '30+', 'group' => 'general'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s);
        }

        // 3. Hero Banners
        HeroBanner::truncate();
        HeroBanner::create([
            'title' => 'Kaca Mobil Jernih Perjalanan Lebih Aman',
            'subtitle' => 'Pemasangan Presisi Kaca Mobil Original OEM & Kaca Film Bergaransi Resmi di Purwokerto',
            'image_path' => '/banner1.png',
            'button_text' => 'Konsultasi Gratis',
            'button_url' => '/#kontak',
            'sort_order' => 1,
            'is_active' => true,
        ]);
        HeroBanner::create([
            'title' => 'Pelayanan Cepat, Rapi & Standar Pabrik',
            'subtitle' => 'Didukung teknisi berpengalaman lebih dari 30 tahun dengan standar perekat internasional anti bocor',
            'image_path' => '/banner2.png',
            'button_text' => 'Lihat Layanan Kami',
            'button_url' => '/servis',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // 4. Product Categories & Products
        $prodCategoriesData = [
            ['name' => 'Kaca Film', 'slug' => 'kaca-film', 'description' => 'Kaca film tolak panas kualitas premium', 'sort_order' => 1],
            ['name' => 'Kaca Mobil', 'slug' => 'kaca-mobil', 'description' => 'Kaca depan, samping, dan belakang original OEM', 'sort_order' => 2],
            ['name' => 'Aksesoris', 'slug' => 'aksesoris', 'description' => 'Karet seal, wiper, dan aksesoris kaca mobil', 'sort_order' => 3],
            ['name' => 'Perawatan', 'slug' => 'perawatan', 'description' => 'Cairan pembersih kaca, rain repellent, dan poles kaca', 'sort_order' => 4],
        ];

        $prodCats = [];
        foreach ($prodCategoriesData as $pc) {
            $prodCats[$pc['name']] = ProductCategory::updateOrCreate(['slug' => $pc['slug']], $pc);
        }

        $productsData = [
            [
                'name' => 'Kaca Film V-KOOL VK 40',
                'category' => 'Kaca Film',
                'desc' => 'Film premium anti UV & panas. Garansi 5 tahun. Transmisi cahaya 40%.',
                'badge' => ProductBadge::TERLARIS,
                'vehicle_compatibility' => 'Semua Merek & Tipe Mobil',
                'img' => 'https://images.unsplash.com/photo-1526459915562-c5ca724b1d02?w=400&h=300&fit=crop&auto=format',
                'sort_order' => 1,
            ],
            [
                'name' => 'Kaca Film 3M Crystalline',
                'category' => 'Kaca Film',
                'desc' => 'Teknologi multi-layer nano. Blokir 97% panas inframerah. Original 3M.',
                'badge' => ProductBadge::PREMIUM,
                'vehicle_compatibility' => 'Semua Merek & Tipe Mobil',
                'img' => 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=400&h=300&fit=crop&auto=format',
                'sort_order' => 2,
            ],
            [
                'name' => 'Kaca Depan Avanza Gen 3',
                'category' => 'Kaca Mobil',
                'desc' => 'Kaca depan original OEM presisi. Cocok untuk Toyota Avanza 2019–2024.',
                'badge' => null,
                'vehicle_compatibility' => 'Toyota Avanza (2019–2024)',
                'img' => 'https://images.unsplash.com/photo-1699897483215-a66a9ca292b3?w=400&h=300&fit=crop&auto=format',
                'sort_order' => 3,
            ],
            [
                'name' => 'Kaca Depan Xpander',
                'category' => 'Kaca Mobil',
                'desc' => 'Kaca depan original OEM Mitsubishi Xpander 2018–2024.',
                'badge' => null,
                'vehicle_compatibility' => 'Mitsubishi Xpander (2018–2024)',
                'img' => 'https://images.unsplash.com/photo-1708805282706-f44730b7e527?w=400&h=300&fit=crop&auto=format',
                'sort_order' => 4,
            ],
            [
                'name' => 'Rain Repellent Soft99',
                'category' => 'Perawatan',
                'desc' => 'Cairan anti hujan Jepang. Tahan hingga 3 bulan. Efek daun talas instan.',
                'badge' => ProductBadge::BARU,
                'vehicle_compatibility' => 'Universal',
                'img' => 'https://images.unsplash.com/photo-1651084296894-105edab05b26?w=400&h=300&fit=crop&auto=format',
                'sort_order' => 5,
            ],
            [
                'name' => 'Wiper Bosch Aerotwin',
                'category' => 'Aksesoris',
                'desc' => 'Wiper flat beam tanpa rangka. Sapuan bersih & merata. Tersedia semua ukuran.',
                'badge' => null,
                'vehicle_compatibility' => 'Universal Semua Ukuran',
                'img' => 'https://images.unsplash.com/photo-1526459915562-c5ca724b1d02?w=400&h=300&fit=crop&auto=format',
                'sort_order' => 6,
            ],
            [
                'name' => 'Karet Seal Kaca Universal',
                'category' => 'Aksesoris',
                'desc' => 'Karet seal kaca presisi tinggi. Anti bocor & anti debu. Senyap kabin kembali prima.',
                'badge' => null,
                'vehicle_compatibility' => 'Universal',
                'img' => 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=400&h=300&fit=crop&auto=format',
                'sort_order' => 7,
            ],
            [
                'name' => 'Cairan Pembersih Kaca Pro',
                'category' => 'Perawatan',
                'desc' => 'Formula khusus tanpa alkohol. Aman untuk semua jenis kaca film dan kaca laminated.',
                'badge' => null,
                'vehicle_compatibility' => 'Universal',
                'img' => 'https://images.unsplash.com/photo-1651084296894-105edab05b26?w=400&h=300&fit=crop&auto=format',
                'sort_order' => 8,
            ],
        ];

        foreach ($productsData as $pd) {
            Product::updateOrCreate(
                ['slug' => Str::slug($pd['name'])],
                [
                    'category_id' => $prodCats[$pd['category']]->id,
                    'name' => $pd['name'],
                    'slug' => Str::slug($pd['name']),
                    'badge' => $pd['badge'],
                    'vehicle_compatibility' => $pd['vehicle_compatibility'],
                    'short_description' => $pd['desc'],
                    'full_description' => "<p>{$pd['desc']}</p><p>Hubungi Pelangi Glass Purwokerto untuk konsultasi ketersediaan stok dan jadwal pemasangan presisi bergaransi.</p>",
                    'main_image' => $pd['img'],
                    'sort_order' => $pd['sort_order'],
                    'is_active' => true,
                ]
            );
        }

        // 5. Service Categories & Services
        $srvCatsData = [
            ['name' => 'Ganti Kaca', 'slug' => 'ganti-kaca', 'sort_order' => 1],
            ['name' => 'Kaca Film', 'slug' => 'kaca-film-service', 'sort_order' => 2],
            ['name' => 'Perbaikan Kaca', 'slug' => 'perbaikan-kaca', 'sort_order' => 3],
            ['name' => 'Aksesoris & Perawatan', 'slug' => 'aksesoris-perawatan', 'sort_order' => 4],
        ];

        $srvCats = [];
        foreach ($srvCatsData as $sc) {
            $srvCats[$sc['name']] = ServiceCategory::updateOrCreate(['slug' => $sc['slug']], $sc);
        }

        $servicesData = [
            [
                'name' => 'Paket Ganti Kaca Depan',
                'category' => 'Ganti Kaca',
                'desc' => 'Penggantian kaca depan retak/pecah dengan kaca original OEM presisi dan standar lem sealant anti-bocor.',
                'badge' => ServiceBadge::TERLARIS,
                'warranty_period' => 'Garansi Kebocoran 1 Tahun',
                'estimated_duration' => '2 – 3 Jam',
                'img' => 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=400&h=300&fit=crop&auto=format',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Ganti Kaca Samping & Belakang',
                'category' => 'Ganti Kaca',
                'desc' => 'Penggantian kaca pintu samping, ventilasi segitiga, dan kaca bagasi belakang untuk semua merek mobil.',
                'badge' => ServiceBadge::BERGARANSI,
                'warranty_period' => 'Garansi Kebocoran 1 Tahun',
                'estimated_duration' => '1 – 2 Jam',
                'img' => 'https://images.unsplash.com/photo-1699897483215-a66a9ca292b3?w=400&h=300&fit=crop&auto=format',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Pasang Kaca Film V-KOOL',
                'category' => 'Kaca Film',
                'desc' => 'Pemasangan kaca film tolak panas premium V-KOOL berteknologi multi-layer dengan garansi resmi 5 tahun.',
                'badge' => ServiceBadge::PREMIUM,
                'warranty_period' => 'Garansi Resmi 5 Tahun',
                'estimated_duration' => '2 – 4 Jam',
                'img' => 'https://images.unsplash.com/photo-1526459915562-c5ca724b1d02?w=400&h=300&fit=crop&auto=format',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Pasang Kaca Film 3M & Solar Gard',
                'category' => 'Kaca Film',
                'desc' => 'Kaca film penolak UV dan panas tinggi dengan beragam pilihan kegelapan (40%, 60%, 80%) original bergaransi.',
                'badge' => null,
                'warranty_period' => 'Garansi Resmi 5 Tahun',
                'estimated_duration' => '2 – 3 Jam',
                'img' => 'https://images.unsplash.com/photo-1708805282706-f44730b7e527?w=400&h=300&fit=crop&auto=format',
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'name' => 'Reparasi Kaca Retak & Chip',
                'category' => 'Perbaikan Kaca',
                'desc' => 'Perbaikan keretakan titik (chip) dan baret dengan teknologi injeksi resin khusus tanpa harus ganti kaca baru.',
                'badge' => ServiceBadge::HEMAT,
                'warranty_period' => 'Pengerjaan Bergaransi',
                'estimated_duration' => '45 – 60 Menit',
                'img' => 'https://images.unsplash.com/photo-1608259243654-70c070e0f6ed?w=400&h=300&fit=crop&auto=format',
                'is_featured' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Kalibrasi & Perbaikan Kaca Bocor',
                'category' => 'Perbaikan Kaca',
                'desc' => 'Pembersihan sealant lama dan pemasangan ulang kaca berstandar pabrik untuk mengatasi rembesan air dan siulan angin.',
                'badge' => ServiceBadge::BERGARANSI,
                'warranty_period' => 'Garansi 6 Bulan',
                'estimated_duration' => '1 – 2 Jam',
                'img' => 'https://images.unsplash.com/photo-1651084296894-105edab05b26?w=400&h=300&fit=crop&auto=format',
                'is_featured' => false,
                'sort_order' => 6,
            ],
            [
                'name' => 'Ganti Karet Seal & Pelipit Kaca',
                'category' => 'Aksesoris & Perawatan',
                'desc' => 'Penggantian karet channel kaca mati, pelipit pintu, dan weatherstrip agar kabin kembali senyap dan kedap.',
                'badge' => null,
                'warranty_period' => 'Material Original OEM',
                'estimated_duration' => '1 Jam',
                'img' => 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=400&h=300&fit=crop&auto=format',
                'is_featured' => false,
                'sort_order' => 7,
            ],
            [
                'name' => 'Poles Kaca & Rain Repellent',
                'category' => 'Aksesoris & Perawatan',
                'desc' => 'Pembersihan jamur kaca membandel disertai lapisan hidrofobik efek daun talas untuk visibilitas maksimal saat hujan.',
                'badge' => ServiceBadge::BARU,
                'warranty_period' => 'Tahan hingga 3 Bulan',
                'estimated_duration' => '1 – 2 Jam',
                'img' => 'https://images.unsplash.com/photo-1651084296894-105edab05b26?w=400&h=300&fit=crop&auto=format',
                'is_featured' => false,
                'sort_order' => 8,
            ],
        ];

        foreach ($servicesData as $sd) {
            Service::updateOrCreate(
                ['slug' => Str::slug($sd['name'])],
                [
                    'category_id' => $srvCats[$sd['category']]->id,
                    'name' => $sd['name'],
                    'slug' => Str::slug($sd['name']),
                    'badge' => $sd['badge'],
                    'warranty_period' => $sd['warranty_period'],
                    'estimated_duration' => $sd['estimated_duration'],
                    'description' => $sd['desc'],
                    'process_steps' => "<p>{$sd['desc']}</p><p>Proses ditangani langsung oleh teknisi senior bersertifikat dengan standar keselamatan tinggi.</p>",
                    'image_path' => $sd['img'],
                    'is_featured' => $sd['is_featured'],
                    'sort_order' => $sd['sort_order'],
                    'is_active' => true,
                ]
            );
        }

        // 6. Article Categories & Articles
        $artCatsData = [
            ['name' => 'Tips Perawatan', 'slug' => 'tips-perawatan', 'color_scheme' => 'blue', 'sort_order' => 1],
            ['name' => 'Edukasi', 'slug' => 'edukasi', 'color_scheme' => 'emerald', 'sort_order' => 2],
            ['name' => 'Keselamatan', 'slug' => 'keselamatan', 'color_scheme' => 'rose', 'sort_order' => 3],
            ['name' => 'Panduan Produk', 'slug' => 'panduan-produk', 'color_scheme' => 'amber', 'sort_order' => 4],
            ['name' => 'Panduan', 'slug' => 'panduan', 'color_scheme' => 'purple', 'sort_order' => 5],
        ];

        $artCats = [];
        foreach ($artCatsData as $ac) {
            $artCats[$ac['name']] = ArticleCategory::updateOrCreate(['slug' => $ac['slug']], $ac);
        }

        $articlesData = [
            [
                'slug' => 'cara-membersihkan-jamur-kaca-mobil',
                'title' => 'Cara Efektif Membersihkan Jamur Kaca Mobil Sendiri di Rumah',
                'excerpt' => 'Jamur kaca dan kerak air sering mengganggu visibilitas saat berkendara di malam hari atau hujan deras. Simak cara aman membersihkannya tanpa merusak lapisan kaca.',
                'category' => 'Tips Perawatan',
                'read_time' => 4,
                'img' => 'articles/bersihkan-kaca-dari-jamur.png',
                'date' => '2026-09-02 09:00:00',
            ],
            [
                'slug' => 'panduan-merawat-kabin-dan-kaca-mobil',
                'title' => 'Panduan Merawat Kebersihan Kabin & Kaca Mobil Agar Bebas Bau dan Lembap',
                'excerpt' => 'Kabin yang bersih dan kaca bebas embun membuat perjalanan jauh lebih nyaman. Pelajari tips perawatan sirkulasi AC, pembersihan karpet, dan perawatan kaca film mobil.',
                'category' => 'Tips Perawatan',
                'read_time' => 5,
                'img' => 'articles/cara-merawat-kabin-mobil.png',
                'date' => '2026-08-28 10:30:00',
            ],
            [
                'slug' => 'penyebab-alarm-mobil-bunyi-terus-dan-solusinya',
                'title' => 'Penyebab Alarm Mobil Bunyi Terus Menerus dan Cara Mengatasinya',
                'excerpt' => 'Alarm mobil tiba-tiba berbunyi tanpa sebab di tengah malam? Kenali faktor penyebabnya mulai dari baterai remote, switch pintu, sensor getar kaca, hingga modul alarm.',
                'category' => 'Edukasi',
                'read_time' => 4,
                'img' => 'articles/alarm-mobil-nyala-terus.png',
                'date' => '2026-08-20 14:15:00',
            ],
            [
                'slug' => 'rekomendasi-aksesoris-kaca-mobil-terbaik',
                'title' => 'Rekomendasi Aksesoris Kaca Mobil Terbaik untuk Kenyamanan Berkendara',
                'excerpt' => 'Mulai dari wiper frameless, talang air (door visor), karet seal kedap suara, hingga cairan rain repellent. Pilih aksesoris yang tepat untuk perlindungan kaca mobil Anda.',
                'category' => 'Panduan Produk',
                'read_time' => 4,
                'img' => 'articles/aksesoris-mobil.png',
                'date' => '2026-08-15 11:00:00',
            ],
            [
                'slug' => 'ragam-layanan-spesialis-kaca-mobil-pelangi-glass',
                'title' => 'Mengenal Ragam Layanan Spesialis Kaca Mobil & Kaca Film di Pelangi Glass',
                'excerpt' => 'Dari penggantian kaca depan OEM, seal ulang kaca rembes, injeksi kaca retak chip, hingga pemasangan kaca film tolak panas bergaransi resmi di Purwokerto.',
                'category' => 'Panduan',
                'read_time' => 6,
                'img' => 'articles/layanan-spesialis-kaca-mobil.png',
                'date' => '2026-08-10 08:45:00',
            ],
            [
                'slug' => 'kapan-waktu-tepat-mengganti-kaca-depan-retak',
                'title' => 'Kapan Waktu yang Tepat Mengganti Kaca Depan Mobil yang Retak?',
                'excerpt' => 'Jangan tunda perbaikan retakan kaca depan. Kenali batasan retak yang masih bisa direparasi dan kondisi keretakan yang sudah wajib diganti demi keselamatan keluarga.',
                'category' => 'Keselamatan',
                'read_time' => 5,
                'img' => 'articles/kapan-waktu-ganti-kaca-depan.png',
                'date' => '2026-08-05 16:20:00',
            ],
        ];

        foreach ($articlesData as $ad) {
            Article::updateOrCreate(
                ['slug' => $ad['slug']],
                [
                    'category_id' => $artCats[$ad['category']]->id,
                    'author_id' => $admin->id,
                    'title' => $ad['title'],
                    'slug' => $ad['slug'],
                    'excerpt' => $ad['excerpt'],
                    'content' => "<p>{$ad['excerpt']}</p><p>Kaca mobil adalah elemen krusial dalam visibilitas serta struktur keselamatan kendaraan Anda. Menjaga kaca mobil tetap dalam kondisi optimal akan mencegah potensi kecelakaan serta memperpanjang usia pakai kaca film.</p><h3>Langkah Praktis untuk Pengemudi</h3><p>Pastikan selalu membersihkan kaca menggunakan lap microfiber lembut dan cairan pembersih non-amonia agar kaca film tidak mengalami oksidasi atau gelembung.</p>",
                    'featured_image' => $ad['img'],
                    'read_time_minutes' => $ad['read_time'],
                    'status' => ArticleStatus::PUBLISHED,
                    'published_at' => $ad['date'],
                ]
            );
        }

        // 7. Gallery Categories & Gallery Items
        $galCatsData = [
            ['name' => 'Kaca Depan', 'slug' => 'gal-kaca-depan', 'sort_order' => 1],
            ['name' => 'Film Kaca', 'slug' => 'gal-film-kaca', 'sort_order' => 2],
            ['name' => 'Aksesoris', 'slug' => 'gal-aksesoris', 'sort_order' => 3],
            ['name' => 'Workshop', 'slug' => 'gal-workshop', 'sort_order' => 4],
        ];

        $galCats = [];
        foreach ($galCatsData as $gc) {
            $galCats[$gc['name']] = GalleryCategory::updateOrCreate(['slug' => $gc['slug']], $gc);
        }

        $galleryData = [
            ['cat' => 'Kaca Depan', 'title' => 'Pemasangan Kaca Depan Toyota Avanza Gen 1', 'car' => 'Toyota Avanza Gen 1', 'img' => 'gallery/avanza-gen-1.png'],
            ['cat' => 'Workshop', 'title' => 'Instalasi Kaca Bus Pariwisata Aneka Bintang', 'car' => 'Bus Aneka Bintang', 'img' => 'gallery/bus-aneka-bintang.png'],
            ['cat' => 'Film Kaca', 'title' => 'Pasang Kaca Film Tolak Panas Honda Brio Merah', 'car' => 'Honda Brio Merah', 'img' => 'gallery/brio-merah-s.png'],
            ['cat' => 'Kaca Depan', 'title' => 'Penggantian Kaca Depan Toyota Kijang Innova OEM', 'car' => 'Toyota Innova', 'img' => 'gallery/innova.png'],
            ['cat' => 'Aksesoris', 'title' => 'Ganti Kaca Bagasi Belakang Daihatsu Granmax', 'car' => 'Daihatsu Granmax Belakang', 'img' => 'gallery/granmax-belakang-4.png'],
            ['cat' => 'Workshop', 'title' => 'Pemasangan Kaca Truk Hino Dutro Presisi', 'car' => 'Hino Dutro Putih', 'img' => 'gallery/hino-dutro-putih.png'],
            ['cat' => 'Film Kaca', 'title' => 'Pemasangan Kaca Film V-KOOL Honda CR-V Gen 3', 'car' => 'Honda CR-V Gen 3', 'img' => 'gallery/crv-gen-3-s1.png'],
            ['cat' => 'Kaca Depan', 'title' => 'Ganti Kaca Depan Toyota Fortuner Gen 2 Asli', 'car' => 'Toyota Fortuner Gen 2', 'img' => 'gallery/fortuner-gen-2.png'],
            ['cat' => 'Workshop', 'title' => 'Instalasi Kaca Isuzu Elf Microbus Bergaransi', 'car' => 'Isuzu Elf', 'img' => 'gallery/isuzu-elf-4.png'],
            ['cat' => 'Film Kaca', 'title' => 'Pemasangan Kaca Film BMW E91 Touring', 'car' => 'BMW E91', 'img' => 'gallery/bmw-e-91.png'],
        ];

        GalleryItem::truncate();
        foreach ($galleryData as $idx => $gi) {
            GalleryItem::create([
                'category_id' => $galCats[$gi['cat']]->id,
                'title' => $gi['title'],
                'car_model' => $gi['car'],
                'image_path' => $gi['img'],
                'description' => 'Dokumentasi pengerjaan presisi di workshop Pelangi Glass Purwokerto.',
                'sort_order' => $idx + 1,
                'is_active' => true,
            ]);
        }

        // 8. Testimonials
        Testimonial::truncate();
        $testimonialsData = [
            [
                'name' => 'Budi Santoso',
                'car' => 'Toyota Innova Reborn',
                'service' => 'Ganti Kaca Depan OEM',
                'rating' => 5,
                'text' => 'Kaca depan retak parah kena kerikil di tol. Ganti di Pelangi Glass pelayanannya cepat, rapi, dan tidak rembes sama sekali saat hujan lebat. Harganya juga jauh lebih masuk akal dibanding bengkel resmi.',
                'color' => '#2563eb',
            ],
            [
                'name' => 'Hendra Wijaya',
                'car' => 'Honda HR-V 2022',
                'service' => 'Pasang Kaca Film V-KOOL',
                'rating' => 5,
                'text' => 'Pasang kaca film tolak panas V-KOOL di sini hasilnya sangat presisi, tidak ada gelembung atau baret. Ruang tunggunya juga nyaman sekali ber-AC dan ada kopi gratis.',
                'color' => '#059669',
            ],
            [
                'name' => 'Rina Kusuma',
                'car' => 'Mitsubishi Xpander',
                'service' => 'Perbaikan Kaca Retak',
                'rating' => 5,
                'text' => 'Awalnya sempat panik karena ada titik retak kecil di kaca sopir. Teknisi Pelangi Glass langsung injeksi resin, cuma 45 menit retakannya hampir tidak terlihat lagi! Sangat menghemat biaya.',
                'color' => '#d97706',
            ],
            [
                'name' => 'Deni Kurniawan',
                'car' => 'Daihatsu Terios',
                'service' => 'Seal Ulang Kaca Bocor',
                'rating' => 5,
                'text' => 'Kaca mobil saya sempat rembes air dari pinggir karet seal. Datang ke Pelangi Glass langsung dibersihkan dan di-lem ulang dengan standar pabrik. Masalah langsung tuntas bergaransi.',
                'color' => '#7c3aed',
            ],
            [
                'name' => 'Anton Pratama',
                'car' => 'Toyota Fortuner',
                'service' => 'Kaca Film 3M Crystalline',
                'rating' => 5,
                'text' => 'Sudah langganan sejak mobil pertama dulu. Pelayanan bengkel ini konsisten ramah, teknisi komunikatif mengedukasi tipe kaca yang cocok, serta transparan mengenai biaya.',
                'color' => '#dc2626',
            ],
        ];

        foreach ($testimonialsData as $idx => $t) {
            Testimonial::create([
                'customer_name' => $t['name'],
                'car_model' => $t['car'],
                'service_rendered' => $t['service'],
                'rating' => $t['rating'],
                'review_text' => $t['text'],
                'avatar_color' => $t['color'],
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => $idx + 1,
            ]);
        }

        // 9. FAQs
        Faq::truncate();
        $faqsData = [
            [
                'q' => 'Berapa lama proses penggantian kaca mobil?',
                'a' => 'Umumnya 2–3 jam untuk kaca depan atau belakang. Untuk kaca samping bisa lebih cepat, sekitar 1–1,5 jam. Kami akan informasikan estimasi waktu yang lebih tepat setelah melihat kondisi kendaraan Anda.',
            ],
            [
                'q' => 'Apakah ada garansi setelah penggantian kaca?',
                'a' => 'Ya, kami memberikan garansi kebocoran 1 tahun untuk setiap penggantian kaca. Jika ada rembesan atau kebocoran dalam periode garansi, kami perbaiki tanpa biaya tambahan.',
            ],
            [
                'q' => 'Merek kaca apa saja yang tersedia di Pelangi Glass?',
                'a' => 'Kami menyediakan kaca original OEM resmi pabrikan mobil dan merek kaca terkemuka bersertifikasi seperti Asahimas, AGC Automotive, Pilkington, serta merek OEM lainnya.',
            ],
            [
                'q' => 'Apakah bisa melayani panggilan ke rumah / kantor (Home Service)?',
                'a' => 'Untuk kondisi tertentu di wilayah Purwokerto dan sekitarnya, kami dapat melayani kunjungan ke lokasi. Silakan hubungi kami via WhatsApp untuk konfirmasi jadwal dan ketersediaan teknisi.',
            ],
        ];

        foreach ($faqsData as $idx => $f) {
            Faq::create([
                'question' => $f['q'],
                'answer' => $f['a'],
                'sort_order' => $idx + 1,
                'is_active' => true,
            ]);
        }

        // Promos Seeding
        $promosData = [
            [
                'name' => 'Diskon Kaca Film V-KOOL & 3M',
                'slug' => 'promo-kaca-film-v-kool-3m',
                'category' => 'Kaca Film',
                'desc' => 'Diskon hingga 25% paket full body kaca film premium anti panas UV bergaransi 5 tahun.',
                'img' => 'https://images.unsplash.com/photo-1526459915562-c5ca724b1d02?w=400&h=300&fit=crop&auto=format',
                'badge' => 'Terlaris',
                'original_price' => 'Rp 2.800.000',
                'promo_price' => 'Rp 2.100.000',
                'discount_percent' => '25%',
                'discount' => 'Hemat Rp 700.000',
                'code' => 'FILMPREMIUM25',
                'valid_until' => '31 Oktober 2026',
                'vehicle_compatibility' => 'Universal (Semua Tipe Mobil)',
                'benefits' => [
                    'Diskon 25% paket kaca film Full Body (depan, samping, belakang)',
                    'Garansi resmi 5 tahun distributor resmi V-KOOL & 3M',
                    'Pemasangan presisi di ruangan ber-AC bebas debu',
                    'Gratis demo uji tolak panas alat digital di tempat',
                ],
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Ganti Kaca Depan + Free Wiper',
                'slug' => 'promo-ganti-kaca-depan-free-wiper',
                'category' => 'Ganti Kaca',
                'desc' => 'Penggantian kaca depan original OEM presisi tinggi, gratis 1 set wiper Bosch original.',
                'img' => 'https://images.unsplash.com/photo-1699897483215-a66a9ca292b3?w=400&h=300&fit=crop&auto=format',
                'badge' => null,
                'original_price' => 'Rp 1.630.000',
                'promo_price' => 'Rp 1.450.000',
                'discount_percent' => '11%',
                'discount' => 'Free Wiper Bosch',
                'code' => 'FREEWIPER2026',
                'valid_until' => '15 November 2026',
                'vehicle_compatibility' => 'Avanza, Xenia, Xpander, Innova, Brio',
                'benefits' => [
                    'Kaca depan bersertifikasi SNI & OEM grade presisi',
                    'Gratis sepasang wiper Bosch Aerotwin baru',
                    'Garansi pengerjaan anti bocor air & angin 1 tahun',
                    'Waktu pengerjaan cepat 2-3 jam siap jalan',
                ],
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Reparasi Kaca Chip Diskon 20%',
                'slug' => 'promo-reparasi-kaca-retak-chip',
                'category' => 'Perbaikan Kaca',
                'desc' => 'Hemat biaya ganti baru. Perbaiki titik retak atau bintang dengan injeksi resin khusus.',
                'img' => 'https://images.unsplash.com/photo-1608259243654-70c070e0f6ed?w=400&h=300&fit=crop&auto=format',
                'badge' => 'Hemat',
                'original_price' => 'Rp 350.000',
                'promo_price' => 'Rp 280.000',
                'discount_percent' => '20%',
                'discount' => 'Hemat Rp 70.000',
                'code' => 'REPAIRCHIP20',
                'valid_until' => '30 November 2026',
                'vehicle_compatibility' => 'Semua Jenis Mobil',
                'benefits' => [
                    'Teknologi injeksi resin khusus restorasi kejernihan 85-95%',
                    'Mencegah retakan merambat ke seluruh permukaan kaca',
                    'Pengerjaan singkat hanya 45-60 menit',
                    'Garansi tidak merambat selama 6 bulan',
                ],
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($promosData as $promo) {
            Promo::updateOrCreate(['slug' => $promo['slug']], $promo);
        }
    }
}
