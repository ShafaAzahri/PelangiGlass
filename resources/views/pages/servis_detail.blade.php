@extends('layouts.app', ['title' => $service->name . ' - Pelangi Glass'])

@section('content')

    <section class="py-12 sm:py-16 bg-white min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-8">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition">Beranda</a>
                <span>/</span>
                <a href="{{ route('services.index') }}" class="hover:text-blue-600 transition">Layanan & Servis</a>
                <span>/</span>
                <span class="text-slate-600 truncate max-w-xs">{{ $service->name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
                <!-- Service Image -->
                <div class="lg:col-span-6 space-y-4">
                    <div class="rounded-3xl overflow-hidden border border-slate-200 bg-slate-100 shadow-sm relative">
                        <img src="{{ $service->image_path ?? asset('images/workshop.jpg') }}" alt="{{ $service->name }}" class="w-full h-80 sm:h-96 object-cover">
                        @if($service->badge)
                            <span class="absolute top-4 left-4 text-xs font-bold px-3 py-1 rounded-full bg-blue-600 text-white shadow-sm">
                                {{ $service->badge->value }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Service Info -->
                <div class="lg:col-span-6 space-y-6">
                    <div>
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider block mb-1">
                            {{ $service->category->name }}
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                            {{ $service->name }}
                        </h1>
                        <p class="text-sm text-slate-600 mt-3 leading-relaxed">
                            {{ $service->description }}
                        </p>
                    </div>

                    <!-- Highlights Badge -->
                    <div class="grid grid-cols-2 gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-200/80">
                        @if($service->warranty_period)
                            <div class="space-y-0.5">
                                <span class="text-[11px] font-bold text-slate-400 uppercase">Jaminan Mutu:</span>
                                <div class="text-sm font-bold text-emerald-700 flex items-center gap-1.5">
                                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                                    {{ $service->warranty_period }}
                                </div>
                            </div>
                        @endif
                        @if($service->estimated_duration)
                            <div class="space-y-0.5">
                                <span class="text-[11px] font-bold text-slate-400 uppercase">Estimasi Pengerjaan:</span>
                                <div class="text-sm font-bold text-slate-800 flex items-center gap-1.5">
                                    <i data-lucide="clock" class="w-4 h-4 text-slate-500"></i>
                                    {{ $service->estimated_duration }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- SOP Steps -->
                    <div class="text-slate-600 text-sm leading-relaxed space-y-4 border-t border-slate-100 pt-4">
                        <h4 class="font-bold text-slate-800 text-sm">Alur Pengerjaan & Standar Layanan:</h4>
                        {!! $service->process_steps ?? '<p>Dikerjakan langsung oleh teknisi spesialis berpengalaman di workshop Pelangi Glass Purwokerto.</p>' !!}
                    </div>

                    <!-- Action Button -->
                    <div class="pt-4 border-t border-slate-100">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp', '6281390288875')) }}?text={{ urlencode('Halo Pelangi Glass, saya ingin konsultasi dan booking servis ' . $service->name) }}" target="_blank" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl flex items-center justify-center gap-2 shadow-md transition">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                            Booking / Jadwalkan Servis via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
