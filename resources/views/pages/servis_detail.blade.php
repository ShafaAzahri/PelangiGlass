@extends('layouts.app', ['title' => $service->name . ' - Pelangi Glass'])

@section('content')

    <div class="pt-[76px] md:pt-[88px] bg-slate-50 min-h-screen">
        <section class="py-12 sm:py-16">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs text-slate-400 mb-8" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    <a href="{{ url('/') }}" class="hover:text-blue-600 transition no-underline text-slate-500">Beranda</a>
                    <span>/</span>
                    <a href="{{ url('/servis') }}" class="hover:text-blue-600 transition no-underline text-slate-500">Layanan & Servis</a>
                    <span>/</span>
                    <span class="text-slate-700 truncate max-w-xs">{{ $service->name }}</span>
                </nav>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
                    <!-- Service Image -->
                    <div class="lg:col-span-6 space-y-4">
                        <div class="rounded-3xl overflow-hidden border border-slate-200 bg-white shadow-sm relative">
                            <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="w-full h-80 sm:h-96 object-cover">
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
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $service->name }}
                            </h1>
                            <p class="text-sm text-slate-600 mt-3 leading-relaxed" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $service->description }}
                            </p>
                        </div>

                        <!-- Highlights Badge -->
                        <div class="grid grid-cols-2 gap-4 p-5 rounded-2xl bg-white border border-slate-200/80">
                            @if($service->warranty_period)
                                <div class="space-y-0.5">
                                    <span class="text-[11px] font-bold text-slate-400 uppercase" style="font-family: 'Plus Jakarta Sans', sans-serif;">Jaminan Mutu:</span>
                                    <div class="text-sm font-bold text-emerald-700 flex items-center gap-1.5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                                        {{ $service->warranty_period }}
                                    </div>
                                </div>
                            @endif
                            @if($service->estimated_duration)
                                <div class="space-y-0.5">
                                    <span class="text-[11px] font-bold text-slate-400 uppercase" style="font-family: 'Plus Jakarta Sans', sans-serif;">Estimasi Pengerjaan:</span>
                                    <div class="text-sm font-bold text-slate-800 flex items-center gap-1.5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                        <i data-lucide="clock" class="w-4 h-4 text-slate-500"></i>
                                        {{ $service->estimated_duration }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- CTA Booking WhatsApp -->
                        <div class="pt-4 border-t border-slate-200">
                            <a href="https://wa.me/6281390288875?text={{ urlencode('Halo Pelangi Glass, saya ingin booking janji temu untuk layanan ' . $service->name) }}" target="_blank" rel="noopener noreferrer" class="w-full py-4 bg-blue-700 hover:bg-blue-800 text-white font-bold text-sm rounded-xl flex items-center justify-center gap-2 shadow-md transition no-underline" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                Booking / Konsultasi via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Back button -->
                <div class="mt-8">
                    <a href="{{ url('/servis') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-blue-600 hover:text-blue-800 transition no-underline" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali ke Katalog Servis
                    </a>
                </div>
            </div>
        </section>
    </div>

@endsection
