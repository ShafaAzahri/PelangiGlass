@extends('layouts.app')

@section('content')

@php
    $defaultServices = [
        [
            'id' => 1,
            'name' => 'Paket Ganti Kaca Depan',
            'category' => 'Ganti Kaca',
            'desc' => 'Penggantian kaca depan retak/pecah dengan kaca original OEM presisi dan standar lem sealant anti-bocor.',
            'img' => 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=400&h=300&fit=crop&auto=format',
            'badge' => 'Terlaris',
        ],
        [
            'id' => 2,
            'name' => 'Ganti Kaca Samping & Belakang',
            'category' => 'Ganti Kaca',
            'desc' => 'Penggantian kaca pintu samping, ventilasi segitiga, dan kaca bagasi belakang untuk semua merek mobil.',
            'img' => 'https://images.unsplash.com/photo-1699897483215-a66a9ca292b3?w=400&h=300&fit=crop&auto=format',
            'badge' => 'Bergaransi',
        ],
        [
            'id' => 3,
            'name' => 'Pasang Kaca Film V-KOOL',
            'category' => 'Kaca Film',
            'desc' => 'Pemasangan kaca film tolak panas premium V-KOOL berteknologi multi-layer dengan garansi resmi 5 tahun.',
            'img' => 'https://images.unsplash.com/photo-1526459915562-c5ca724b1d02?w=400&h=300&fit=crop&auto=format',
            'badge' => 'Premium',
        ],
        [
            'id' => 4,
            'name' => 'Pasang Kaca Film 3M & Solar Gard',
            'category' => 'Kaca Film',
            'desc' => 'Kaca film penolak UV dan panas tinggi dengan beragam pilihan kegelapan (40%, 60%, 80%) original bergaransi.',
            'img' => 'https://images.unsplash.com/photo-1708805282706-f44730b7e527?w=400&h=300&fit=crop&auto=format',
            'badge' => null,
        ],
        [
            'id' => 5,
            'name' => 'Reparasi Kaca Retak & Chip',
            'category' => 'Perbaikan Kaca',
            'desc' => 'Perbaikan keretakan titik (chip) dan baret dengan teknologi injeksi resin khusus tanpa harus ganti kaca baru.',
            'img' => 'https://images.unsplash.com/photo-1608259243654-70c070e0f6ed?w=400&h=300&fit=crop&auto=format',
            'badge' => 'Hemat',
        ],
        [
            'id' => 6,
            'name' => 'Kalibrasi & Perbaikan Kaca Bocor',
            'category' => 'Perbaikan Kaca',
            'desc' => 'Pembersihan sealant lama dan pemasangan ulang kaca berstandar pabrik untuk mengatasi rembesan air dan siulan angin.',
            'img' => 'https://images.unsplash.com/photo-1651084296894-105edab05b26?w=400&h=300&fit=crop&auto=format',
            'badge' => 'Bergaransi',
        ],
        [
            'id' => 7,
            'name' => 'Ganti Karet Seal & Pelipit Kaca',
            'category' => 'Aksesoris & Perawatan',
            'desc' => 'Penggantian karet channel kaca mati, pelipit pintu, dan weatherstrip agar kabin kembali senyap dan kedap.',
            'img' => 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=400&h=300&fit=crop&auto=format',
            'badge' => null,
        ],
        [
            'id' => 8,
            'name' => 'Poles Kaca & Rain Repellent',
            'category' => 'Aksesoris & Perawatan',
            'desc' => 'Pembersihan jamur kaca membandel disertai lapisan hidrofobik efek daun talas untuk visibilitas maksimal saat hujan.',
            'img' => 'https://images.unsplash.com/photo-1651084296894-105edab05b26?w=400&h=300&fit=crop&auto=format',
            'badge' => 'Baru',
        ],
    ];
@endphp

<div class="min-h-screen pt-[76px] md:pt-[88px] bg-slate-50 text-slate-900" x-data="{
    active: 'Semua',
    search: '',
    categories: ['Semua', 'Ganti Kaca', 'Kaca Film', 'Perbaikan Kaca', 'Aksesoris & Perawatan'],
    services: {{ json_encode($defaultServices) }},
    get filtered() {
        return this.services.filter(s => {
            const matchCat = this.active === 'Semua' || s.category === this.active;
            const matchSearch = s.name.toLowerCase().includes(this.search.toLowerCase());
            return matchCat && matchSearch;
        });
    },
    badgeStyle(badge) {
        if (badge === 'Premium') return 'background: #fef3c7; color: #92400e; border: 1px solid #fde68a;';
        if (badge === 'Baru' || badge === 'Bergaransi') return 'background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;';
        if (badge === 'Hemat') return 'background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;';
        return 'background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;';
    }
}">
    <div class="max-w-6xl mx-auto px-6 py-12">
        <!-- Search + Filter (matching Servis.tsx exactly) -->
        <div class="flex flex-col sm:flex-row gap-4 mb-10">
            <div class="relative flex-1 max-w-xs">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" placeholder="Cari servis / layanan..." x-model="search" class="w-full pl-9 pr-4 py-2.5 rounded-xl text-sm outline-none transition-all bg-white border border-slate-200 text-slate-900 placeholder:text-slate-400 focus:border-blue-600" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            </div>
            <div class="flex gap-2 flex-wrap">
                <template x-for="c in categories" :key="c">
                    <button @click="active = c" :class="active === c ? 'bg-blue-600 text-white border border-blue-600 shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-300'" class="px-4 py-2 rounded-full text-xs font-medium transition-all cursor-pointer" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="c"></button>
                </template>
            </div>
        </div>

        <!-- Grid Services -->
        <template x-if="filtered.length === 0">
            <div class="text-center py-20 text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Layanan tidak ditemukan.
            </div>
        </template>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5" x-show="filtered.length > 0">
            <template x-for="service in filtered" :key="service.id">
                <div class="rounded-2xl overflow-hidden transition-all duration-300 group flex flex-col bg-white border border-slate-200 shadow-xs hover:border-blue-300 hover:-translate-y-1 hover:shadow-md">
                    <div class="relative overflow-hidden" style="height: 180px;">
                        <img :src="service.img" :alt="service.name" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <template x-if="service.badge">
                            <span class="absolute top-3 left-3 text-xs px-2.5 py-1 rounded-full font-semibold" :style="badgeStyle(service.badge)" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="service.badge"></span>
                        </template>
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <div class="text-xs font-medium mb-1 text-blue-600" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="service.category"></div>
                        <h3 class="font-bold mb-2 text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.95rem; line-height: 1.3;" x-text="service.name"></h3>
                        <p class="text-xs leading-relaxed mb-4 flex-1 text-slate-500" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="service.desc"></p>
                        <a :href="'https://wa.me/6281390288875?text=Halo%20Pelangi%20Glass,%20saya%20ingin%20konsultasi%20layanan%20' + encodeURIComponent(service.name)" target="_blank" rel="noopener noreferrer" class="w-full flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-semibold text-white transition-all hover:opacity-90 bg-blue-700 hover:bg-blue-800 no-underline" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Konsultasi Servis
                        </a>
                    </div>
                </div>
            </template>
        </div>

        <!-- Bottom CTA Card -->
        <div class="mt-12 rounded-2xl p-8 text-center bg-white border border-slate-200">
            <p class="text-sm mb-4 text-slate-600" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Layanan yang Anda butuhkan tidak ada di daftar? Hubungi kami, kami siap memberikan konsultasi gratis.
            </p>
            <a href="https://wa.me/6281390288875" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-sm font-medium text-white transition-all hover:opacity-90 bg-blue-700 hover:bg-blue-800 no-underline" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
            </a>
        </div>
    </div>
</div>

@endsection
