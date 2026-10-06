@extends('layouts.app')

@section('content')

@php
    $defaultServices = [
        [
            'id' => 1,
            'slug' => 'penggantian-kaca-depan-oem',
            'name' => 'Paket Ganti Kaca Depan',
            'category' => 'Ganti Kaca',
            'desc' => 'Penggantian kaca depan retak/pecah dengan kaca original OEM presisi dan standar lem sealant anti-bocor.',
            'img' => 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=400&h=300&fit=crop&auto=format',
            'badge' => 'Terlaris',
            'warranty_period' => '1 Tahun',
            'estimated_duration' => '2-3 Jam',
        ],
        [
            'id' => 2,
            'slug' => 'ganti-kaca-samping-belakang',
            'name' => 'Ganti Kaca Samping & Belakang',
            'category' => 'Ganti Kaca',
            'desc' => 'Penggantian kaca pintu samping, ventilasi segitiga, dan kaca bagasi belakang untuk semua merek mobil.',
            'img' => 'https://images.unsplash.com/photo-1699897483215-a66a9ca292b3?w=400&h=300&fit=crop&auto=format',
            'badge' => 'Bergaransi',
            'warranty_period' => '1 Tahun',
            'estimated_duration' => '1-2 Jam',
        ],
        [
            'id' => 3,
            'slug' => 'pemasangan-kaca-film-v-kool',
            'name' => 'Pasang Kaca Film V-KOOL',
            'category' => 'Kaca Film',
            'desc' => 'Pemasangan kaca film tolak panas premium V-KOOL berteknologi multi-layer dengan garansi resmi 5 tahun.',
            'img' => 'https://images.unsplash.com/photo-1526459915562-c5ca724b1d02?w=400&h=300&fit=crop&auto=format',
            'badge' => 'Premium',
            'warranty_period' => '5 Tahun',
            'estimated_duration' => '3-4 Jam',
        ],
        [
            'id' => 4,
            'slug' => 'pasang-kaca-film-3m-solar-gard',
            'name' => 'Pasang Kaca Film 3M & Solar Gard',
            'category' => 'Kaca Film',
            'desc' => 'Kaca film penolak UV dan panas tinggi dengan beragam pilihan kegelapan (40%, 60%, 80%) original bergaransi.',
            'img' => 'https://images.unsplash.com/photo-1708805282706-f44730b7e527?w=400&h=300&fit=crop&auto=format',
            'badge' => null,
            'warranty_period' => '3-5 Tahun',
            'estimated_duration' => '2-3 Jam',
        ],
        [
            'id' => 5,
            'slug' => 'perbaikan-kaca-retak-chip',
            'name' => 'Reparasi Kaca Retak & Chip',
            'category' => 'Perbaikan Kaca',
            'desc' => 'Perbaikan keretakan titik (chip) dan baret dengan teknologi injeksi resin khusus tanpa harus ganti kaca baru.',
            'img' => 'https://images.unsplash.com/photo-1608259243654-70c070e0f6ed?w=400&h=300&fit=crop&auto=format',
            'badge' => 'Hemat',
            'warranty_period' => '6 Bulan',
            'estimated_duration' => '45-60 Menit',
        ],
        [
            'id' => 6,
            'slug' => 'kalibrasi-kaca-bocor',
            'name' => 'Kalibrasi & Perbaikan Kaca Bocor',
            'category' => 'Perbaikan Kaca',
            'desc' => 'Pembersihan sealant lama dan pemasangan ulang kaca berstandar pabrik untuk mengatasi rembesan air dan siulan angin.',
            'img' => 'https://images.unsplash.com/photo-1651084296894-105edab05b26?w=400&h=300&fit=crop&auto=format',
            'badge' => 'Bergaransi',
            'warranty_period' => '1 Tahun',
            'estimated_duration' => '2-3 Jam',
        ],
        [
            'id' => 7,
            'slug' => 'penggantian-karet-seal-kaca',
            'name' => 'Ganti Karet Seal & Pelipit Kaca',
            'category' => 'Aksesoris & Perawatan',
            'desc' => 'Penggantian karet channel kaca mati, pelipit pintu, dan weatherstrip agar kabin kembali senyap dan kedap.',
            'img' => 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=400&h=300&fit=crop&auto=format',
            'badge' => null,
            'warranty_period' => '6 Bulan',
            'estimated_duration' => '1-2 Jam',
        ],
        [
            'id' => 8,
            'slug' => 'poles-kaca-dan-rain-repellent',
            'name' => 'Poles Kaca & Rain Repellent',
            'category' => 'Aksesoris & Perawatan',
            'desc' => 'Pembersihan jamur kaca membandel disertai lapisan hidrofobik efek daun talas untuk visibilitas maksimal saat hujan.',
            'img' => 'https://images.unsplash.com/photo-1651084296894-105edab05b26?w=400&h=300&fit=crop&auto=format',
            'badge' => 'Baru',
            'warranty_period' => '3 Bulan Efek Hidrofobik',
            'estimated_duration' => '1-2 Jam',
        ],
    ];
    $items = (isset($services) && $services->count() > 0)
        ? $services->map(fn($s) => [
            'id' => $s->id,
            'name' => $s->name,
            'slug' => $s->slug,
            'category' => $s->category?->name ?? 'Ganti Kaca',
            'desc' => $s->description ?? $s->short_description ?? '',
            'img' => $s->image_url,
            'badge' => $s->badge?->value ?? null,
            'warranty_period' => $s->warranty_period ?? null,
            'estimated_duration' => $s->estimated_duration ?? null,
        ])->toArray()
        : $defaultServices;
    $serviceCats = (isset($categories) && $categories->count() > 0)
        ? array_merge(['Semua'], $categories->pluck('name')->toArray())
        : ['Semua', 'Ganti Kaca', 'Kaca Film', 'Perbaikan Kaca', 'Aksesoris & Perawatan'];
@endphp

<div class="min-h-screen pt-[76px] md:pt-[88px] bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors" x-data="{
    active: 'Semua',
    search: '',
    categories: {{ json_encode($serviceCats) }},
    services: {{ json_encode($items) }},
    limit: 8,
    pageSize: 8,
    get filtered() {
        return this.services.filter(s => {
            const matchCat = this.active === 'Semua' || s.category === this.active;
            const searchLower = this.search.toLowerCase();
            const matchSearch = !searchLower || s.name.toLowerCase().includes(searchLower) ||
                (s.desc && s.desc.toLowerCase().includes(searchLower));
            return matchCat && matchSearch;
        });
    },
    get visibleServices() {
        return this.filtered.slice(0, this.limit);
    },
    get hasMore() {
        return this.visibleServices.length < this.filtered.length;
    },
    loadMore() {
        if (this.hasMore) {
            this.limit += this.pageSize;
        }
    },
    filterCategory(c) {
        this.active = c;
        this.limit = this.pageSize;
    },
    badgeTheme(badge) {
        if (badge === 'Premium') return 'bg-gradient-to-r from-amber-600 via-amber-500 to-yellow-500 shadow-amber-950/20';
        if (badge === 'Baru') return 'bg-gradient-to-r from-blue-600 to-sky-500 shadow-blue-950/20';
        if (badge === 'Hemat' || badge === 'Bergaransi') return 'bg-gradient-to-r from-emerald-600 to-teal-500 shadow-emerald-950/20';
        return 'bg-gradient-to-r from-red-600 to-rose-600 shadow-rose-950/20';
    }
}">
    <div class="max-w-6xl mx-auto px-6 py-12">
        <!-- Search + Filter (matching Servis.tsx exactly) -->
        <div class="flex flex-col sm:flex-row gap-4 mb-10">
            <div class="relative flex-1 max-w-xs">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" placeholder="Cari servis / layanan..." x-model="search" @input="limit = pageSize" class="w-full pl-9 pr-4 py-2.5 rounded-xl text-sm outline-none transition-all bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-blue-600 dark:focus:border-blue-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            </div>
            <div class="flex gap-2 flex-wrap">
                <template x-for="c in categories" :key="c">
                    <button @click="filterCategory(c)" :class="active === c ? 'bg-blue-600 text-white border border-blue-600 shadow-xs' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700'" class="px-4 py-2 rounded-full text-xs font-medium transition-all cursor-pointer" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="c"></button>
                </template>
            </div>
        </div>

        <!-- Grid Services -->
        <template x-if="filtered.length === 0">
            <div class="text-center py-20 text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Layanan tidak ditemukan.
            </div>
        </template>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 items-stretch" x-show="filtered.length > 0">
            <template x-for="service in visibleServices" :key="service.id">
                <div class="rounded-2xl overflow-hidden transition-all duration-300 group flex flex-col h-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs hover:border-blue-300 dark:hover:border-blue-700 hover:-translate-y-1 hover:shadow-md">
                    <a :href="'/servis/' + (service.slug || service.id)" class="relative overflow-hidden block shrink-0" style="height: 180px;">
                        <img :src="service.img" :alt="service.name" loading="lazy" decoding="async" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <template x-if="service.badge">
                            <div class="absolute top-0 left-0 z-10">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10.5px] font-extrabold uppercase tracking-wider text-white shadow-md rounded-br-xl select-none"
                                      :class="badgeTheme(service.badge)"
                                      style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                    <template x-if="service.badge === 'Terlaris'">
                                        <svg class="w-3 h-3 fill-current text-white/95" viewBox="0 0 24 24"><path d="M12 2c.5 3 2 4.5 4 6 2.5 1.8 4 4.5 4 8a8 8 0 1 1-16 0c0-3.5 2-6.5 4.5-8.5C9.5 6 11 4.5 12 2z"/></svg>
                                    </template>
                                    <template x-if="service.badge === 'Premium'">
                                        <svg class="w-3 h-3 fill-current text-white/95" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                    </template>
                                    <template x-if="service.badge === 'Baru'">
                                        <svg class="w-3 h-3 text-white/95" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                    </template>
                                    <template x-if="service.badge === 'Bergaransi' || service.badge === 'Hemat'">
                                        <svg class="w-3 h-3 text-white/95" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </template>
                                    <span x-text="service.badge"></span>
                                </span>
                            </div>
                        </template>
                    </a>
                    <div class="p-5 flex flex-col flex-1">
                        <div class="text-xs font-medium mb-1 text-blue-600" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="service.category"></div>
                        <a :href="'/servis/' + (service.slug || service.id)" class="no-underline text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                            <h3 class="font-bold text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition text-[0.95rem] leading-snug line-clamp-2 mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="service.name"></h3>
                        </a>
                        <p class="text-xs leading-relaxed text-slate-500 dark:text-slate-400 line-clamp-3 text-justify mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="service.desc"></p>
                        <a :href="'https://wa.me/{{ \App\Models\Setting::cleanWhatsapp() }}?text=' + encodeURIComponent('Halo Pelangi Glass, saya ingin konsultasi layanan ' + service.name)" target="_blank" rel="noopener noreferrer" class="mt-auto w-full flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-semibold text-white transition-all hover:opacity-90 bg-blue-700 hover:bg-blue-800 no-underline shadow-xs hover:scale-[1.02] active:scale-95" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            <x-icons.whatsapp class="w-3.5 h-3.5 shrink-0" />
                            <span>Hubungi Kami</span>
                        </a>
                    </div>
                </div>
            </template>
        </div>

        <!-- Lazy Loading Sentinel (x-intersect) -->
        <div x-show="hasMore" x-intersect.margin.200px="loadMore()" class="py-8 text-center">
            <button @click="loadMore()" type="button" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-semibold shadow-xs transition active:scale-95 cursor-pointer" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                <i data-lucide="arrow-down" class="w-3.5 h-3.5"></i>
                <span>Tampilkan Lebih Banyak Layanan</span>
            </button>
        </div>

        <!-- Bottom CTA Card -->
        <x-cta-card
            message="Layanan yang Anda butuhkan tidak ada di daftar? Hubungi kami, kami siap memberikan konsultasi gratis."
            button-label="Hubungi Kami"
            whatsapp-text="Halo Pelangi Glass, layanan yang saya butuhkan tidak ada di daftar. Saya ingin konsultasi gratis."
        />
    </div>
</div>

@endsection
