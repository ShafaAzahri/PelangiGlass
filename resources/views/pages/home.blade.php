@extends('layouts.app')

@section('content')

    <!-- 1. Hero Slider Section -->
    <section id="beranda" class="relative overflow-hidden bg-slate-950 text-white" x-data="{
        current: 0,
        banners: [
            @foreach($banners as $b)
                {
                    img: '{{ $b->image_path }}',
                    title: '{{ addslashes($b->title) }}',
                    subtitle: '{{ addslashes($b->subtitle) }}',
                    btnText: '{{ addslashes($b->button_text ?? 'Konsultasi Gratis') }}',
                    btnUrl: '{{ addslashes($b->button_url ?? '#kontak') }}'
                },
            @endforeach
        ],
        next() { this.current = (this.current + 1) % this.banners.length },
        prev() { this.current = (this.current - 1 + this.banners.length) % this.banners.length },
        init() {
            if (this.banners.length > 1) {
                setInterval(() => this.next(), 6000);
            }
        }
    }">
        <div class="relative w-full min-h-[480px] sm:min-h-[580px] lg:min-h-[640px] flex items-center">
            <template x-for="(b, idx) in banners" :key="idx">
                <div x-show="current === idx" 
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 scale-105"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-500"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute inset-0">
                    <img :src="b.img" :alt="b.title" class="w-full h-full object-cover object-center brightness-50">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                </div>
            </template>

            <!-- Banner Text Content -->
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full">
                <div class="max-w-2xl space-y-4">
                    <div class="inline-flex items-center gap-2 bg-blue-600/30 border border-blue-500/40 text-blue-300 text-xs font-semibold px-3 py-1.5 rounded-full">
                        <i data-lucide="shield-check" class="w-4 h-4 text-blue-400"></i>
                        <span>Spesialis Kaca Mobil Sejak 1992 • Purwokerto</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight" x-text="banners[current]?.title">
                        Kaca Mobil Jernih Perjalanan Lebih Aman
                    </h1>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed" x-text="banners[current]?.subtitle">
                        Pemasangan presisi kaca mobil original OEM dan kaca film tolak panas bergaransi resmi anti-bocor.
                    </p>
                    <div class="pt-2 flex flex-wrap gap-3">
                        <a :href="banners[current]?.btnUrl" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-6 py-3.5 rounded-xl shadow-md transition">
                            <span x-text="banners[current]?.btnText">Konsultasi Sekarang</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold text-sm px-6 py-3.5 rounded-xl border border-white/20 backdrop-blur-sm transition">
                            Lihat Semua Layanan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Arrows -->
            <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-black/40 hover:bg-blue-600 border border-white/20 flex items-center justify-center text-white transition" aria-label="Previous">
                <i data-lucide="chevron-left" class="w-5 h-5"></i>
            </button>
            <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-black/40 hover:bg-blue-600 border border-white/20 flex items-center justify-center text-white transition" aria-label="Next">
                <i data-lucide="chevron-right" class="w-5 h-5"></i>
            </button>
        </div>
    </section>

    <!-- 2. Profil Workshop & Fasilitas Ruang Tunggu -->
    <section id="tentang" class="py-20 bg-white border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                <!-- Visual Workshop -->
                <div class="lg:col-span-6">
                    <div class="rounded-3xl overflow-hidden shadow-xl border border-slate-200/80 bg-slate-100 relative group">
                        <img src="{{ asset('images/workshop.jpg') }}" alt="Workshop Pelangi Glass Purwokerto" class="w-full h-[420px] object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute bottom-4 left-4 right-4 bg-white/95 backdrop-blur-md p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                            <div>
                                <div class="text-xs font-bold text-blue-600 uppercase tracking-wider">Standar Internasional</div>
                                <div class="text-sm font-semibold text-slate-800">Sealant Lem Anti-Bocor Teruji</div>
                            </div>
                            <span class="text-xs bg-emerald-100 text-emerald-800 font-bold px-2.5 py-1 rounded-full">Garansi 1 Thn</span>
                        </div>
                    </div>
                </div>

                <!-- Konten Narasi & Statistik -->
                <div class="lg:col-span-6 space-y-6">
                    <div>
                        <span class="text-xs font-bold tracking-wider text-blue-600 uppercase">Spesialis Kaca Mobil • Sejak 1992</span>
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight mt-1.5 mb-3">
                            Selamat Datang di Pelangi Glass Purwokerto
                        </h2>
                        <p class="text-sm font-semibold text-slate-700 mb-2">
                            Pemasangan Presisi Kaca Mobil Original OEM & Kaca Film Bergaransi Resmi
                        </p>
                        <p class="text-sm text-slate-600 leading-relaxed text-justify">
                            Selama lebih dari 30 tahun, Pelangi Glass dipercaya melayani penggantian, pemasangan, dan perbaikan kaca untuk berbagai tipe dan merek mobil. Dikerjakan langsung oleh teknisi spesialis dengan standar lem sealant internasional anti-bocor serta estimasi biaya yang transparan.
                        </p>
                    </div>

                    <!-- 3 Key Stats -->
                    <div class="grid grid-cols-3 gap-4 py-4 border-y border-slate-100">
                        <div>
                            <div class="text-2xl sm:text-3xl font-black text-slate-900">30+</div>
                            <div class="text-xs text-slate-500 font-medium mt-0.5">Tahun Pengalaman</div>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-black text-blue-600">100%</div>
                            <div class="text-xs text-slate-500 font-medium mt-0.5">Kaca Asli OEM</div>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-black text-slate-900">Semua</div>
                            <div class="text-xs text-slate-500 font-medium mt-0.5">Merek & Tipe Mobil</div>
                        </div>
                    </div>

                    <!-- Fasilitas Ruang Tunggu Pelanggan -->
                    <div class="space-y-3">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Fasilitas Ruang Tunggu Nyaman:</span>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-700 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                <i data-lucide="fan" class="w-4 h-4 text-blue-500"></i> Ruang Ber-AC
                            </div>
                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-700 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                <i data-lucide="wifi" class="w-4 h-4 text-blue-500"></i> Free Wi-Fi Cepat
                            </div>
                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-700 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                <i data-lucide="tv" class="w-4 h-4 text-blue-500"></i> Smart TV Hiburan
                            </div>
                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-700 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                <i data-lucide="coffee" class="w-4 h-4 text-blue-500"></i> Free Kopi & Teh
                            </div>
                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-700 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                <i data-lucide="glass-water" class="w-4 h-4 text-blue-500"></i> Air Mineral Dingin
                            </div>
                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-700 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                <i data-lucide="battery-charging" class="w-4 h-4 text-blue-500"></i> Charging Station
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Layanan Spesialis Unggulan -->
    <section id="layanan" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <span class="text-xs font-bold tracking-[0.2em] text-blue-600 uppercase">Layanan Spesialis</span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight mt-1">
                        Pilihan Servis Kaca Mobil & Kaca Film
                    </h2>
                </div>
                <a href="{{ route('services.index') }}" class="mt-4 md:mt-0 text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    Lihat Semua Layanan <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredServices as $service)
                    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:border-blue-300 hover:shadow-md transition flex flex-col justify-between group">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">
                                    {{ $service->category->name }}
                                </span>
                                @if($service->badge)
                                    <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-amber-100 text-amber-800">
                                        {{ $service->badge->value }}
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition">
                                {{ $service->name }}
                            </h3>
                            <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                                {{ $service->description }}
                            </p>
                            @if($service->warranty_period || $service->estimated_duration)
                                <div class="pt-2 flex flex-wrap gap-2 text-[11px] font-medium text-slate-500">
                                    @if($service->warranty_period)
                                        <span class="flex items-center gap-1 bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-md">
                                            <i data-lucide="shield-check" class="w-3 h-3"></i> {{ $service->warranty_period }}
                                        </span>
                                    @endif
                                    @if($service->estimated_duration)
                                        <span class="flex items-center gap-1 bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md">
                                            <i data-lucide="clock" class="w-3 h-3"></i> {{ $service->estimated_duration }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="pt-6 mt-6 border-t border-slate-100">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp', '6281390288875')) }}?text={{ urlencode('Halo Pelangi Glass, saya ingin tanya info ' . $service->name) }}" target="_blank" class="w-full flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 hover:bg-blue-700 text-white transition shadow-sm">
                                Konsultasi Layanan Ini
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 4. Nilai BERES Pelangi Glass -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-xs font-bold tracking-[0.2em] text-blue-600 uppercase">Nilai Budaya Kerja</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight mt-1">
                    Komitmen Pelayanan BERES
                </h2>
                <p class="text-sm text-slate-500 mt-2">
                    Standar mutu kerja yang tertanam di setiap teknisi dan staf Pelangi Glass Purwokerto.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                <!-- Bersih -->
                <div class="bg-slate-50 rounded-2xl p-6 text-center border border-slate-100 hover:border-blue-200 transition group">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-blue-100/60 flex items-center justify-center p-3">
                        <img src="{{ asset('images/bersih.png') }}" alt="Bersih" class="w-full h-full object-contain">
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Bersih</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Area kerja dan interior mobil selalu dijaga tetap steril dan rapi tanpa sisa kotoran.
                    </p>
                </div>

                <!-- Edukatif -->
                <div class="bg-slate-50 rounded-2xl p-6 text-center border border-slate-100 hover:border-blue-200 transition group">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-emerald-100/60 flex items-center justify-center p-3">
                        <img src="{{ asset('images/edukatif.png') }}" alt="Edukatif" class="w-full h-full object-contain">
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Edukatif</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Memberikan penjelasan transparan mengenai kondisi kaca dan opsi terbaik sebelum pengerjaan.
                    </p>
                </div>

                <!-- Ramah -->
                <div class="bg-slate-50 rounded-2xl p-6 text-center border border-slate-100 hover:border-blue-200 transition group">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-amber-100/60 flex items-center justify-center p-3">
                        <img src="{{ asset('images/ramah.png') }}" alt="Ramah" class="w-full h-full object-contain">
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Ramah</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pelayanan hangat, bersahabat, dan tanggap mendengarkan setiap keluhan pelanggan.
                    </p>
                </div>

                <!-- Efisien & Cepat -->
                <div class="bg-slate-50 rounded-2xl p-6 text-center border border-slate-100 hover:border-blue-200 transition group">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-purple-100/60 flex items-center justify-center p-3">
                        <img src="{{ asset('images/efisien dan cepat.png') }}" alt="Efisien" class="w-full h-full object-contain">
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Efisien & Cepat</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pengerjaan tepat waktu dengan SOP presisi tinggi tanpa mengurangi kualitas akhir.
                    </p>
                </div>

                <!-- Safety -->
                <div class="bg-slate-50 rounded-2xl p-6 text-center border border-slate-100 hover:border-blue-200 transition group">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-rose-100/60 flex items-center justify-center p-3">
                        <img src="{{ asset('images/safety.png') }}" alt="Safety" class="w-full h-full object-contain">
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Safety First</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Mengutamakan keamanan berkendara melalui standar lem sealant pabrikan dan material OEM.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Galeri Hasil Pengerjaan -->
    <section id="galeri" class="py-20 bg-slate-100" x-data="{
        activeCategory: 'Semua',
        items: [
            @foreach($galleryItems as $gi)
                {
                    cat: '{{ $gi->category->name }}',
                    title: '{{ addslashes($gi->title) }}',
                    car: '{{ addslashes($gi->car_model) }}',
                    img: '{{ $gi->image_path }}'
                },
            @endforeach
        ],
        filtered() {
            if (this.activeCategory === 'Semua') return this.items;
            return this.items.filter(i => i.cat === this.activeCategory);
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
                <div>
                    <span class="text-xs font-bold tracking-[0.2em] text-blue-600 uppercase">Dokumentasi</span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight mt-1">
                        Hasil Pengerjaan Kami
                    </h2>
                </div>

                <!-- Filter Tabs -->
                <div class="flex flex-wrap gap-2">
                    <button @click="activeCategory = 'Semua'" 
                            :class="activeCategory === 'Semua' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-200'" 
                            class="px-4 py-2 rounded-full text-xs font-semibold transition">
                        Semua
                    </button>
                    @foreach($galleryCategories as $gc)
                        <button @click="activeCategory = '{{ $gc->name }}'" 
                                :class="activeCategory === '{{ $gc->name }}' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-200'" 
                                class="px-4 py-2 rounded-full text-xs font-semibold transition">
                            {{ $gc->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Horizontal Scroll / Grid Strip -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                <template x-for="(item, idx) in filtered()" :key="idx">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-xs border border-slate-200 group flex flex-col">
                        <div class="relative h-48 overflow-hidden bg-slate-100">
                            <img :src="item.img" :alt="item.title" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <span class="absolute top-3 left-3 text-[10px] font-bold px-2 py-1 rounded-md bg-black/60 text-white backdrop-blur-xs" x-text="item.cat"></span>
                        </div>
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm mb-1" x-text="item.title"></h4>
                                <p class="text-xs text-blue-600 font-semibold" x-text="item.car"></p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>

    <!-- 6. Testimoni Pelanggan -->
    <section class="py-20 bg-slate-900 text-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mb-12">
                <span class="text-xs font-bold tracking-[0.2em] text-blue-400 uppercase">Testimoni Pelanggan</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight mt-1">
                    Kata Mereka Yang Sudah Percaya
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($testimonials as $testi)
                    <div class="bg-slate-800/90 rounded-2xl p-7 border border-slate-700/60 flex flex-col justify-between">
                        <div class="space-y-4">
                            <!-- Star Ratings -->
                            <div class="flex items-center gap-1 text-amber-400 text-sm">
                                @for($i = 0; $i < $testi->rating; $i++)
                                    ★
                                @endfor
                            </div>
                            <div class="inline-block text-[11px] font-semibold px-2.5 py-0.5 rounded-md bg-slate-700 text-slate-300">
                                {{ $testi->car_model }} • {{ $testi->service_rendered }}
                            </div>
                            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed italic">
                                "{{ $testi->review_text }}"
                            </p>
                        </div>

                        <div class="pt-6 mt-6 border-t border-slate-700/60 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white shadow-inner text-sm" style="background-color: {{ $testi->avatar_color }}">
                                {{ substr($testi->customer_name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-white text-sm">{{ $testi->customer_name }}</h4>
                                <span class="text-[11px] text-slate-400">Pelanggan Terverifikasi</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 7. Artikel & Tips Edukasi Preview -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12">
                <div>
                    <span class="text-xs font-bold tracking-[0.2em] text-blue-600 uppercase">Edukasi & Tips</span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight mt-1">
                        Artikel & Panduan Perawatan Kaca
                    </h2>
                </div>
                <a href="{{ route('articles.index') }}" class="mt-4 sm:mt-0 text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    Lihat Semua Artikel <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($articles as $art)
                    <article class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-xs hover:border-blue-300 hover:shadow-md transition flex flex-col group">
                        <div class="relative h-48 overflow-hidden bg-slate-100">
                            <img src="{{ $art->featured_image }}" alt="{{ $art->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <span class="absolute top-3 left-3 text-[11px] font-bold px-2.5 py-1 rounded-full bg-blue-600 text-white shadow-sm">
                                {{ $art->category->name }}
                            </span>
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                            <div class="space-y-2">
                                <div class="flex items-center gap-3 text-[11px] text-slate-400">
                                    <span class="flex items-center gap-1"><i data-lucide="calendar" class="w-3.5 h-3.5"></i> {{ $art->published_at?->format('d M Y') }}</span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1"><i data-lucide="clock" class="w-3.5 h-3.5"></i> {{ $art->read_time_minutes }} mnt</span>
                                </div>
                                <h3 class="font-bold text-base text-slate-900 group-hover:text-blue-600 transition leading-snug">
                                    <a href="{{ route('articles.show', $art->slug) }}">{{ $art->title }}</a>
                                </h3>
                                <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                                    {{ $art->excerpt }}
                                </p>
                            </div>
                            <div class="pt-2">
                                <a href="{{ route('articles.show', $art->slug) }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                    Baca Selengkapnya <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 8. FAQ Section -->
    <section class="py-20 bg-slate-50 border-t border-slate-200/80">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-xs font-bold tracking-[0.2em] text-blue-600 uppercase">Tanya Jawab</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight mt-1">
                    Pertanyaan yang Sering Diajukan
                </h2>
            </div>

            <div class="space-y-4" x-data="{ selected: 0 }">
                @foreach($faqs as $idx => $faq)
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
                        <button @click="selected = (selected === {{ $idx }} ? null : {{ $idx }})" class="w-full p-5 text-left font-bold text-slate-900 text-sm sm:text-base flex items-center justify-between gap-4">
                            <span>{{ $faq->question }}</span>
                            <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 transition-transform duration-300" :class="{ 'rotate-180': selected === {{ $idx }} }"></i>
                        </button>
                        <div x-show="selected === {{ $idx }}" x-collapse class="px-5 pb-5 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                            {{ $faq->answer }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 9. Form Kontak & Peta Workshop -->
    <section id="kontak" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start mb-12">
                <!-- Info Workshop & Kontak -->
                <div class="lg:col-span-6 space-y-6">
                    <div>
                        <span class="text-xs font-bold tracking-[0.2em] text-blue-600 uppercase">Hubungi Kami</span>
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight mt-1 mb-4">
                            Siap Melayani Anda Hari Ini
                        </h2>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Hubungi kami untuk konsultasi gratis mengenai kondisi kaca mobil Anda atau estimasi biaya pemasangan.
                        </p>
                    </div>

                    <div class="space-y-4 pt-2">
                        <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                <i data-lucide="map-pin" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Alamat Workshop</div>
                                <div class="text-sm font-semibold text-slate-800">{{ \App\Models\Setting::get('address', 'Purwokerto, Banyumas, Jawa Tengah') }}</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                <i data-lucide="phone" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Telepon & WhatsApp</div>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp', '6281390288875')) }}" target="_blank" class="text-sm font-semibold text-slate-800 hover:text-emerald-600 transition">
                                    {{ \App\Models\Setting::get('phone', '+62 813-9028-8875') }}
                                </a>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                <i data-lucide="clock" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Jam Operasional</div>
                                <div class="text-sm font-semibold text-slate-800">{{ \App\Models\Setting::get('operational_hours', 'Senin – Jumat: 08.30 – 16.30 WIB') }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ \App\Models\Setting::get('operational_hours_weekend', 'Sabtu & Minggu: Tutup (Janji Temu via WA)') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulir Kirim Pesan -->
                <div class="lg:col-span-6 bg-slate-50 p-8 rounded-3xl border border-slate-200/80 shadow-md">
                    <h3 class="text-xl font-bold text-slate-900 mb-1">Kirim Pesan / Konsultasi</h3>
                    <p class="text-xs text-slate-500 mb-6">Pesan Anda akan tersimpan di sistem kami dan langsung terhubung ke WhatsApp.</p>

                    @if(session('success'))
                        <div class="mb-5 p-4 rounded-xl bg-emerald-100 border border-emerald-300 text-emerald-800 text-xs font-semibold flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('inquiries.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <!-- Honeypot -->
                        <input type="text" name="website_hp_field" style="display:none !important;" tabindex="-1" autocomplete="off">

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap *</label>
                            <input type="text" name="name" required placeholder="Contoh: Budi Santoso" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm text-slate-900 focus:outline-none focus:border-blue-600 transition">
                            @error('name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor WhatsApp / HP *</label>
                                <input type="tel" name="phone_number" required placeholder="08xxxxxxxxxx" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm text-slate-900 focus:outline-none focus:border-blue-600 transition">
                                @error('phone_number') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Email (Opsional)</label>
                                <input type="email" name="email" placeholder="nama@email.com" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm text-slate-900 focus:outline-none focus:border-blue-600 transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pesan / Kondisi Kaca Mobil *</label>
                            <textarea name="message" rows="4" required placeholder="Ceritakan tipe mobil Anda dan kebutuhan ganti/reparasi kaca..." class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm text-slate-900 focus:outline-none focus:border-blue-600 transition resize-none"></textarea>
                            @error('message') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl transition shadow-md flex items-center justify-center gap-2">
                            <i data-lucide="send" class="w-4 h-4"></i>
                            Kirim Pesan & Terhubung ke WhatsApp
                        </button>
                    </form>
                </div>
            </div>

            <!-- Google Maps Embed -->
            <div class="rounded-3xl overflow-hidden border border-slate-200 shadow-sm">
                <iframe src="https://maps.google.com/maps?q=pelangi+glass+purwokerto&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="340" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>

@endsection
