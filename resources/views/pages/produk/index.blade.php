@extends('layouts.app')

@section('content')

@php
    $defaultProducts = [
        [
            'id' => 1,
            'slug' => 'kaca-film-v-kool-vk-40',
            'name' => 'Kaca Film V-KOOL VK 40',
            'category' => 'Kaca Film',
            'desc' => 'Film premium anti UV & panas. Garansi 5 tahun. Transmisi cahaya 40%.',
            'img' => 'https://images.unsplash.com/photo-1526459915562-c5ca724b1d02?w=400&h=300&fit=crop&auto=format',
            'badge' => 'Terlaris',
            'vehicle_compatibility' => 'Universal',
            'price' => 'Rp 2.800.000',
        ],
        [
            'id' => 2,
            'slug' => 'kaca-film-3m-crystalline',
            'name' => 'Kaca Film 3M Crystalline',
            'category' => 'Kaca Film',
            'desc' => 'Teknologi multi-layer nano. Blokir 97% panas inframerah. Original 3M.',
            'img' => 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=400&h=300&fit=crop&auto=format',
            'badge' => 'Premium',
            'vehicle_compatibility' => 'Universal',
            'price' => 'Rp 2.500.000',
        ],
        [
            'id' => 3,
            'slug' => 'kaca-depan-avanza-gen-3',
            'name' => 'Kaca Depan Avanza Gen 3',
            'category' => 'Kaca Mobil',
            'desc' => 'Kaca depan original OEM. Cocok untuk Toyota Avanza 2019–2024.',
            'img' => 'https://images.unsplash.com/photo-1699897483215-a66a9ca292b3?w=400&h=300&fit=crop&auto=format',
            'badge' => null,
            'vehicle_compatibility' => 'Toyota Avanza 2019-2024 / Daihatsu Xenia',
            'price' => 'Rp 1.450.000',
        ],
        [
            'id' => 4,
            'slug' => 'kaca-depan-xpander',
            'name' => 'Kaca Depan Xpander',
            'category' => 'Kaca Mobil',
            'desc' => 'Kaca depan original OEM Mitsubishi Xpander 2018–2024.',
            'img' => 'https://images.unsplash.com/photo-1708805282706-f44730b7e527?w=400&h=300&fit=crop&auto=format',
            'badge' => null,
            'vehicle_compatibility' => 'Mitsubishi Xpander 2018-2024',
            'price' => 'Rp 1.650.000',
        ],
        [
            'id' => 5,
            'slug' => 'rain-repellent-soft99',
            'name' => 'Rain Repellent Soft99',
            'category' => 'Perawatan',
            'desc' => 'Cairan anti hujan Jepang. Tahan hingga 3 bulan. Mudah diaplikasikan sendiri.',
            'img' => 'https://images.unsplash.com/photo-1651084296894-105edab05b26?w=400&h=300&fit=crop&auto=format',
            'badge' => 'Baru',
            'vehicle_compatibility' => 'Universal',
            'price' => 'Rp 185.000',
        ],
        [
            'id' => 6,
            'slug' => 'wiper-bosch-aerotwin',
            'name' => 'Wiper Bosch Aerotwin',
            'category' => 'Aksesoris',
            'desc' => 'Wiper flat beam tanpa rangka. Sapuan bersih & merata. Tersedia semua ukuran.',
            'img' => 'https://images.unsplash.com/photo-1526459915562-c5ca724b1d02?w=400&h=300&fit=crop&auto=format',
            'badge' => null,
            'vehicle_compatibility' => 'Universal All Cars',
            'price' => 'Rp 220.000',
        ],
        [
            'id' => 7,
            'slug' => 'karet-seal-kaca-universal',
            'name' => 'Karet Seal Kaca Universal',
            'category' => 'Aksesoris',
            'desc' => 'Karet seal kaca presisi tinggi. Anti bocor & anti debu. Bisa dipasang sendiri.',
            'img' => 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=400&h=300&fit=crop&auto=format',
            'badge' => null,
            'vehicle_compatibility' => 'Universal',
            'price' => 'Rp 150.000',
        ],
        [
            'id' => 8,
            'slug' => 'cairan-pembersih-kaca-pro',
            'name' => 'Cairan Pembersih Kaca Pro',
            'category' => 'Perawatan',
            'desc' => 'Formula khusus tanpa alkohol. Aman untuk semua jenis kaca film.',
            'img' => 'https://images.unsplash.com/photo-1651084296894-105edab05b26?w=400&h=300&fit=crop&auto=format',
            'badge' => null,
            'vehicle_compatibility' => 'Universal',
            'price' => 'Rp 95.000',
        ],
    ];
    $items = (isset($products) && $products->count() > 0)
        ? $products->map(fn($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'slug' => $p->slug,
            'category' => $p->category?->name ?? 'Kaca Mobil',
            'desc' => $p->short_description,
            'img' => $p->image_url,
            'badge' => $p->badge?->value ?? null,
            'vehicle_compatibility' => $p->vehicle_compatibility ?? '',
            'price' => $p->estimated_price ? 'Rp ' . number_format($p->estimated_price, 0, ',', '.') : null,
        ])->toArray()
        : $defaultProducts;
    $productCats = (isset($categories) && $categories->count() > 0)
        ? array_merge(['Semua'], $categories->pluck('name')->toArray())
        : ['Semua', 'Kaca Film', 'Kaca Mobil', 'Aksesoris', 'Perawatan'];
@endphp

<div class="min-h-screen pt-[76px] md:pt-[88px] bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors" x-data="{
    active: 'Semua',
    search: '',
    categories: {{ json_encode($productCats) }},
    products: {{ json_encode($items) }},
    limit: 8,
    pageSize: 8,
    get filtered() {
        return this.products.filter(p => {
            const matchCat = this.active === 'Semua' || p.category === this.active;
            const s = this.search.toLowerCase();
            const matchSearch = !s || p.name.toLowerCase().includes(s) ||
                (p.vehicle_compatibility && p.vehicle_compatibility.toLowerCase().includes(s)) ||
                (p.desc && p.desc.toLowerCase().includes(s));
            return matchCat && matchSearch;
        });
    },
    get visibleProducts() {
        return this.filtered.slice(0, this.limit);
    },
    get hasMore() {
        return this.visibleProducts.length < this.filtered.length;
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
        if (badge === 'Terlaris') return 'bg-gradient-to-r from-red-600 to-rose-600 shadow-rose-950/20';
        if (badge === 'Premium') return 'bg-gradient-to-r from-amber-600 via-amber-500 to-yellow-500 shadow-amber-950/20';
        if (badge === 'Baru') return 'bg-gradient-to-r from-blue-600 to-sky-500 shadow-blue-950/20';
        return 'bg-gradient-to-r from-emerald-600 to-teal-500 shadow-emerald-950/20';
    }
}">
    <div class="max-w-6xl mx-auto px-6 py-12">
        <!-- Search + Filter (matching Produk.tsx exactly) -->
        <div class="flex flex-col sm:flex-row gap-4 mb-10">
            <div class="relative flex-1 max-w-xs">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" placeholder="Cari nama atau tipe mobil..." x-model="search" @input="limit = pageSize" class="w-full pl-9 pr-4 py-2.5 rounded-xl text-sm outline-none transition-all bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-blue-600 dark:focus:border-blue-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            </div>
            <div class="flex gap-2 flex-wrap">
                <template x-for="c in categories" :key="c">
                    <button @click="filterCategory(c)" :class="active === c ? 'bg-blue-600 text-white border border-blue-600 shadow-xs' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700'" class="px-4 py-2 rounded-full text-xs font-medium transition-all cursor-pointer" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="c"></button>
                </template>
            </div>
        </div>

        <!-- Grid Products -->
        <template x-if="filtered.length === 0">
            <div class="text-center py-20 text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Produk tidak ditemukan.
            </div>
        </template>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 items-stretch" x-show="filtered.length > 0">
            <template x-for="product in visibleProducts" :key="product.id">
                <div class="rounded-2xl overflow-hidden transition-all duration-300 group flex flex-col h-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs hover:border-blue-300 dark:hover:border-blue-700 hover:-translate-y-1 hover:shadow-md">
                    <a :href="'/produk/' + (product.slug || product.id)" class="relative overflow-hidden block shrink-0" style="height: 180px;">
                        <img :src="product.img" :alt="product.name" loading="lazy" decoding="async" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <template x-if="product.badge">
                            <div class="absolute top-0 left-0 z-10">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10.5px] font-extrabold uppercase tracking-wider text-white shadow-md rounded-br-xl select-none"
                                      :class="badgeTheme(product.badge)"
                                      style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                    <template x-if="product.badge === 'Terlaris'">
                                        <svg class="w-3 h-3 fill-current text-white/95" viewBox="0 0 24 24"><path d="M12 2c.5 3 2 4.5 4 6 2.5 1.8 4 4.5 4 8a8 8 0 1 1-16 0c0-3.5 2-6.5 4.5-8.5C9.5 6 11 4.5 12 2z"/></svg>
                                    </template>
                                    <template x-if="product.badge === 'Premium'">
                                        <svg class="w-3 h-3 fill-current text-white/95" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                    </template>
                                    <template x-if="product.badge === 'Baru'">
                                        <svg class="w-3 h-3 text-white/95" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                    </template>
                                    <span x-text="product.badge"></span>
                                </span>
                            </div>
                        </template>
                    </a>
                    <div class="p-5 flex flex-col flex-1">
                        <div class="text-xs font-medium mb-1 text-blue-600" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="product.category"></div>
                        <a :href="'/produk/' + (product.slug || product.id)" class="no-underline text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                            <h3 class="font-bold text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition text-[0.95rem] leading-snug line-clamp-2 mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="product.name"></h3>
                        </a>
                        <template x-if="product.price && product.price !== 'Hubungi Kami'">
                            <div class="text-xs font-bold text-blue-700 dark:text-blue-400 mb-1.5" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="product.price"></div>
                        </template>
                        <p class="text-xs leading-relaxed text-slate-500 dark:text-slate-400 line-clamp-2 text-justify mb-3.5" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="product.desc"></p>
                        <a :href="'https://wa.me/{{ \App\Models\Setting::cleanWhatsapp() }}?text=' + encodeURIComponent('Halo Pelangi Glass, saya ingin tanya ketersediaan dan harga ' + product.name)" target="_blank" rel="noopener noreferrer" class="mt-auto w-full flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-semibold text-white transition-all hover:opacity-90 bg-blue-700 hover:bg-blue-800 no-underline shadow-xs hover:scale-[1.02] active:scale-95" style="font-family: 'Plus Jakarta Sans', sans-serif;">
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
                <span>Tampilkan Lebih Banyak Produk</span>
            </button>
        </div>

        <!-- Bottom CTA Card -->
        <x-cta-card
            message="Produk tidak ada di daftar? Hubungi kami, kami bisa bantu carikan."
            button-label="Hubungi Kami"
            whatsapp-text="Halo Pelangi Glass, produk yang saya cari tidak ada di daftar. Mohon informasinya."
        />
</div>

@endsection
