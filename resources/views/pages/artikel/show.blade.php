@extends('layouts.app', ['title' => $article->title . ' - Pelangi Glass'])

@section('content')

    <div class="pt-[76px] md:pt-[88px] bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen transition-colors">
        <article class="py-12 sm:py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    <a href="{{ url('/') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition no-underline text-slate-500 dark:text-slate-400">Beranda</a>
                    <span>/</span>
                    <a href="{{ url('/artikel') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition no-underline text-slate-500 dark:text-slate-400">Artikel</a>
                    <span>/</span>
                    <span class="text-slate-700 dark:text-slate-200 truncate max-w-xs">{{ $article->title }}</span>
                </nav>

                <!-- Meta & Title -->
                <div class="space-y-4 mb-8">
                    <span class="inline-block text-xs font-bold px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/70 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ $article->category->name }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-slate-100 tracking-tight leading-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ $article->title }}
                    </h1>
                    <div class="flex items-center gap-4 text-xs text-slate-400 pt-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        <span class="flex items-center gap-1.5"><i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i> {{ $article->published_at?->format('d M Y') ?? '2026' }}</span>
                        <span>•</span>
                        <span class="flex items-center gap-1.5"><i data-lucide="clock" class="w-3.5 h-3.5 text-slate-400"></i> Waktu Baca {{ $article->read_time_minutes ?? 4 }} Menit</span>
                    </div>
                </div>

                <!-- Featured Image -->
                @if($article->featured_image)
                    <div class="rounded-3xl overflow-hidden shadow-md mb-10 border border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-slate-900 h-64 sm:h-80 md:h-[400px] w-full">
                        <img src="{{ $article->image_url }}" alt="{{ $article->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover object-top">
                    </div>
                @endif

                <!-- Article Body -->
                <div class="prose prose-slate dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 text-sm sm:text-base leading-relaxed space-y-5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    {!! $article->content !!}
                </div>

                <!-- Consultation Box -->
                <div class="mt-12 pt-8 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-6 bg-slate-50 dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800">
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-slate-100 text-sm mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">Punya Pertanyaan Seputar Kaca Mobil?</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">Teknisi kami siap memberikan konsultasi dan diagnosa terbaik.</p>
                    </div>
                    <x-whatsapp-button :text="'Halo Pelangi Glass, saya baru membaca artikel \"' . $article->title . '\" dan ingin konsultasi.'" label="Konsultasi via WhatsApp" class="px-6 py-3 text-xs shrink-0" />
                </div>
                <!-- Rekomendasi Artikel Terkait (PRD FR-4.2) -->
                @if(isset($relatedArticles) && $relatedArticles->count() > 0)
                    <div class="mt-14 pt-10 border-t border-slate-200 dark:border-slate-800">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                Artikel & Tips Terkait
                            </h3>
                            <a href="{{ url('/artikel') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition no-underline" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                Lihat Semua Tips →
                            </a>
                        </div>

                        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-5">
                            @foreach($relatedArticles as $rel)
                                <a href="{{ url('/artikel/' . $rel->slug) }}" class="rounded-2xl overflow-hidden flex flex-col transition-all duration-300 group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-blue-300 dark:hover:border-blue-700 hover:-translate-y-1 hover:shadow-md no-underline">
                                    <div class="overflow-hidden shrink-0" style="height: 140px;">
                                        <img src="{{ $rel->image_url }}" alt="{{ $rel->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    </div>
                                    <div class="p-4 flex flex-col flex-1">
                                        <div class="text-[11px] font-semibold text-blue-600 mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                            {{ $rel->category->name }}
                                        </div>
                                        <h4 class="font-bold text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition text-xs line-clamp-2 mb-2 leading-snug" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                            {{ $rel->title }}
                                        </h4>
                                        <div class="mt-auto flex items-center gap-1 text-[11px] text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                            <i data-lucide="clock" class="w-3 h-3"></i> {{ $rel->read_time_minutes ?? 4 }} menit baca
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Back to Articles -->
                <div class="mt-10">
                    <a href="{{ url('/artikel') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-blue-600 hover:text-blue-800 transition no-underline" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali ke Daftar Artikel
                    </a>
                </div>
            </div>
        </article>
    </div>

@endsection
