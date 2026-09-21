@extends('layouts.app')

@section('content')

    <!-- Header Banner -->
    <section class="bg-slate-950 text-white py-14 sm:py-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-2xl relative z-10">
            <span class="text-xs font-bold tracking-[0.2em] text-blue-400 uppercase">Edukasi & Wawasan</span>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight mt-2 mb-3">
                Artikel & Tips Perawatan Kaca Mobil
            </h1>
            <p class="text-slate-300 text-sm leading-relaxed">
                Panduan praktis, informasi keselamatan berkendara, dan kiat merawat kaca film agar tetap bening dan tahan lama.
            </p>
        </div>
    </section>

    <!-- Articles Grid & Categories -->
    <section class="py-16 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter & Search -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs mb-10 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex flex-wrap gap-2 w-full md:w-auto">
                    <a href="{{ route('articles.index') }}" 
                       class="px-4 py-2 rounded-full text-xs font-semibold transition {{ !request('kategori') ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Semua Kategori
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('articles.index', ['kategori' => $cat->slug]) }}" 
                           class="px-4 py-2 rounded-full text-xs font-semibold transition {{ request('kategori') === $cat->slug ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>

                <form action="{{ route('articles.index') }}" method="GET" class="w-full md:w-72 relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari topik artikel..." class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:border-blue-600 transition">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-2.5"></i>
                </form>
            </div>

            <!-- Articles Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $art)
                    <article class="bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-xs hover:border-blue-300 hover:shadow-md transition flex flex-col group">
                        <div class="relative h-52 overflow-hidden bg-slate-100">
                            <img src="{{ $art->featured_image }}" alt="{{ $art->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <span class="absolute top-3 left-3 text-[11px] font-bold px-2.5 py-1 rounded-full bg-blue-600 text-white shadow-sm">
                                {{ $art->category->name }}
                            </span>
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                            <div class="space-y-2.5">
                                <div class="flex items-center gap-3 text-xs text-slate-400">
                                    <span class="flex items-center gap-1"><i data-lucide="calendar" class="w-3.5 h-3.5"></i> {{ $art->published_at?->format('d M Y') }}</span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1"><i data-lucide="clock" class="w-3.5 h-3.5"></i> {{ $art->read_time_minutes }} menit</span>
                                </div>
                                <h3 class="font-bold text-base sm:text-lg text-slate-900 group-hover:text-blue-600 transition leading-snug">
                                    <a href="{{ route('articles.show', $art->slug) }}">{{ $art->title }}</a>
                                </h3>
                                <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                                    {{ $art->excerpt }}
                                </p>
                            </div>
                            <div class="pt-3 border-t border-slate-100">
                                <a href="{{ route('articles.show', $art->slug) }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                    Baca Artikel Lengkap <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $articles->links() }}
            </div>
        </div>
    </section>

@endsection
