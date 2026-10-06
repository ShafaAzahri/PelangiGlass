@extends('layouts.app', ['title' => $service->name . ' - Pelangi Glass'])

@section('content')

    <div class="pt-[76px] md:pt-[88px] bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen transition-colors">
        <section class="py-12 sm:py-16">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs text-slate-400 mb-8" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    <a href="{{ url('/') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition no-underline text-slate-500 dark:text-slate-400">Beranda</a>
                    <span>/</span>
                    <a href="{{ url('/servis') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition no-underline text-slate-500 dark:text-slate-400">Layanan & Servis</a>
                    <span>/</span>
                    <span class="text-slate-700 dark:text-slate-200 truncate max-w-xs">{{ $service->name }}</span>
                </nav>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
                    <!-- Service Image -->
                    <div class="lg:col-span-6 space-y-4">
                        <div class="rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm relative">
                            <img src="{{ $service->image_url }}" alt="{{ $service->name }}" loading="lazy" decoding="async" class="w-full h-80 sm:h-96 object-cover">
                            @if($service->badge)
                                <span class="absolute top-4 left-4 text-xs font-bold px-3 py-1 rounded-full bg-blue-600 text-white shadow-sm" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                    {{ $service->badge->value }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Service Info -->
                    <div class="lg:col-span-6 space-y-6">
                        <div>
                            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider block mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $service->category->name }}
                            </span>
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-slate-100 leading-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $service->name }}
                            </h1>
                            <p class="text-sm text-slate-600 dark:text-slate-300 mt-3 leading-relaxed" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $service->description }}
                            </p>
                        </div>

                        <!-- Highlights Badge -->
                        <div class="grid grid-cols-2 gap-4 p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800">
                            @if($service->warranty_period)
                                <div class="space-y-0.5">
                                    <span class="text-[11px] font-bold text-slate-400 uppercase" style="font-family: 'Plus Jakarta Sans', sans-serif;">Jaminan Mutu:</span>
                                    <div class="text-sm font-bold text-emerald-700 dark:text-emerald-400 flex items-center gap-1.5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                                        {{ $service->warranty_period }}
                                    </div>
                                </div>
                            @endif
                            @if($service->estimated_duration)
                                <div class="space-y-0.5">
                                    <span class="text-[11px] font-bold text-slate-400 uppercase" style="font-family: 'Plus Jakarta Sans', sans-serif;">Estimasi Pengerjaan:</span>
                                    <div class="text-sm font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                        <i data-lucide="clock" class="w-4 h-4 text-slate-500"></i>
                                        {{ $service->estimated_duration }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- CTA Booking WhatsApp -->
                        <div class="pt-4 border-t border-slate-200 dark:border-slate-800">
                            <x-whatsapp-button :text="'Halo Pelangi Glass, saya ingin booking janji temu untuk layanan ' . $service->name" label="Booking / Konsultasi via WhatsApp" class="w-full py-4 text-sm font-bold rounded-xl shadow-md" />
                        </div>
                    </div>
                </div>

                <!-- Layanan Terkait -->
                @if(isset($otherServices) && $otherServices->count() > 0)
                    <div class="mt-16 pt-10 border-t border-slate-200 dark:border-slate-800">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                Layanan & Servis Lainnya
                            </h3>
                            <a href="{{ url('/servis') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition no-underline" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                Lihat Semua Servis →
                            </a>
                        </div>

                        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-5">
                            @foreach($otherServices as $os)
                                <a href="{{ url('/servis/' . $os->slug) }}" class="rounded-2xl overflow-hidden flex flex-col transition-all duration-300 group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-blue-300 dark:hover:border-blue-700 hover:-translate-y-1 hover:shadow-md no-underline">
                                    <div class="overflow-hidden shrink-0" style="height: 140px;">
                                        <img src="{{ $os->image_url }}" alt="{{ $os->name }}" loading="lazy" decoding="async" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    </div>
                                    <div class="p-4 flex flex-col flex-1">
                                        <div class="text-[11px] font-semibold text-blue-600 mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                            {{ $os->category->name }}
                                        </div>
                                        <h4 class="font-bold text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition text-xs line-clamp-2 mb-2 leading-snug" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                            {{ $os->name }}
                                        </h4>
                                        @if($os->warranty_period)
                                            <div class="mt-auto text-[11px] text-emerald-700 font-semibold" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                                ✓ {{ $os->warranty_period }}
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Back button -->
                <div class="mt-10">
                    <a href="{{ url('/servis') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-blue-600 hover:text-blue-800 transition no-underline" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali ke Katalog Servis
                    </a>
                </div>
            </div>
        </section>
    </div>

@endsection
