<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Setting;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    protected array $promos = [
        [
            'id' => 1,
            'slug' => 'promo-kaca-film-v-kool-3m',
            'name' => 'Diskon Kaca Film V-KOOL & 3M',
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
        ],
        [
            'id' => 2,
            'slug' => 'promo-ganti-kaca-depan-free-wiper',
            'name' => 'Ganti Kaca Depan + Free Wiper',
            'category' => 'Ganti Kaca',
            'desc' => 'Penggantian kaca depan original OEM presisi tinggi, gratis 1 set wiper Bosch original.',
            'img' => 'https://images.unsplash.com/photo-1699897483215-a66a9ca292b3?w=400&h=300&fit=crop&auto=format',
            'badge' => null,
            'original_price' => 'Rp 1.630.000',
            'promo_price' => 'Rp 1.450.000',
            'discount_percent' => '11%',
            'discount' => 'Bonus Wiper Rp 180.000',
            'code' => 'FREEWIPER2026',
            'valid_until' => '15 November 2026',
            'vehicle_compatibility' => 'Toyota, Honda, Daihatsu, Mitsubishi, Suzuki, dll',
            'benefits' => [
                'Kaca depan OEM original standar keselamatan SNI & DOT',
                'Lem sealant polyurethane standar Eropa anti bocor & tahan getaran',
                'Gratis 1 pasang Wiper Blade Bosch Original sesuai ukuran mobil',
                'Garansi kebocoran air dan udara selama 1 tahun penuh',
            ],
        ],
        [
            'id' => 3,
            'slug' => 'promo-servis-kaca-retak-kilat',
            'name' => 'Servis Kaca Retak & Baret',
            'category' => 'Perbaikan Kaca',
            'desc' => 'Perbaikan retak koin dan bintang dengan resin optik US Glass Repair. Pulih hingga 90%.',
            'img' => 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=400&h=300&fit=crop&auto=format',
            'badge' => null,
            'original_price' => 'Rp 400.000',
            'promo_price' => 'Rp 250.000',
            'discount_percent' => '37%',
            'discount' => 'Hemat Rp 150.000',
            'code' => 'RETAKCLEAR',
            'valid_until' => '30 November 2026',
            'vehicle_compatibility' => 'Universal (Semua Jenis Kaca Mobil)',
            'benefits' => [
                'Mencegah retakan kaca menjalar ke area pandang lain',
                'Resin optik US Glass Repair berdaya rekat tinggi',
                'Tingkat kejernihan pulih hingga 85% - 95%',
                'Pengerjaan kilat hanya 45 - 60 menit',
                'Garansi retak tidak merambat selama 6 bulan',
            ],
        ],
        [
            'id' => 4,
            'slug' => 'promo-coating-kaca-anti-jamur',
            'name' => 'Coating Kaca & Anti Jamur',
            'category' => 'Perawatan',
            'desc' => 'Pembersihan kerak jamur membandel dan aplikasi nano coating hidrofobik efek daun talas.',
            'img' => 'https://images.unsplash.com/photo-1542282088-72c9c27ed0cd?w=400&h=300&fit=crop&auto=format',
            'badge' => null,
            'original_price' => 'Rp 500.000',
            'promo_price' => 'Rp 350.000',
            'discount_percent' => '30%',
            'discount' => 'Hemat Rp 150.000',
            'code' => 'ANTIRAIN30',
            'valid_until' => '31 Desember 2026',
            'vehicle_compatibility' => 'Universal All Cars',
            'benefits' => [
                'Pembersihan total kerak air membandel dan noda jamur kaca',
                'Aplikasi nano hydrophobic (efek daun talas) tahan hingga 6 bulan',
                'Pandangan jernih dan aman saat berkendara malam atau hujan deras',
                'Karet wiper bergerak halus tanpa suara berdecit',
            ],
        ],
        [
            'id' => 5,
            'slug' => 'promo-booking-online-cashback',
            'name' => 'Voucher Booking Website',
            'category' => 'Perawatan',
            'desc' => 'Potongan harga langsung tanpa diundi khusus reservasi jadwal lewat website Pelangi Glass.',
            'img' => 'https://images.unsplash.com/photo-1550355291-bbee04a92027?w=400&h=300&fit=crop&auto=format',
            'badge' => null,
            'original_price' => 'Rp 1.000.000',
            'promo_price' => 'Rp 900.000',
            'discount_percent' => '10%',
            'discount' => 'Potongan Rp 100.000',
            'code' => 'BOOKINGWEB100',
            'valid_until' => '31 Desember 2026',
            'vehicle_compatibility' => 'Universal All Cars',
            'benefits' => [
                'Potongan langsung Rp 100.000 untuk transaksi minimal Rp 1.000.000',
                'Prioritas antrean workshop (langsung ditangani teknisi)',
                'Gratis general inspection kondisi seluruh kaca mobil Anda',
                'Dapat digabungkan dengan konsultasi gratis teknisi kami',
            ],
        ],
        [
            'id' => 6,
            'slug' => 'promo-kaca-film-solar-gard',
            'name' => 'Paket Hemat Solar Gard',
            'category' => 'Kaca Film',
            'desc' => 'Kaca film tolak panas teruji dengan perlindungan UV 99% dan harga paling terjangkau.',
            'img' => 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=400&h=300&fit=crop&auto=format',
            'badge' => null,
            'original_price' => 'Rp 1.500.000',
            'promo_price' => 'Rp 1.200.000',
            'discount_percent' => '20%',
            'discount' => 'Hemat Rp 300.000',
            'code' => 'SOLARGARD20',
            'valid_until' => '15 Desember 2026',
            'vehicle_compatibility' => 'City Car, Sedan, MPV, SUV',
            'benefits' => [
                'Tolak panas inframerah hingga 65% dan UV 99%',
                'Warna hitam elegan meningkatkan privasi kabin',
                'Garansi resmi distributor 5 tahun',
            ],
        ],
        [
            'id' => 7,
            'slug' => 'promo-kaca-samping-belakang',
            'name' => 'Paket Kaca Samping & Belakang',
            'category' => 'Ganti Kaca',
            'desc' => 'Pemasangan kaca pintu samping dan bagasi belakang original tempered OEM bergaransi.',
            'img' => 'https://images.unsplash.com/photo-1708805282706-f44730b7e527?w=400&h=300&fit=crop&auto=format',
            'badge' => null,
            'original_price' => 'Rp 1.100.000',
            'promo_price' => 'Rp 935.000',
            'discount_percent' => '15%',
            'discount' => 'Hemat Rp 165.000',
            'code' => 'SIDEGLASS15',
            'valid_until' => '31 Desember 2026',
            'vehicle_compatibility' => 'Semua Merek & Tipe Kendaraan',
            'benefits' => [
                'Kaca tempered OEM bersertifikasi SNI presisi',
                'Pemasangan rapi dan presisi dengan mekanisme regulator',
                'Pembersihan tuntas serpihan kaca lama di dalam bodi pintu',
            ],
        ],
        [
            'id' => 8,
            'slug' => 'promo-seal-kaca-anti-bocor',
            'name' => 'Servis Seal Kaca Bocor / Rembes',
            'category' => 'Perawatan',
            'desc' => 'Penanganan kaca mobil bocor atau rembes air saat hujan dengan sealant polyurethane Eropa.',
            'img' => 'https://images.unsplash.com/photo-1651084296894-105edab05b26?w=400&h=300&fit=crop&auto=format',
            'badge' => null,
            'original_price' => 'Rp 350.000',
            'promo_price' => 'Rp 275.000',
            'discount_percent' => '21%',
            'discount' => 'Hemat Rp 75.000',
            'code' => 'SEALBERES',
            'valid_until' => '31 Desember 2026',
            'vehicle_compatibility' => 'Universal (Semua Tipe Mobil)',
            'benefits' => [
                'Bongkar pasang kaca tanpa merusak panel bodi',
                'Pembersihan karat dan kotoran pada bibir rangka kaca',
                'Aplikasi lem polyurethane anti-bocor bergaransi 1 tahun',
            ],
        ],
    ];

    public function index(Request $request)
    {
        $categories = ['Semua', 'Kaca Film', 'Ganti Kaca', 'Perbaikan Kaca', 'Aksesoris & Perawatan'];
        $dbPromos = Promo::active()->get();

        $promos = $dbPromos->count() > 0
            ? $dbPromos->map(fn ($p) => [
                'id' => $p->id,
                'slug' => $p->slug,
                'name' => $p->name,
                'category' => $p->category,
                'desc' => $p->desc,
                'img' => $p->image_url,
                'badge' => $p->badge,
                'original_price' => $p->original_price,
                'promo_price' => $p->promo_price,
                'discount_percent' => $p->discount_percent,
                'discount' => $p->discount,
                'code' => $p->code,
                'valid_until' => $p->valid_until,
                'vehicle_compatibility' => $p->vehicle_compatibility,
                'benefits' => $p->benefits ?? [],
            ])->toArray()
            : $this->promos;

        $settings = Setting::all()->pluck('value', 'key');

        return view('pages.promo', compact('promos', 'categories', 'settings'));
    }

    public function show(string $slug)
    {
        $dbPromo = Promo::where('slug', $slug)->first();

        if ($dbPromo) {
            $promo = [
                'id' => $dbPromo->id,
                'slug' => $dbPromo->slug,
                'name' => $dbPromo->name,
                'category' => $dbPromo->category,
                'desc' => $dbPromo->desc,
                'img' => $dbPromo->image_url,
                'badge' => $dbPromo->badge,
                'original_price' => $dbPromo->original_price,
                'promo_price' => $dbPromo->promo_price,
                'discount_percent' => $dbPromo->discount_percent,
                'discount' => $dbPromo->discount,
                'code' => $dbPromo->code,
                'valid_until' => $dbPromo->valid_until,
                'vehicle_compatibility' => $dbPromo->vehicle_compatibility,
                'benefits' => $dbPromo->benefits ?? [],
            ];
        } else {
            $promo = collect($this->promos)->firstWhere('slug', $slug);
        }

        abort_if(!$promo, 404);

        $settings = Setting::all()->pluck('value', 'key');

        return view('pages.promo_detail', compact('promo', 'settings'));
    }
}
