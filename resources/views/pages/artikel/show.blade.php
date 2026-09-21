@extends('layouts.app', ['title' => $article->title . ' - Pelangi Glass'])

@section('content')

    <!-- Article Header -->
    <article class="py-12 sm:py-16 bg-white min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition">Beranda</a>
                <span>/</span>
                <a href="{{ route('articles.index') }}" class="hover:text-blue-600 transition">Artikel</a>
                <span>/</span>
                <span class="text-slate-600 truncate max-w-xs">{{ $article->title }}</span>
            </nav>

            <!-- Meta & Title -->
            <div class="space-y-4 mb-8">
                <span class="inline-block text-xs font-bold px-3 py-1 rounded-full bg-blue-50 text-blue-600 border border-blue-100">
                    {{ $article->category->name }}
                </span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                    {{ $article->title }}
                </h1>
                <div class="flex items-center gap-4 text-xs text-slate-400 pt-1">
                    <span class="flex items-center gap-1.5"><i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i> {{ $article->published_at?->format('d M Y') }}</span>
                    <span>•</span>
                    <span class="flex items-center gap-1.5"><i data-lucide="clock" class="w-4 h-4 text-slate-400"></i> Waktu Baca {{ $article->read_time_minutes }} Menit</span>
                </div>
            </div>

            <!-- Featured Image -->
            @if($article->featured_image)
                <div class="rounded-3xl overflow-hidden shadow-md mb-10 border border-slate-200 bg-slate-100 max-h-[460px]">
                    <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <!-- Article Body -->
            <div class="prose prose-slate max-w-none text-slate-700 text-sm sm:text-base leading-relaxed space-y-5">
                {!! $article->content !!}
            </div>

            <!-- Share & CTA Consultation -->
            <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-6 bg-slate-50 p-6 rounded-2xl">
                <div>
                    <h4 class="font-bold text-slate-900 text-sm mb-1">Punya Pertanyaan Seputar Kaca Mobil?</h4>
                    <p class="text-xs text-slate-500">Teknisi kami siap memberikan konsultasi dan diagnosa terbaik.</p>
                </div>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp', '6281390288875')) }}?text={{ urlencode('Halo Pelangi Glass, saya baru saja membaca artikel \"' . $article->title . '\" dan ingin konsultasi.') }}" target="_blank" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl flex items-center gap-2 shadow-xs transition shrink-0">
                    <i data-lucide="message-circle" class="w-4 h-4"></i> Konsultasi via WhatsApp
                </a>
            </div>

            <!-- Related Articles -->
            @if($relatedArticles->count() > 0)
                <div class="mt-16 pt-12 border-t border-slate-200">
                    <h3 class="text-xl font-bold text-slate-900 mb-6">Artikel Terkait Lainnya</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        @foreach($relatedArticles as $rel)
                            <a href="{{ route('articles.show', $rel->slug) }}" class="group bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs hover:border-blue-300 transition flex flex-col justify-between">
                                <div class="space-y-2">
                                    <div class="h-32 rounded-xl overflow-hidden bg-slate-100">
                                        <img src="{{ $rel->featured_image }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    </div>
                                    <h4 class="font-bold text-slate-900 text-xs sm:text-sm group-hover:text-blue-600 transition leading-snug line-clamp-2">
                                        {{ $rel->title }}
                                    </h4>
                                </div>
                                <span class="text-[11px] text-blue-600 font-semibold mt-3 block">Baca Selengkapnya →</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </article>

@endsection
