@extends('layouts.app')

@section('content')

    <!-- Header Banner -->
    <section class="bg-slate-950 text-white py-14 sm:py-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-2xl relative z-10">
            <span class="text-xs font-bold tracking-[0.2em] text-blue-400 uppercase">Layanan Spesialis</span>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight mt-2 mb-3">
                Layanan & Servis Kaca Mobil
            </h1>
            <p class="text-slate-300 text-sm leading-relaxed">
                Penanganan profesional bergaransi oleh teknisi berpengalaman untuk memastikan visibilitas dan keselamatan kabin mobil Anda kembali prima.
            </p>
        </div>
    </section>

    <!-- Services Grid & Filters -->
    <section class="py-16 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter Tabs -->
            <div class="flex flex-wrap gap-2 mb-10 justify-center">
                <a href="{{ route('services.index') }}" 
                   class="px-5 py-2.5 rounded-full text-xs font-semibold transition {{ !request('kategori') ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-200 border border-slate-200' }}">
                    Semua Layanan
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('services.index', ['kategori' => $cat->slug]) }}" 
                       class="px-5 py-2.5 rounded-full text-xs font-semibold transition {{ request('kategori') === $cat->slug ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-200 border border-slate-200' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $srv)
                    <div class="bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-xs hover:border-blue-300 hover:shadow-md transition flex flex-col justify-between group">
                        <div>
                            <!-- Service Photo -->
                            <div class="relative h-52 overflow-hidden bg-slate-100">
                                <img src="{{ $srv->image_path ?? asset('images/workshop.jpg') }}" alt="{{ $srv->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                <div class="absolute top-3 left-3 flex gap-2">
                                    <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-blue-600 text-white shadow-sm">
                                        {{ $srv->category->name }}
                                    </span>
                                    @if($srv->badge)
                                        <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                            {{ $srv->badge->value }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-6 space-y-3">
                                <h3 class="font-bold text-slate-900 text-lg group-hover:text-blue-600 transition leading-snug">
                                    {{ $srv->name }}
                                </h3>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    {{ $srv->description }}
                                </p>
                                
                                <div class="pt-2 flex flex-wrap gap-2 text-xs font-medium">
                                    @if($srv->warranty_period)
                                        <span class="flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-lg border border-emerald-100">
                                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-600"></i>
                                            {{ $srv->warranty_period }}
                                        </span>
                                    @endif
                                    @if($srv->estimated_duration)
                                        <span class="flex items-center gap-1 bg-slate-100 text-slate-700 px-2.5 py-1 rounded-lg">
                                            <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-500"></i>
                                            {{ $srv->estimated_duration }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="p-6 pt-0 border-t border-slate-100 mt-4">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp', '6281390288875')) }}?text={{ urlencode('Halo Pelangi Glass, saya ingin booking/konsultasi layanan ' . $srv->name) }}" target="_blank" class="w-full mt-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-xl flex items-center justify-center gap-2 transition shadow-xs">
                                <i data-lucide="message-circle" class="w-4 h-4"></i> Konsultasi & Jadwalkan Servis
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- SOP & Standar Kerja Section -->
            <div class="mt-20 bg-white p-8 sm:p-12 rounded-3xl border border-slate-200/80 shadow-xs">
                <div class="text-center max-w-2xl mx-auto mb-10">
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Alur Servis</span>
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">4 Langkah Mudah Penanganan di Workshop Kami</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                        <span class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-xs">1</span>
                        <h4 class="font-bold text-slate-800 text-sm">Konsultasi Awal</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Kirim foto kondisi kaca atau kunjungi workshop untuk diagnosa tingkat kerusakan.</p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                        <span class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-xs">2</span>
                        <h4 class="font-bold text-slate-800 text-sm">Estimasi & Pilihan Kaca</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Penjelasan transparan opsi kaca OEM atau aftermarket sesuai preferensi Anda.</p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                        <span class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-xs">3</span>
                        <h4 class="font-bold text-slate-800 text-sm">Pemasangan Presisi</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Pengerjaan dengan SOP lem sealant internasional anti-bocor di workshop berfasilitas nyaman.</p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                        <span class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-xs">4</span>
                        <h4 class="font-bold text-slate-800 text-sm">Uji Mutu & Garansi</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Inspeksi akhir kerapian lem dan penerbitan garansi resmi kebocoran hingga 1 tahun.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
