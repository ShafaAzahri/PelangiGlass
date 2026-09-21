@extends('layouts.app')

@section('content')

    <!-- 1. HERO SLIDER (matching Home.tsx Hero exactly) -->
    <section id="beranda" class="relative overflow-hidden pt-[76px] md:pt-[88px]" style="background: #0a0f1a;" x-data="{
        slides: [
            @if(isset($banners) && $banners->count() > 0)
                @foreach($banners as $b)
                    { img: '{{ asset(ltrim($b->image_path, '/')) }}', alt: '{{ addslashes($b->title ?? 'Pelangi Glass Banner') }}' },
                @endforeach
            @else
                { img: '{{ asset('banner1.png') }}', alt: 'Kaca Mobil Jernih Perjalanan Lebih Aman' },
                { img: '{{ asset('banner2.png') }}', alt: 'Pelangi Glass Banner 2' }
            @endif
        ],
        current: 0,
        timer: null,
        next() { this.current = (this.current + 1) % this.slides.length },
        prev() { this.current = (this.current - 1 + this.slides.length) % this.slides.length },
        init() {
            this.timer = setInterval(() => this.next(), 5000);
        }
    }">
        <!-- Banner image with fade -->
        <div class="w-full relative">
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="current === index" x-transition.opacity.duration.400ms class="w-full">
                    <img :src="slide.img" :alt="slide.alt" class="w-full block" style="max-height: 90vh; object-fit: cover; object-position: center;">
                </div>
            </template>
        </div>

        <!-- Left arrow -->
        <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 flex items-center justify-center rounded-full transition-all cursor-pointer" style="background: rgba(0,0,0,0.35); border: 1px solid rgba(255,255,255,0.2); color: #fff;" onmouseenter="this.style.background='#2563eb'" onmouseleave="this.style.background='rgba(0,0,0,0.35)'">
            <i data-lucide="chevron-left" class="w-5 h-5"></i>
        </button>

        <!-- Right arrow -->
        <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 flex items-center justify-center rounded-full transition-all cursor-pointer" style="background: rgba(0,0,0,0.35); border: 1px solid rgba(255,255,255,0.2); color: #fff;" onmouseenter="this.style.background='#2563eb'" onmouseleave="this.style.background='rgba(0,0,0,0.35)'">
            <i data-lucide="chevron-right" class="w-5 h-5"></i>
        </button>

        <!-- Dot indicators -->
        <div class="absolute bottom-5 left-1/2 -translate-x-1/2 z-20 flex gap-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="current = index" class="transition-all rounded-full cursor-pointer p-0 border-0" :style="current === index ? 'width: 28px; height: 8px; background: #2563eb;' : 'width: 8px; height: 8px; background: rgba(255,255,255,0.5);'"></button>
            </template>
        </div>
    </section>

    <!-- 2. WELCOME & FACILITIES (matching Home.tsx WelcomeAndFacilities exactly) -->
    <section id="tentang" class="py-16 lg:py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
                <!-- Kolom Kiri: Visual Workshop Kaca Mobil -->
                <div class="lg:col-span-6 flex">
                    <div class="w-full h-full min-h-[380px] sm:min-h-[440px] lg:min-h-[490px] rounded-2xl overflow-hidden shadow-lg border border-slate-200/80 bg-slate-50 flex">
                        <img src="{{ asset('workshop-illustration.jpg') }}" alt="Workshop Spesialis Kaca Mobil Pelangi Glass" class="w-full h-full min-h-[380px] sm:min-h-[440px] lg:min-h-[490px] object-cover object-center block transition-transform duration-700 hover:scale-[1.02]">
                    </div>
                </div>

                <!-- Kolom Kanan: Profil, Nilai Kepercayaan & Fasilitas -->
                <div class="lg:col-span-6">
                    <!-- Eyebrow Spesialisasi -->
                    <div class="flex flex-wrap items-center gap-2 mb-2.5">
                        <span class="text-xs font-bold tracking-wider text-blue-600 uppercase" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            Spesialis Kaca Mobil Sejak 1992 • Purwokerto
                        </span>
                    </div>

                    <!-- Title Utama -->
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight mb-3" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Selamat Datang di<br class="hidden sm:inline" /> Pelangi Glass Purwokerto
                    </h2>

                    <!-- Tagline Elegan -->
                    <p class="text-xs sm:text-sm font-semibold text-slate-700 mb-3.5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Pemasangan Presisi Kaca Mobil Original OEM & Kaca Film Bergaransi Resmi
                    </p>

                    <!-- Narasi Ringkas & Berwibawa (Text Justify) -->
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5 text-justify" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Selama lebih dari 30 tahun, Pelangi Glass dipercaya melayani penggantian, pemasangan, dan perbaikan kaca untuk berbagai tipe dan merek mobil. Dikerjakan langsung oleh teknisi spesialis dengan standar lem sealant internasional anti-bocor serta estimasi biaya yang transparan.
                    </p>

                    <!-- 3 Key Stats Row -->
                    <div class="grid grid-cols-3 gap-3 py-3.5 mb-5 border-y border-slate-100">
                        <div>
                            <div class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">30+</div>
                            <div class="text-[11px] sm:text-xs text-slate-500 font-medium mt-0.5">Tahun Pengalaman</div>
                        </div>
                        <div>
                            <div class="text-xl sm:text-2xl font-black text-blue-600 tracking-tight">100%</div>
                            <div class="text-[11px] sm:text-xs text-slate-500 font-medium mt-0.5">Kaca Asli OEM</div>
                        </div>
                        <div>
                            <div class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Semua</div>
                            <div class="text-[11px] sm:text-xs text-slate-500 font-medium mt-0.5">Merek & Tipe Mobil</div>
                        </div>
                    </div>

                    <!-- Fasilitas Ruang Tunggu Pelanggan -->
                    <div class="mb-5">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-2.5">
                            Fasilitas Ruang Tunggu Pelanggan
                        </span>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            <div class="flex items-center gap-2 py-2 px-2.5 rounded-lg bg-slate-50 border border-slate-100 text-slate-700 text-xs font-medium">
                                <i data-lucide="coffee" class="w-3.5 h-3.5 text-blue-600 shrink-0"></i>
                                <span class="truncate text-[11px] sm:text-xs">Free Coffee & Teh</span>
                            </div>
                            <div class="flex items-center gap-2 py-2 px-2.5 rounded-lg bg-slate-50 border border-slate-100 text-slate-700 text-xs font-medium">
                                <i data-lucide="smartphone-charging" class="w-3.5 h-3.5 text-blue-600 shrink-0"></i>
                                <span class="truncate text-[11px] sm:text-xs">Free Charging</span>
                            </div>
                            <div class="flex items-center gap-2 py-2 px-2.5 rounded-lg bg-slate-50 border border-slate-100 text-slate-700 text-xs font-medium">
                                <i data-lucide="glass-water" class="w-3.5 h-3.5 text-blue-600 shrink-0"></i>
                                <span class="truncate text-[11px] sm:text-xs">Air Panas & Dingin</span>
                            </div>
                            <div class="flex items-center gap-2 py-2 px-2.5 rounded-lg bg-slate-50 border border-slate-100 text-slate-700 text-xs font-medium">
                                <i data-lucide="tv" class="w-3.5 h-3.5 text-blue-600 shrink-0"></i>
                                <span class="truncate text-[11px] sm:text-xs">TV LED Hiburan</span>
                            </div>
                            <div class="flex items-center gap-2 py-2 px-2.5 rounded-lg bg-slate-50 border border-slate-100 text-slate-700 text-xs font-medium">
                                <i data-lucide="fan" class="w-3.5 h-3.5 text-blue-600 shrink-0"></i>
                                <span class="truncate text-[11px] sm:text-xs">Kipas Angin</span>
                            </div>
                        </div>
                    </div>

                    <!-- Link ke Halaman Tentang -->
                    <div>
                        <a href="{{ url('/tentang') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors uppercase tracking-wider no-underline">
                            Pelajari Profil Lengkap <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. SERVICES (matching Home.tsx Services exactly) -->
    <!-- 3. SERVICES (matching Home.tsx Services & Screenshot exactly) -->
    <section id="layanan" class="py-24 bg-slate-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex items-end justify-between mb-14 flex-wrap gap-4">
                <div>
                    <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3 text-blue-600" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        LAYANAN
                    </div>
                    <h2 class="uppercase text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 800; line-height: 1.05;">
                        SEMUA KEBUTUHAN<br />KACA MOBIL ANDA
                    </h2>
                </div>
                <a href="{{ url('/servis') }}" class="inline-flex items-center gap-2 text-sm font-medium transition-all text-blue-600 hover:text-blue-700 hover:opacity-80 no-underline" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Lihat Semua Paket Servis <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @php
                    $homeServices = [
                        [
                            'title' => 'Penggantian Kaca',
                            'desc' => 'Kaca depan, belakang, dan samping. Produk original bergaransi resmi.',
                            'img' => 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=600&h=400&fit=crop&auto=format'
                        ],
                        [
                            'title' => 'Film Kaca Premium',
                            'desc' => 'Reduksi panas & UV hingga 99%. Pilihan brand V-Kool, 3M, Solar Gard.',
                            'img' => 'https://images.unsplash.com/photo-1526459915562-c5ca724b1d02?w=600&h=400&fit=crop&auto=format'
                        ],
                        [
                            'title' => 'Perbaikan Retak',
                            'desc' => 'Perbaikan kaca baret ringan sebelum menjadi kerusakan permanen.',
                            'img' => 'https://images.unsplash.com/photo-1608259243654-70c070e0f6ed?w=600&h=400&fit=crop&auto=format'
                        ],
                        [
                            'title' => 'Aksesoris Kaca',
                            'desc' => 'Wiper, karet seal, spion, dan perlengkapan kaca lainnya.',
                            'img' => 'https://images.unsplash.com/photo-1651084296894-105edab05b26?w=600&h=400&fit=crop&auto=format'
                        ],
                        [
                            'title' => 'Rain Repellent',
                            'desc' => 'Cairan anti-hujan untuk visibilitas optimal saat berkendara.',
                            'img' => 'https://images.unsplash.com/photo-1764428950296-be81c8decb97?w=600&h=400&fit=crop&auto=format'
                        ],
                        [
                            'title' => 'Konsultasi Gratis',
                            'desc' => 'Cek kondisi kaca mobil Anda tanpa biaya, tanpa komitmen.',
                            'img' => 'https://images.unsplash.com/photo-1708805282695-ef186db20192?w=600&h=400&fit=crop&auto=format'
                        ],
                    ];
                @endphp

                @foreach($homeServices as $s)
                    <div class="rounded-2xl overflow-hidden group cursor-pointer transition-all duration-300 bg-white border border-slate-200 shadow-xs hover:border-blue-300 hover:-translate-y-1 flex flex-col">
                        <div class="overflow-hidden w-full" style="height: 180px;">
                            <img src="{{ $s['img'] }}" alt="{{ $s['title'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <div class="p-5 flex flex-col flex-1">
                            <h3 class="font-bold uppercase mb-2 text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.15rem; letter-spacing: 0.03em;">
                                {{ $s['title'] }}
                            </h3>
                            <p class="text-sm leading-relaxed text-slate-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $s['desc'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 4. WHY US (matching Home.tsx WhyUs & BeresCard exactly) -->
    <section class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <!-- Header -->
            <div class="text-center mb-4">
                <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3 text-blue-600" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    KEUNGGULAN
                </div>
                <h2 class="uppercase mb-3 text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 800; line-height: 1.05;">
                    KENAPA HARUS <span class="text-blue-600">PILIH KAMI?</span>
                </h2>
                <div class="mb-12"></div>
            </div>

            <!-- Cards — baris 1: 3 card, baris 2: 2 card -->
            @php
                $beresValues = [
                    [
                        'letter' => 'B',
                        'title' => 'Bersih & Presisi',
                        'desc' => 'Mengerjakan setiap layanan dengan rapi, detail, dan akurat.',
                        'color' => '#2563eb',
                        'img' => asset('images/bersih.png')
                    ],
                    [
                        'letter' => 'E',
                        'title' => 'Efisien & Cepat',
                        'desc' => 'Menghargai waktu pelanggan dan bekerja dengan ritme produktif.',
                        'color' => '#2563eb',
                        'img' => asset('images/efisien_dan_cepat.png')
                    ],
                    [
                        'letter' => 'R',
                        'title' => 'Ramah & Nyaman',
                        'desc' => 'Melayani dengan sikap baik agar pelanggan merasa dihargai dan tenang.',
                        'color' => '#2563eb',
                        'img' => asset('images/ramah.png')
                    ],
                    [
                        'letter' => 'E',
                        'title' => 'Edukatif',
                        'desc' => 'Membimbing pelanggan agar memahami kondisi kaca dan solusi yang tepat secara jujur dan jelas.',
                        'color' => '#2563eb',
                        'img' => asset('images/edukatif.png')
                    ],
                    [
                        'letter' => 'S',
                        'title' => 'Safety First',
                        'desc' => 'Menjadikan keamanan dan keselamatan teknis operasional bagi karyawan dan pelanggan sebagai prioritas utama dalam setiap langkah kerja.',
                        'color' => '#dc2626',
                        'img' => asset('images/safety.png')
                    ],
                ];
            @endphp

            <div class="flex flex-col gap-5">
                <!-- Baris 1: 3 card -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    @foreach(array_slice($beresValues, 0, 3) as $v)
                        <div class="rounded-3xl flex flex-col overflow-hidden transition-all duration-300 bg-slate-50 border-2 border-slate-200 hover:border-blue-400 hover:-translate-y-1">
                            <div class="w-full overflow-hidden flex items-center justify-center bg-blue-50" style="height: 280px;">
                                <img src="{{ $v['img'] }}" alt="{{ $v['title'] }}" class="w-full h-full object-cover">
                            </div>
                            <div class="p-7 flex flex-col flex-1">
                                <h3 class="font-bold mb-3 leading-snug text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.1rem; color: {{ $v['color'] === '#dc2626' ? '#dc2626' : 'inherit' }};">
                                    {{ $v['title'] }}
                                </h3>
                                <p class="text-sm leading-relaxed text-slate-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                    {{ $v['desc'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Baris 2: 2 card -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    @foreach(array_slice($beresValues, 3, 2) as $v)
                        <div class="rounded-3xl flex flex-col overflow-hidden transition-all duration-300 bg-slate-50 border-2 border-slate-200 hover:border-blue-400 hover:-translate-y-1">
                            <div class="w-full overflow-hidden flex items-center justify-center bg-blue-50" style="height: 280px;">
                                <img src="{{ $v['img'] }}" alt="{{ $v['title'] }}" class="w-full h-full object-cover">
                            </div>
                            <div class="p-7 flex flex-col flex-1">
                                <h3 class="font-bold mb-3 leading-snug text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.1rem; color: {{ $v['color'] === '#dc2626' ? '#dc2626' : 'inherit' }};">
                                    {{ $v['title'] }}
                                </h3>
                                <p class="text-sm leading-relaxed text-slate-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                    {{ $v['desc'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- 5. GALLERY (matching Home.tsx Gallery exactly) -->
    <section id="galeri" class="py-24" style="background: #f1f5f9;" x-data="{
        active: 'Semua',
        galleryCats: ['Semua', 'Kaca Depan', 'Film Kaca', 'Aksesoris', 'Workshop'],
        items: [
            { cat: 'Kaca Depan', img: 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=600&auto=format' },
            { cat: 'Workshop', img: 'https://images.unsplash.com/photo-1708805282695-ef186db20192?w=600&auto=format' },
            { cat: 'Film Kaca', img: 'https://images.unsplash.com/photo-1526459915562-c5ca724b1d02?w=600&auto=format' },
            { cat: 'Kaca Depan', img: 'https://images.unsplash.com/photo-1608259243654-70c070e0f6ed?w=600&auto=format' },
            { cat: 'Aksesoris', img: 'https://images.unsplash.com/photo-1651084296894-105edab05b26?w=600&auto=format' },
            { cat: 'Workshop', img: 'https://images.unsplash.com/photo-1779599507365-1944b37b2980?w=600&auto=format' },
            { cat: 'Film Kaca', img: 'https://images.unsplash.com/photo-1764428950296-be81c8decb97?w=600&auto=format' },
            { cat: 'Aksesoris', img: 'https://images.unsplash.com/photo-1625047509248-ec889cbff17f?w=600&auto=format' },
            { cat: 'Workshop', img: 'https://images.unsplash.com/photo-1615906655593-ad0386982a0f?w=600&auto=format' },
            { cat: 'Kaca Depan', img: 'https://images.unsplash.com/photo-1761014586544-53fe5e1f1e25?w=600&auto=format' },
        ],
        scroll(dir) {
            this.$refs.track.scrollBy({ left: dir === 'right' ? 312 : -312, behavior: 'smooth' });
        }
    }">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex items-end justify-between mb-6">
                <div>
                    <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3" style="color: #2563eb;">
                        Galeri
                    </div>
                    <h2 class="uppercase" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 800; lineHeight: 1.05; color: #0f172a;">
                        Hasil Pengerjaan Kami
                    </h2>
                </div>
                <div class="hidden sm:flex gap-2">
                    <button @click="scroll('left')" class="w-10 h-10 rounded-full flex items-center justify-center transition-all cursor-pointer bg-white border border-slate-200 text-slate-500 hover:bg-blue-600 hover:text-white hover:border-blue-600">
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    </button>
                    <button @click="scroll('right')" class="w-10 h-10 rounded-full flex items-center justify-center transition-all cursor-pointer bg-white border border-slate-200 text-slate-500 hover:bg-blue-600 hover:text-white hover:border-blue-600">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- Filter tabs -->
            <div class="flex flex-wrap gap-2.5 mb-8">
                <template x-for="c in galleryCats" :key="c">
                    <button @click="active = c" class="px-5 py-2 rounded-full text-xs font-semibold uppercase tracking-wider transition-all cursor-pointer" :style="active === c ? 'background: #2563eb; color: #ffffff; border: 1px solid #2563eb; box-shadow: 0 2px 8px rgba(37,99,235,0.25);' : 'background: #ffffff; color: #64748b; border: 1px solid #e2e8f0;'" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="c"></button>
                </template>
            </div>
        </div>

        <!-- Horizontal scroll strip -->
        <div x-ref="track" class="flex gap-3 cursor-grab select-none no-scrollbar px-6" style="overflow-x: auto; scroll-behavior: smooth;">
            <template x-for="(g, i) in items" :key="i">
                <div x-show="active === 'Semua' || active === g.cat" class="relative flex-none rounded-2xl overflow-hidden group" style="width: 300px; height: 400px; box-shadow: 0 2px 10px rgba(15,23,42,0.1);">
                    <img :src="g.img" :alt="g.cat" draggable="false" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 flex items-end p-4" style="background: linear-gradient(to top, rgba(15,23,42,0.65) 0%, transparent 55%);">
                        <span class="text-xs font-semibold uppercase tracking-wider text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="g.cat"></span>
                    </div>
                </div>
            </template>
        </div>
    </section>

    <!-- 6. TESTIMONIALS (matching Home.tsx Testimonials exactly) -->
    <section class="py-24 overflow-hidden" style="background: #0f172a;" x-data="{
        scroll(dir) {
            this.$refs.testitrack.scrollBy({ left: dir * 420, behavior: 'smooth' });
        }
    }">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex items-end justify-between mb-12 flex-wrap gap-4">
                <div>
                    <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3" style="color: #3b82f6;">
                        Testimoni Pelanggan
                    </div>
                    <h2 class="text-white uppercase" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 800; lineHeight: 1.05;">
                        Kata Mereka<br />Yang Sudah Percaya
                    </h2>
                </div>
                <div class="flex items-center gap-3">
                    <span class="hidden sm:inline-block text-xs text-slate-400">
                        Geser untuk melihat testimoni lainnya
                    </span>
                    <div class="flex gap-2">
                        <button aria-label="Sebelumnya" @click="scroll(-1)" class="w-11 h-11 rounded-full flex items-center justify-center transition-all cursor-pointer" style="border: 1px solid rgba(255,255,255,0.12); color: #94a3b8; background: rgba(255,255,255,0.05);" onmouseenter="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.color='#fff';" onmouseleave="this.style.borderColor='rgba(255,255,255,0.12)'; this.style.color='#94a3b8';">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        </button>
                        <button aria-label="Berikutnya" @click="scroll(1)" class="w-11 h-11 rounded-full flex items-center justify-center transition-all hover:opacity-90 cursor-pointer" style="background: #2563eb; color: #fff;">
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @php
            $testimonialsList = [
                [
                    'name' => 'Budi Santoso',
                    'role' => 'Pengusaha',
                    'car' => 'Toyota Innova Zenix',
                    'rating' => 5,
                    'text' => 'Sudah lebih dari 10 tahun langganan di Pelangi Glass untuk semua mobil operasional kantor. Hasil pemasangan kaca depan sangat rapi, tidak ada bocor saat hujan deras, dan harganya sangat fair serta transparan.',
                    'color' => '#2563eb'
                ],
                [
                    'name' => 'dr. Rina Wijayanti',
                    'role' => 'Dokter Umum',
                    'car' => 'Honda CR-V Turbo',
                    'rating' => 5,
                    'text' => 'Kaca film tolak panas sudah 2 tahun terpasang, kabin mobil tetap sejuk meski parkir di luar rumah sakit. Pelayanan teknisinya ramah, edukatif, dan pengerjaannya sangat teliti tanpa lecet sedikitpun.',
                    'color' => '#059669'
                ],
                [
                    'name' => 'Dimas Pratama',
                    'role' => 'Karyawan Swasta',
                    'car' => 'Mitsubishi Pajero Sport',
                    'rating' => 5,
                    'text' => 'Kaca depan retak kena kerikil di tol Pejagan - Pemalang. Langsung dibawa ke Pelangi Glass Purwokerto, pengerjaan cuma 2 jam selesai dan beres. Harga persis seperti estimasi di awal, tanpa biaya siluman.',
                    'color' => '#d97706'
                ],
                [
                    'name' => 'Hendra Kurniawan',
                    'role' => 'Arsitek',
                    'car' => 'Mazda CX-5',
                    'rating' => 5,
                    'text' => 'Sangat memperhatikan detail seal dan karet kaca. Sensor wiper dan kamera ADAS depan tetap berfungsi normal setelah ganti kaca depan OEM. Benar-benar workshop spesialis yang paham teknis mobil modern.',
                    'color' => '#7c3aed'
                ],
                [
                    'name' => 'Siti Rahmawati',
                    'role' => 'Wiraswasta',
                    'car' => 'Toyota Yaris Cross',
                    'rating' => 5,
                    'text' => 'Ruang tunggunya nyaman banget ber-AC dan bersih saat menunggu pengerjaan pasang kaca film. Hasil potongannya presisi komputer, pandangan malam hari tetap jernih dan tidak silau sama sekali.',
                    'color' => '#dc2626'
                ],
                [
                    'name' => 'Agus Setiawan',
                    'role' => 'Kolektor Mobil Klasik',
                    'car' => 'Toyota Land Cruiser VX80',
                    'rating' => 5,
                    'text' => 'Mencari kaca mobil langka untuk seri jadul di Purwokerto awalnya ragu, tapi di Pelangi Glass bisa dipesan dan dipasang dengan presisi tinggi. Reputasi sejak 1992 memang terbukti nyata!',
                    'color' => '#0891b2'
                ],
                [
                    'name' => 'Fajar Nugroho',
                    'role' => 'Pengemudi Online',
                    'car' => 'Daihatsu Sigra',
                    'rating' => 5,
                    'text' => 'Kaca samping kiri pecah malam hari. Pagi-pagi langsung kontak WA, stok ready dan siang hari mobil sudah bisa narik lagi. Pelayanannya cepat dan respon adminnya sangat solutif.',
                    'color' => '#ea580c'
                ],
                [
                    'name' => 'Wahyu Tri Prabowo',
                    'role' => 'Manajer Logistik',
                    'car' => 'Toyota Hilux D-Cab',
                    'rating' => 5,
                    'text' => 'Armada operasional kami rutin servis kaca di sini. Kualitas kaca berstandar SNI/OEM asli dan lem polyurethane yang dipakai berkualitas grade otomotif terbaik. Sangat terjamin keamanannya.',
                    'color' => '#4f46e5'
                ],
            ];
        @endphp

        <div x-ref="testitrack" class="flex gap-5 px-6 pb-4 cursor-grab select-none no-scrollbar" style="overflow-x: auto; scroll-snap-type: x mandatory;">
            @foreach($testimonialsList as $t)
                <div data-card class="shrink-0 rounded-2xl p-7 sm:p-8 flex flex-col justify-between" style="width: min(400px, 84vw); scroll-snap-align: start; background: #1e293b; border: 1px solid rgba(255,255,255,0.08);">
                    <div>
                        <!-- Header card: Stars & Quote -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-1">
                                @for($i = 0; $i < $t['rating']; $i++)
                                    <svg class="w-4 h-4 fill-amber-400 text-amber-400" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                @endfor
                            </div>
                            <i data-lucide="quote" class="w-6 h-6 text-blue-500/40"></i>
                        </div>

                        <!-- Vehicle badge -->
                        <div class="inline-block text-[11px] font-medium px-2.5 py-0.5 rounded-md mb-4 bg-slate-800 text-slate-300 border border-slate-700/60">
                            {{ $t['car'] }}
                        </div>

                        <!-- Testimonial text -->
                        <blockquote class="text-sm sm:text-base leading-relaxed mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 300; color: #cbd5e1;">
                            "{{ $t['text'] }}"
                        </blockquote>
                    </div>

                    <!-- Author info -->
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-700/50">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white shrink-0 shadow-inner text-sm" style="background: {{ $t['color'] }}; font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ substr($t['name'], 0, 1) }}
                        </div>
                        <div>
                            <div class="font-semibold text-white text-sm" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $t['name'] }}
                            </div>
                            <div class="text-xs text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $t['role'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 7. ARTIKEL PREVIEW (matching Home.tsx ArtikelPreview exactly) -->
    <section class="py-24" style="background: #f8fafc;">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex items-end justify-between mb-12 flex-wrap gap-4">
                <div>
                    <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3" style="color: #2563eb; font-family: 'Plus Jakarta Sans', sans-serif;">
                        Blog
                    </div>
                    <h2 class="uppercase" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 800; lineHeight: 1.05; color: #0f172a;">
                        Artikel & Tips
                    </h2>
                </div>
                <a href="{{ url('/artikel') }}" class="inline-flex items-center gap-2 text-sm font-medium transition-all hover:opacity-70 no-underline" style="color: #2563eb; font-family: 'Plus Jakarta Sans', sans-serif;">
                    Lihat Semua Artikel <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            @php
                $articlesPreview = [
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

                $catColors = [
                    'Tips Perawatan' => ['bg' => '#eff6ff', 'color' => '#1d4ed8'],
                    'Edukasi' => ['bg' => '#f0fdf4', 'color' => '#15803d'],
                    'Keselamatan' => ['bg' => '#fef2f2', 'color' => '#b91c1c'],
                    'Panduan Produk' => ['bg' => '#fef3c7', 'color' => '#92400e'],
                    'Panduan' => ['bg' => '#f5f3ff', 'color' => '#6d28d9'],
                ];
            @endphp

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($articlesPreview as $a)
                    @php $cStyle = $catColors[$a['category']] ?? ['bg' => '#f1f5f9', 'color' => '#475569']; @endphp
                    <div class="rounded-2xl overflow-hidden flex flex-col transition-all duration-300 group bg-white border border-slate-200 shadow-xs hover:border-blue-300 hover:-translate-y-1 hover:shadow-md">
                        <div class="overflow-hidden shrink-0" style="height: 200px;">
                            <img src="{{ $a['img'] }}" alt="{{ $a['title'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
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
                            <h3 class="font-bold mb-2 leading-snug text-sm text-slate-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $a['title'] }}
                            </h3>
                            <p class="text-xs leading-relaxed flex-1 mb-4 text-slate-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">
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

    <!-- 8. FAQ (matching Home.tsx FAQ exactly) -->
    <section class="py-24" style="background: #f8fafc;" x-data="{ open: 0 }">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-12 lg:gap-20">
                <!-- Left — sticky label + heading -->
                <div class="lg:w-72 shrink-0">
                    <div class="text-xs font-semibold tracking-[0.18em] uppercase mb-4" style="color: #2563eb; font-family: 'Plus Jakarta Sans', sans-serif;">
                        FAQ
                    </div>
                    <h2 class="uppercase mb-5" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(2rem, 4vw, 2.8rem); font-weight: 900; lineHeight: 1.05; color: #0f172a;">
                        Pertanyaan yang Sering Ditanyakan
                    </h2>
                    <p class="text-sm leading-relaxed" style="color: #64748b; font-family: 'Plus Jakarta Sans', sans-serif;">
                        Masih ada yang mau ditanyakan?
                        <a href="https://wa.me/6281390288875" target="_blank" rel="noopener noreferrer" style="color: #2563eb; font-weight: 600; text-decoration: none;">
                            Hubungi tim kami
                        </a>
                        via WhatsApp, kami siap membantu.
                    </p>
                </div>

                <!-- Right — accordion card -->
                @php
                    $faqsList = [
                        ['q' => 'Berapa lama proses penggantian kaca mobil?', 'a' => 'Umumnya 2–3 jam untuk kaca depan atau belakang. Untuk kaca samping bisa lebih cepat, sekitar 1–1,5 jam. Kami akan informasikan estimasi waktu yang lebih tepat setelah melihat kondisi kendaraan Anda.'],
                        ['q' => 'Apakah ada garansi setelah penggantian kaca?', 'a' => 'Ya, kami memberikan garansi kebocoran 1 tahun untuk setiap penggantian kaca. Jika ada kebocoran dalam periode garansi, kami akan perbaiki tanpa biaya tambahan.'],
                        ['q' => 'Merek kaca apa saja yang tersedia?', 'a' => 'Kami menyediakan kaca original OEM dan berbagai merek aftermarket berkualitas seperti Asahimas, AGC, Pilkington, dan lainnya. Pilihan disesuaikan dengan kebutuhan dan anggaran Anda.'],
                        ['q' => 'Apakah bisa dipanggil ke lokasi (mobile service)?', 'a' => 'Untuk kondisi tertentu kami dapat melayani kunjungan ke lokasi di area Purwokerto dan sekitarnya. Hubungi kami via WhatsApp untuk konfirmasi ketersediaan dan area jangkauan.'],
                        ['q' => 'Merek film kaca apa yang direkomendasikan?', 'a' => 'Kami merekomendasikan V-Kool, 3M, dan Solar Gard — merek premium dengan teknologi penolak panas dan UV terbaik. Semua dilengkapi garansi film 3–5 tahun dan sertifikat keaslian.'],
                        ['q' => 'Apakah asuransi kendaraan bisa digunakan?', 'a' => 'Kami dapat membantu proses klaim asuransi untuk penggantian kaca. Bawa serta dokumen kendaraan dan polis asuransi Anda, tim kami akan membantu prosesnya.'],
                    ];
                @endphp

                <div class="flex-1 rounded-2xl overflow-hidden" style="border: 1.5px solid #e2e8f0; background: #ffffff;">
                    @foreach($faqsList as $idx => $faq)
                        <div style="border-bottom: {{ $idx < count($faqsList) - 1 ? '1px solid #f1f5f9' : 'none' }};">
                            <button class="w-full flex items-center justify-between gap-4 px-7 py-5 text-left bg-transparent border-0 cursor-pointer" @click="open = open === {{ $idx }} ? null : {{ $idx }}">
                                <span class="font-semibold text-sm" style="color: #0f172a; font-family: 'Plus Jakarta Sans', sans-serif;">
                                    {{ $faq['q'] }}
                                </span>
                                <span class="shrink-0 w-7 h-7 rounded-full border flex items-center justify-center transition-all" :style="open === {{ $idx }} ? 'border-color: #2563eb; background: #2563eb;' : 'border-color: #e2e8f0; background: transparent;'">
                                    <template x-if="open === {{ $idx }}">
                                        <svg width="10" height="2" viewBox="0 0 10 2" fill="none"><path d="M1 1h8" stroke="#fff" stroke-width="1.8" stroke-linecap="round"></path></svg>
                                    </template>
                                    <template x-if="open !== {{ $idx }}">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 1v8M1 5h8" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round"></path></svg>
                                    </template>
                                </span>
                            </button>
                            <div class="px-7 pb-6" x-show="open === {{ $idx }}" x-transition>
                                <p class="text-sm leading-relaxed" style="color: #64748b; font-family: 'Plus Jakarta Sans', sans-serif;">
                                    {{ $faq['a'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- 9. CONTACT (matching Home.tsx Contact exactly) -->
    <section id="kontak" class="py-24" style="background: #f4f7fb;">
        <div class="max-w-6xl mx-auto px-6">
            <!-- Top grid: info + form -->
            <div class="grid md:grid-cols-2 gap-12 items-start mb-10">
                <!-- Info -->
                <div>
                    <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3" style="color: #2563eb; font-family: 'Plus Jakarta Sans', sans-serif;">
                        Kontak
                    </div>
                    <h2 class="uppercase mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 800; lineHeight: 1.05; color: #0f172a;">
                        Siap Melayani<br />Anda Hari Ini
                    </h2>
                    <p class="text-sm leading-relaxed mb-8" style="color: #64748b; font-family: 'Plus Jakarta Sans', sans-serif;">
                        Hubungi kami untuk konsultasi gratis. Tim kami siap membantu Senin hingga Jumat.
                    </p>

                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="mt-0.5 shrink-0 w-9 h-9 rounded-full flex items-center justify-center" style="background: #eff6ff; color: #2563eb;">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <div class="text-xs uppercase tracking-widest mb-0.5" style="color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif;">Alamat</div>
                                <div class="text-sm" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #0f172a;">Purwokerto, Banyumas, Jawa Tengah</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="mt-0.5 shrink-0 w-9 h-9 rounded-full flex items-center justify-center" style="background: #eff6ff; color: #2563eb;">
                                <i data-lucide="phone" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <div class="text-xs uppercase tracking-widest mb-0.5" style="color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif;">Telepon / WA</div>
                                <div class="text-sm" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #0f172a;">+62 813-9028-8875</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="mt-0.5 shrink-0 w-9 h-9 rounded-full flex items-center justify-center" style="background: #eff6ff; color: #2563eb;">
                                <i data-lucide="clock" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <div class="text-xs uppercase tracking-widest mb-0.5" style="color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif;">Jam Buka</div>
                                <div class="text-sm" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #0f172a;">Senin – Jumat, 08.30 – 16.30 WIB</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="mt-0.5 shrink-0 w-9 h-9 rounded-full flex items-center justify-center" style="background: #eff6ff; color: #2563eb;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.5" cy="6.5" r="0.5" fill="currentColor"></circle></svg>
                            </div>
                            <div>
                                <div class="text-xs uppercase tracking-widest mb-0.5" style="color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif;">Instagram</div>
                                <div class="text-sm" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #0f172a;">@pelangiglassofficial</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="rounded-2xl p-8" style="background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 4px 20px rgba(15,23,42,0.07);">
                    <h3 class="font-bold mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.1rem; color: #0f172a;">
                        Kirim Pesan
                    </h3>
                    <p class="text-xs mb-6" style="color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif;">
                        Pesan akan dikirim langsung ke WhatsApp kami.
                    </p>

                    @if(session('success'))
                        <div class="mb-4 p-3 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-medium border border-emerald-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('inquiries.store') }}" method="POST" class="flex flex-col gap-4">
                        @csrf
                        <input type="text" name="website_hp_field" class="hidden" tabindex="-1" autocomplete="off">

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569; font-family: 'Plus Jakarta Sans', sans-serif;">
                                Nama Lengkap
                            </label>
                            <input type="text" name="name" required placeholder="Contoh: Budi Santoso" value="{{ old('name') }}" class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition-all" style="border: 1.5px solid #e2e8f0; font-family: 'Plus Jakarta Sans', sans-serif; color: #0f172a; background: #f8fafc;" onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">
                            @error('name')
                                <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569; font-family: 'Plus Jakarta Sans', sans-serif;">
                                Email
                            </label>
                            <input type="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition-all" style="border: 1.5px solid #e2e8f0; font-family: 'Plus Jakarta Sans', sans-serif; color: #0f172a; background: #f8fafc;" onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">
                            @error('email')
                                <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569; font-family: 'Plus Jakarta Sans', sans-serif;">
                                No HP / WhatsApp
                            </label>
                            <input type="tel" name="phone_number" required placeholder="08xxxxxxxxxx" value="{{ old('phone_number') }}" class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition-all" style="border: 1.5px solid #e2e8f0; font-family: 'Plus Jakarta Sans', sans-serif; color: #0f172a; background: #f8fafc;" onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">
                            @error('phone_number')
                                <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5" style="color: #475569; font-family: 'Plus Jakarta Sans', sans-serif;">
                                Pesan
                            </label>
                            <textarea name="message" required placeholder="Ceritakan kondisi kaca mobil Anda atau layanan yang dibutuhkan..." rows="4" class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition-all resize-none" style="border: 1.5px solid #e2e8f0; font-family: 'Plus Jakarta Sans', sans-serif; color: #0f172a; background: #f8fafc;" onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e2e8f0'">{{ old('message') }}</textarea>
                            @error('message')
                                <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90 cursor-pointer border-0" style="background: #2563eb; font-family: 'Plus Jakarta Sans', sans-serif;">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Map full width -->
            <div class="rounded-2xl overflow-hidden" style="border: 1px solid #e2e8f0;">
                <iframe title="Lokasi Pelangi Glass Purwokerto" src="https://maps.google.com/maps?q=pelangi+glass+purwokerto&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="300" style="border: 0; display: block;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <div class="px-5 py-4 flex items-center justify-between" style="background: #ffffff; border-top: 1px solid #e2e8f0;">
                    <div>
                        <div class="text-xs uppercase tracking-widest mb-0.5" style="color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif;">
                            Lokasi
                        </div>
                        <div class="text-sm" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #0f172a;">
                            Purwokerto, Banyumas, Jawa Tengah
                        </div>
                    </div>
                    <a href="https://maps.google.com/?q=pelangi+glass+purwokerto" target="_blank" rel="noopener noreferrer" class="flex items-center gap-1.5 text-xs font-medium transition-all hover:opacity-70 shrink-0 ml-4 no-underline" style="color: #2563eb; font-family: 'Plus Jakarta Sans', sans-serif;">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                        Buka di Maps
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
