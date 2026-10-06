@extends('layouts.app')

@section('content')

@php
    $defaultArticles = [
        [
            'id' => 1,
            'slug' => 'cara-membersihkan-jamur-kaca-mobil',
            'title' => 'Cara Efektif Membersihkan Jamur Kaca Mobil Sendiri di Rumah',
            'excerpt' => 'Jamur kaca dan kerak air sering mengganggu visibilitas saat berkendara di malam hari atau hujan deras. Simak cara aman membersihkannya tanpa merusak lapisan kaca.',
            'category' => 'Tips Perawatan',
            'date' => '2 Sep 2026',
            'readTime' => '4 menit',
            'img' => asset('storage/articles/bersihkan-kaca-dari-jamur.png'),
        ],
        [
            'id' => 2,
            'slug' => 'panduan-merawat-kabin-dan-kaca-mobil',
            'title' => 'Panduan Merawat Kebersihan Kabin & Kaca Mobil Agar Bebas Bau dan Lembap',
            'excerpt' => 'Kabin yang bersih dan kaca bebas embun membuat perjalanan jauh lebih nyaman. Pelajari tips perawatan sirkulasi AC, pembersihan karpet, dan perawatan kaca film mobil.',
            'category' => 'Tips Perawatan',
            'date' => '28 Agu 2026',
            'readTime' => '5 menit',
            'img' => asset('storage/articles/cara-merawat-kabin-mobil.png'),
        ],
        [
            'id' => 3,
            'slug' => 'penyebab-alarm-mobil-bunyi-terus-dan-solusinya',
            'title' => 'Penyebab Alarm Mobil Bunyi Terus Menerus dan Cara Mengatasinya',
            'excerpt' => 'Alarm mobil tiba-tiba berbunyi tanpa sebab di tengah malam? Kenali faktor penyebabnya mulai dari baterai remote, switch pintu, sensor getar kaca, hingga modul alarm.',
            'category' => 'Edukasi',
            'date' => '20 Agu 2026',
            'readTime' => '4 menit',
            'img' => asset('storage/articles/alarm-mobil-nyala-terus.png'),
        ],
        [
            'id' => 4,
            'slug' => 'rekomendasi-aksesoris-kaca-mobil-terbaik',
            'title' => 'Rekomendasi Aksesoris Kaca Mobil Terbaik untuk Kenyamanan Berkendara',
            'excerpt' => 'Mulai dari wiper frameless, talang air (door visor), karet seal kedap suara, hingga cairan rain repellent. Pilih aksesoris yang tepat untuk perlindungan kaca mobil Anda.',
            'category' => 'Panduan Produk',
            'date' => '15 Agu 2026',
            'readTime' => '4 menit',
            'img' => asset('storage/articles/aksesoris-mobil.png'),
        ],
        [
            'id' => 5,
            'slug' => 'ragam-layanan-spesialis-kaca-mobil-pelangi-glass',
            'title' => 'Mengenal Ragam Layanan Spesialis Kaca Mobil & Kaca Film di Pelangi Glass',
            'excerpt' => 'Dari penggantian kaca depan OEM, seal ulang kaca rembes, injeksi kaca retak chip, hingga pemasangan kaca film tolak panas bergaransi resmi di Purwokerto.',
            'category' => 'Panduan',
            'date' => '10 Agu 2026',
            'readTime' => '6 menit',
            'img' => asset('storage/articles/layanan-spesialis-kaca-mobil.png'),
        ],
        [
            'id' => 6,
            'slug' => 'kapan-waktu-tepat-mengganti-kaca-depan-retak',
            'title' => 'Kapan Waktu yang Tepat Mengganti Kaca Depan Mobil yang Retak?',
            'excerpt' => 'Jangan tunda perbaikan retakan kaca depan. Kenali batasan retak yang masih bisa direparasi dan kondisi keretakan yang sudah wajib diganti demi keselamatan keluarga.',
            'category' => 'Keselamatan',
            'date' => '5 Agu 2026',
            'readTime' => '5 menit',
            'img' => asset('storage/articles/kapan-waktu-ganti-kaca-depan.png'),
        ],
    ];
    $items = (isset($articles) && $articles->count() > 0)
        ? $articles->map(fn($a) => [
            'id' => $a->id,
            'slug' => $a->slug,
            'title' => $a->title,
            'excerpt' => $a->excerpt,
            'category' => $a->category?->name ?? 'Edukasi',
            'date' => $a->published_at ? $a->published_at->translatedFormat('d M Y') : 'Terbaru',
            'readTime' => "{$a->read_time_minutes} menit",
            'img' => $a->image_url,
        ])->toArray()
        : $defaultArticles;
    $articleCats = (isset($categories) && $categories->count() > 0)
        ? array_merge(['Semua'], $categories->pluck('name')->toArray())
        : ['Semua', 'Tips Perawatan', 'Edukasi', 'Keselamatan', 'Panduan Produk', 'Panduan'];
@endphp

<div class="pt-[76px] md:pt-[88px] min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors" x-data="{
    active: 'Semua',
    categories: {{ json_encode($articleCats) }},
    articles: {{ json_encode($items) }},
    limit: 6,
    pageSize: 6,
    get filtered() {
        return this.active === 'Semua' ? this.articles : this.articles.filter(a => a.category === this.active);
    },
    get featured() {
        return this.filtered.length > 0 ? this.filtered[0] : null;
    },
    get rest() {
        return this.filtered.length > 1 ? this.filtered.slice(1) : [];
    },
    get visibleRest() {
        return this.rest.slice(0, this.limit);
    },
    get hasMore() {
        return this.visibleRest.length < this.rest.length;
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
    catStyle(cat) {
        const colors = {
            'Tips Perawatan': { bg: '#eff6ff', color: '#1d4ed8' },
            'Edukasi': { bg: '#f0fdf4', color: '#15803d' },
            'Keselamatan': { bg: '#fef2f2', color: '#b91c1c' },
            'Panduan Produk': { bg: '#fef3c7', color: '#92400e' },
            'Panduan': { bg: '#f5f3ff', color: '#6d28d9' }
        };
        const c = colors[cat] || { bg: '#f1f5f9', color: '#475569' };
        return `background: ${c.bg}; color: ${c.color}; font-family: 'Plus Jakarta Sans', sans-serif;`;
    }
}">
    <div class="max-w-6xl mx-auto px-6 py-12">
        <!-- Filter (matching Artikel.tsx exactly) -->
        <div class="flex gap-2 flex-wrap mb-10">
            <template x-for="c in categories" :key="c">
                <button @click="filterCategory(c)" :class="active === c ? 'bg-blue-600 text-white border-blue-600 shadow-xs' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700'" class="px-4 py-2 rounded-full text-xs font-medium transition-all flex items-center gap-1.5 cursor-pointer border" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    <template x-if="c !== 'Semua'">
                        <i data-lucide="tag" class="w-2.5 h-2.5"></i>
                    </template>
                    <span x-text="c"></span>
                </button>
            </template>
        </div>

        <!-- Featured Article (matching Artikel.tsx exactly) -->
        <template x-if="featured">
            <div class="mb-6">
                <div class="rounded-2xl overflow-hidden flex flex-col lg:flex-row transition-all duration-300 group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs hover:border-blue-300 dark:hover:border-blue-700">
                    <div class="overflow-hidden shrink-0 lg:w-2/5" style="min-height: 220px;">
                        <img :src="featured.img" :alt="featured.title" loading="lazy" decoding="async" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-3 flex-wrap">
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium" :style="catStyle(featured.category)" x-text="featured.category"></span>
                            <span class="flex items-center gap-1 text-xs" style="color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif;">
                                <i data-lucide="clock" class="w-3 h-3"></i> <span x-text="featured.readTime"></span>
                            </span>
                        </div>
                        <h3 class="font-bold mb-2 leading-snug text-lg text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="featured.title"></h3>
                        <p class="text-xs leading-relaxed flex-1 mb-4 text-slate-600 dark:text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="featured.excerpt"></p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs" style="color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif;" x-text="featured.date"></span>
                            <a :href="'/artikel/' + featured.slug" class="flex items-center gap-1 text-xs font-semibold transition-all hover:opacity-70 no-underline" style="color: #2563eb; font-family: 'Plus Jakarta Sans', sans-serif;">
                                Baca selengkapnya <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Grid of Remaining Articles -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5" x-show="visibleRest.length > 0">
            <template x-for="artikel in visibleRest" :key="artikel.id">
                <div class="rounded-2xl overflow-hidden flex flex-col transition-all duration-300 group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs hover:border-blue-300 dark:hover:border-blue-700">
                    <div class="overflow-hidden shrink-0" style="height: 200px;">
                        <img :src="artikel.img" :alt="artikel.title" loading="lazy" decoding="async" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-3 flex-wrap">
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium" :style="catStyle(artikel.category)" x-text="artikel.category"></span>
                            <span class="flex items-center gap-1 text-xs" style="color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif;">
                                <i data-lucide="clock" class="w-3 h-3"></i> <span x-text="artikel.readTime"></span>
                            </span>
                        </div>
                        <h3 class="font-bold mb-2 leading-snug text-sm text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="artikel.title"></h3>
                        <p class="text-xs leading-relaxed flex-1 mb-4 text-slate-600 dark:text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="artikel.excerpt"></p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs" style="color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif;" x-text="artikel.date"></span>
                            <a :href="'/artikel/' + artikel.slug" class="flex items-center gap-1 text-xs font-semibold transition-all hover:opacity-70 no-underline" style="color: #2563eb; font-family: 'Plus Jakarta Sans', sans-serif;">
                                Baca selengkapnya <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Lazy Loading Sentinel (x-intersect) -->
        <div x-show="hasMore" x-intersect.margin.200px="loadMore()" class="py-8 text-center">
            <button @click="loadMore()" type="button" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-semibold shadow-xs transition active:scale-95 cursor-pointer" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                <i data-lucide="arrow-down" class="w-3.5 h-3.5"></i>
                <span>Tampilkan Lebih Banyak Artikel</span>
            </button>
        </div>
    </div>
</div>

@endsection
