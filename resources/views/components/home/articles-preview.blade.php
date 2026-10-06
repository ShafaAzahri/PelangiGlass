@props([
    'articles' => null,
])

@php
    $defaultArticlesPreview = [
        [
            'slug' => 'cara-merawat-kaca-mobil',
            'title' => '5 Cara Merawat Kaca Mobil Agar Tetap Jernih dan Tahan Lama',
            'excerpt' => 'Kaca mobil yang kotor dan baret bisa mengganggu visibilitas saat berkendara. Berikut tips perawatan rutin yang bisa Anda lakukan sendiri di rumah.',
            'category' => 'Tips Perawatan',
            'date' => '2 Sep 2026',
            'readTime' => '4 menit',
            'img' => 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=800&h=500&fit=crop&auto=format'
        ],
        [
            'slug' => 'kaca-film-vs-tanpa-film',
            'title' => 'Kaca Film atau Tanpa Film? Ini Perbedaan yang Perlu Anda Tahu',
            'excerpt' => 'Banyak pemilik kendaraan masih bingung antara manfaat kaca film dan tanpa film. Kami jelaskan keuntungan, kekurangan, dan rekomendasinya.',
            'category' => 'Edukasi',
            'date' => '28 Agu 2026',
            'readTime' => '5 menit',
            'img' => 'https://images.unsplash.com/photo-1526459915562-c5ca724b1d02?w=800&h=500&fit=crop&auto=format'
        ],
        [
            'slug' => 'tanda-kaca-harus-diganti',
            'title' => '7 Tanda Kaca Mobil Anda Sudah Harus Diganti Sekarang',
            'excerpt' => 'Keretakan kecil sering diabaikan, padahal bisa berkembang menjadi bahaya besar. Kenali tanda-tanda kaca yang wajib segera diganti.',
            'category' => 'Keselamatan',
            'date' => '20 Agu 2026',
            'readTime' => '3 menit',
            'img' => 'https://images.unsplash.com/photo-1608259243654-70c070e0f6ed?w=800&h=500&fit=crop&auto=format'
        ],
    ];
    $articlesPreview = (isset($articles) && $articles->count() > 0)
        ? $articles->map(fn($a) => [
            'slug' => $a->slug,
            'title' => $a->title,
            'excerpt' => $a->excerpt,
            'category' => $a->category?->name ?? 'Artikel',
            'date' => $a->published_at ? $a->published_at->translatedFormat('d M Y') : 'Terbaru',
            'readTime' => "{$a->read_time_minutes} menit",
            'img' => $a->image_url,
        ])->toArray()
        : $defaultArticlesPreview;

    $catColors = [
        'Tips Perawatan' => ['bg' => '#eff6ff', 'color' => '#1d4ed8'],
        'Edukasi' => ['bg' => '#f0fdf4', 'color' => '#15803d'],
        'Keselamatan' => ['bg' => '#fef2f2', 'color' => '#b91c1c'],
        'Panduan Produk' => ['bg' => '#fef3c7', 'color' => '#92400e'],
        'Panduan' => ['bg' => '#f5f3ff', 'color' => '#6d28d9'],
    ];
@endphp

<section class="py-24 bg-slate-50 dark:bg-slate-950 transition-colors">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex items-end justify-between mb-12 flex-wrap gap-4">
            <div>
                <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3 text-blue-600 dark:text-blue-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Blog
                </div>
                <h2 class="uppercase text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 800; line-height: 1.05;">
                    Artikel & Tips
                </h2>
            </div>
            <a href="{{ url('/artikel') }}" class="inline-flex items-center gap-2 text-sm font-medium transition-all text-blue-600 dark:text-blue-400 hover:opacity-70 no-underline" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Lihat Semua Artikel <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($articlesPreview as $a)
                @php $cStyle = $catColors[$a['category']] ?? ['bg' => '#f1f5f9', 'color' => '#475569']; @endphp
                <div class="rounded-2xl overflow-hidden flex flex-col transition-all duration-300 group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs hover:border-blue-300 dark:hover:border-blue-700 hover:-translate-y-1 hover:shadow-md">
                    <div class="overflow-hidden shrink-0" style="height: 200px;">
                        <img src="{{ $a['img'] }}" alt="{{ $a['title'] }}" loading="lazy" decoding="async" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-3 flex-wrap">
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium" style="background: {{ $cStyle['bg'] }}; color: {{ $cStyle['color'] }}; font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $a['category'] }}
                            </span>
                            <span class="flex items-center gap-1 text-xs text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                <i data-lucide="clock" class="w-3 h-3"></i> {{ $a['readTime'] }}
                            </span>
                        </div>
                        <h3 class="font-bold mb-2 leading-snug text-sm text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ $a['title'] }}
                        </h3>
                        <p class="text-xs leading-relaxed flex-1 mb-4 text-slate-500 dark:text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ $a['excerpt'] }}
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $a['date'] }}
                            </span>
                            <a href="{{ url('/artikel/' . $a['slug']) }}" class="flex items-center gap-1 text-xs font-semibold text-blue-600 hover:opacity-70 transition-all no-underline" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                Baca selengkapnya <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
