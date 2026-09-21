@extends('layouts.app', ['title' => $article->title . ' - Pelangi Glass'])

@section('content')

    <div class="pt-[76px] md:pt-[88px] bg-white min-h-screen">
        <article class="py-12 sm:py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    <a href="{{ url('/') }}" class="hover:text-blue-600 transition no-underline text-slate-500">Beranda</a>
                    <span>/</span>
                    <a href="{{ url('/artikel') }}" class="hover:text-blue-600 transition no-underline text-slate-500">Artikel</a>
                    <span>/</span>
                    <span class="text-slate-700 truncate max-w-xs">{{ $article->title }}</span>
                </nav>

                <!-- Meta & Title -->
                <div class="space-y-4 mb-8">
                    <span class="inline-block text-xs font-bold px-3 py-1 rounded-full bg-blue-50 text-blue-600 border border-blue-100" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ $article->category->name }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
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
                    <div class="rounded-3xl overflow-hidden shadow-md mb-10 border border-slate-200 bg-slate-100 max-h-[460px]">
                        <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <!-- Article Body -->
                <div class="prose prose-slate max-w-none text-slate-700 text-sm sm:text-base leading-relaxed space-y-5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    {!! $article->content !!}
                </div>

                <!-- Consultation Box -->
                <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-6 bg-slate-50 p-6 rounded-2xl border border-slate-200">
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">Punya Pertanyaan Seputar Kaca Mobil?</h4>
                        <p class="text-xs text-slate-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">Teknisi kami siap memberikan konsultasi dan diagnosa terbaik.</p>
                    </div>
                    <a href="https://wa.me/6281390288875?text={{ urlencode('Halo Pelangi Glass, saya baru membaca artikel \"' . $article->title . '\" dan ingin konsultasi.') }}" target="_blank" rel="noopener noreferrer" class="px-6 py-3 bg-blue-700 hover:bg-blue-800 text-white font-semibold text-xs rounded-xl flex items-center gap-2 shadow-xs transition shrink-0 no-underline" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Konsultasi via WhatsApp
                    </a>
                </div>

                <!-- Back to Articles -->
                <div class="mt-8">
                    <a href="{{ url('/artikel') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-blue-600 hover:text-blue-800 transition no-underline" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali ke Daftar Artikel
                    </a>
                </div>
            </div>
        </article>
    </div>

@endsection
