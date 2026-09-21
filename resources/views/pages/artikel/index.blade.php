@extends('layouts.app')

@section('content')

@php
    $defaultArticles = [
        [
            'id' => 1,
            'slug' => 'cara-merawat-kaca-mobil',
            'title' => '5 Cara Merawat Kaca Mobil Agar Tetap Jernih dan Tahan Lama',
            'excerpt' => 'Kaca mobil yang kotor dan baret bisa mengganggu visibilitas saat berkendara. Berikut tips perawatan rutin yang bisa Anda lakukan sendiri di rumah.',
            'category' => 'Tips Perawatan',
            'date' => '2 Sep 2026',
            'readTime' => '4 menit',
            'img' => 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=800&h=500&fit=crop&auto=format',
        ],
        [
            'id' => 2,
            'slug' => 'kaca-film-vs-tanpa-film',
            'title' => 'Kaca Film atau Tanpa Film? Ini Perbedaan yang Perlu Anda Tahu',
            'excerpt' => 'Banyak pemilik kendaraan masih bingung antara manfaat kaca film dan tanpa film. Kami jelaskan keuntungan, kekurangan, dan rekomendasinya.',
            'category' => 'Edukasi',
            'date' => '28 Agu 2026',
            'readTime' => '5 menit',
            'img' => 'https://images.unsplash.com/photo-1526459915562-c5ca724b1d02?w=800&h=500&fit=crop&auto=format',
        ],
        [
            'id' => 3,
            'slug' => 'tanda-kaca-harus-diganti',
            'title' => '7 Tanda Kaca Mobil Anda Sudah Harus Diganti Sekarang',
            'excerpt' => 'Keretakan kecil sering diabaikan, padahal bisa berkembang menjadi bahaya besar. Kenali tanda-tanda kaca yang wajib segera diganti.',
            'category' => 'Keselamatan',
            'date' => '20 Agu 2026',
            'readTime' => '3 menit',
            'img' => 'https://images.unsplash.com/photo-1608259243654-70c070e0f6ed?w=800&h=500&fit=crop&auto=format',
        ],
        [
            'id' => 4,
            'slug' => 'memilih-kaca-film-yang-tepat',
            'title' => 'Panduan Memilih Kaca Film: V-Kool, 3M, atau Solar Gard?',
            'excerpt' => 'Tiga merek ini sering jadi pilihan utama. Kami bandingkan performa, harga, dan garansi masing-masing agar Anda bisa memilih yang paling sesuai.',
            'category' => 'Panduan Produk',
            'date' => '15 Agu 2026',
            'readTime' => '6 menit',
            'img' => 'https://images.unsplash.com/photo-1651084296894-105edab05b26?w=800&h=500&fit=crop&auto=format',
        ],
        [
            'id' => 5,
            'slug' => 'rain-repellent-manfaat',
            'title' => 'Apa Itu Rain Repellent dan Kenapa Mobil Anda Membutuhkannya?',
            'excerpt' => 'Rain repellent bukan sekadar cairan biasa. Produk ini bisa meningkatkan visibilitas saat hujan deras hingga 30%. Simak penjelasan lengkapnya.',
            'category' => 'Tips Perawatan',
            'date' => '10 Agu 2026',
            'readTime' => '4 menit',
            'img' => 'https://images.unsplash.com/photo-1764428950296-be81c8decb97?w=800&h=500&fit=crop&auto=format',
        ],
        [
            'id' => 6,
            'slug' => 'klaim-asuransi-kaca',
            'title' => 'Cara Klaim Asuransi untuk Kerusakan Kaca Mobil — Panduan Lengkap',
            'excerpt' => 'Tidak semua orang tahu bahwa kerusakan kaca bisa diklaim ke asuransi. Kami jelaskan langkah-langkah prosesnya agar tidak ribet.',
            'category' => 'Panduan',
            'date' => '5 Agu 2026',
            'readTime' => '5 menit',
            'img' => 'https://images.unsplash.com/photo-1708805282695-ef186db20192?w=800&h=500&fit=crop&auto=format',
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

<div class="pt-[76px] md:pt-[88px]" style="background: #f8fafc; min-height: 100vh;" x-data="{
    active: 'Semua',
    categories: {{ json_encode($articleCats) }},
    articles: {{ json_encode($items) }},
    get filtered() {
        return this.active === 'Semua' ? this.articles : this.articles.filter(a => a.category === this.active);
    },
    get featured() {
        return this.filtered.length > 0 ? this.filtered[0] : null;
    },
    get rest() {
        return this.filtered.length > 1 ? this.filtered.slice(1) : [];
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
                <button @click="active = c" class="px-4 py-2 rounded-full text-xs font-medium transition-all flex items-center gap-1.5 cursor-pointer" :style="active === c ? 'background: #2563eb; color: #fff; border: 1.5px solid #2563eb;' : 'background: #ffffff; color: #64748b; border: 1.5px solid #e2e8f0;'" style="font-family: 'Plus Jakarta Sans', sans-serif;">
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
                <div class="rounded-2xl overflow-hidden flex flex-col lg:flex-row transition-all duration-300 group" style="background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(15,23,42,0.06);" onmouseenter="this.style.boxShadow='0 8px 28px rgba(37,99,235,0.10)'; this.style.transform='translateY(-3px)'; this.style.borderColor='#bfdbfe';" onmouseleave="this.style.boxShadow='0 1px 4px rgba(15,23,42,0.06)'; this.style.transform='translateY(0)'; this.style.borderColor='#e2e8f0';">
                    <div class="overflow-hidden shrink-0 lg:w-2/5" style="min-height: 220px;">
                        <img :src="featured.img" :alt="featured.title" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-3 flex-wrap">
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium" :style="catStyle(featured.category)" x-text="featured.category"></span>
                            <span class="flex items-center gap-1 text-xs" style="color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif;">
                                <i data-lucide="clock" class="w-3 h-3"></i> <span x-text="featured.readTime"></span>
                            </span>
                        </div>
                        <h3 class="font-bold mb-2 leading-snug text-lg" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #0f172a;" x-text="featured.title"></h3>
                        <p class="text-xs leading-relaxed flex-1 mb-4" style="color: #64748b; font-family: 'Plus Jakarta Sans', sans-serif;" x-text="featured.excerpt"></p>
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
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5" x-show="rest.length > 0">
            <template x-for="artikel in rest" :key="artikel.id">
                <div class="rounded-2xl overflow-hidden flex flex-col transition-all duration-300 group" style="background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(15,23,42,0.06);" onmouseenter="this.style.boxShadow='0 8px 28px rgba(37,99,235,0.10)'; this.style.transform='translateY(-3px)'; this.style.borderColor='#bfdbfe';" onmouseleave="this.style.boxShadow='0 1px 4px rgba(15,23,42,0.06)'; this.style.transform='translateY(0)'; this.style.borderColor='#e2e8f0';">
                    <div class="overflow-hidden shrink-0" style="height: 200px;">
                        <img :src="artikel.img" :alt="artikel.title" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-3 flex-wrap">
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium" :style="catStyle(artikel.category)" x-text="artikel.category"></span>
                            <span class="flex items-center gap-1 text-xs" style="color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif;">
                                <i data-lucide="clock" class="w-3 h-3"></i> <span x-text="artikel.readTime"></span>
                            </span>
                        </div>
                        <h3 class="font-bold mb-2 leading-snug text-sm" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #0f172a;" x-text="artikel.title"></h3>
                        <p class="text-xs leading-relaxed flex-1 mb-4" style="color: #64748b; font-family: 'Plus Jakarta Sans', sans-serif;" x-text="artikel.excerpt"></p>
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
    </div>
</div>

@endsection
