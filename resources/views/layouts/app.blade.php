<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <!-- Anti-FOUC Theme Script -->
    <script>
        (function() {
            try {
                var theme = localStorage.getItem('theme');
                if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {}
        })();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pelangi Glass - Spesialis Kaca Mobil & Kaca Film Resmi Purwokerto' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Pusat spesialis instalasi kaca mobil dan kaca film berkualitas OEM di Purwokerto sejak 1992. Menghadirkan presisi, ketahanan, dan standar keselamatan berkendara terbaik.' }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-emblem.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Vite Styles & Scripts / Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js Plugins & Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Turbo Drive (Instant SPA Page Transitions without full reload) -->
    <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.12/dist/turbo.es2017-umd.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 flex flex-col min-h-screen selection:bg-blue-600 selection:text-white transition-colors duration-200">

    <!-- Navbar (Fixed Top - matching Layout.tsx exactly) -->
    <nav class="fixed top-0 w-full z-50 transition-all duration-300 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 shadow-xs"
         x-data="{
             open: false,
             isHome: {{ request()->is('/') ? 'true' : 'false' }},
             activeSection: (window.location.hash === '#kontak') ? 'kontak' : 'beranda',
             init() {
                 if (!this.isHome) return;
                 this.checkSection();
                 window.addEventListener('scroll', () => this.checkSection(), { passive: true });
                 window.addEventListener('hashchange', () => this.checkSection());
             },
             checkSection() {
                 if (!this.isHome) return;
                 const el = document.getElementById('kontak');
                 if (el) {
                     const rect = el.getBoundingClientRect();
                     const atBottom = (window.innerHeight + window.scrollY) >= (document.documentElement.scrollHeight - 300);
                     if (rect.top <= 200 || atBottom) {
                         this.activeSection = 'kontak';
                         return;
                     }
                 }
                 if (window.location.hash === '#kontak' && window.scrollY > 300) {
                     this.activeSection = 'kontak';
                 } else {
                     this.activeSection = 'beranda';
                 }
             }
         }">
        <!-- Top Precision Brand Accent Line -->
        <div class="w-full h-[2.5px] bg-gradient-to-r from-blue-700 via-blue-500 via-sky-400 via-slate-200 to-red-600"></div>
        <div class="relative z-10 w-full max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 h-[72px] sm:h-[74px] flex items-center justify-between">
            <!-- 1. Left: Brand Logo -->
            <a href="{{ url('/') }}" class="no-underline flex items-center shrink-0 py-1" @click="if (isHome) { activeSection = 'beranda'; }">
                <img src="{{ asset('images/Logo_PELANGI_GLASS__Baru_.png') }}" alt="Pelangi Glass" class="h-8.5 sm:h-9 md:h-10 xl:h-10.5 w-auto object-contain drop-shadow-xs">
            </a>

            <!-- 2. Center: Desktop Navigation Links (Centered with safe margins) -->
            <div class="hidden lg:flex items-center justify-center gap-4 xl:gap-6 2xl:gap-7 h-full flex-1 mx-4 xl:mx-8">
                <a href="{{ url('/') }}"
                   @click="if (isHome) { activeSection = 'beranda'; }"
                   class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2"
                   :class="(isHome && activeSection === 'beranda') ? 'text-[#0f2c59] dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400'"
                   style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">
                    <span>Beranda</span>
                    <template x-if="isHome && activeSection === 'beranda'">
                        <span class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm" style="box-shadow: 0 -1px 4px rgba(220, 38, 38, 0.35);"></span>
                    </template>
                </a>
                <a href="{{ url('/tentang') }}" class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 {{ request()->is('tentang*') ? 'text-[#0f2c59] dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }}" style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">
                    <span>Tentang Kami</span>
                    @if(request()->is('tentang*'))
                        <span class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm" style="box-shadow: 0 -1px 4px rgba(220, 38, 38, 0.35);"></span>
                    @endif
                </a>
                <a href="{{ url('/produk') }}" class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 {{ request()->is('produk*') ? 'text-[#0f2c59] dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }}" style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">
                    <span>Produk</span>
                    @if(request()->is('produk*'))
                        <span class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm" style="box-shadow: 0 -1px 4px rgba(220, 38, 38, 0.35);"></span>
                    @endif
                </a>
                <a href="{{ url('/servis') }}" class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 {{ (request()->is('servis*') || request()->is('layanan*')) ? 'text-[#0f2c59] dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }}" style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">
                    <span>Layanan</span>
                    @if(request()->is('servis*') || request()->is('layanan*'))
                        <span class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm" style="box-shadow: 0 -1px 4px rgba(220, 38, 38, 0.35);"></span>
                    @endif
                </a>
                <a href="{{ url('/promo') }}" class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 {{ request()->is('promo*') ? 'text-[#0f2c59] dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }}" style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">
                    <span>Promo</span>
                    @if(request()->is('promo*'))
                        <span class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm" style="box-shadow: 0 -1px 4px rgba(220, 38, 38, 0.35);"></span>
                    @endif
                </a>
                <a href="{{ url('/artikel') }}" class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 {{ request()->is('artikel*') ? 'text-[#0f2c59] dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }}" style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">
                    <span>Artikel</span>
                    @if(request()->is('artikel*'))
                        <span class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm" style="box-shadow: 0 -1px 4px rgba(220, 38, 38, 0.35);"></span>
                    @endif
                </a>
                <a href="{{ url('/#kontak') }}"
                   @click="if (isHome) { activeSection = 'kontak'; }"
                   class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2"
                   :class="(isHome && activeSection === 'kontak') ? 'text-[#0f2c59] dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400'"
                   style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">
                    <span>Kontak</span>
                    <template x-if="isHome && activeSection === 'kontak'">
                        <span class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm" style="box-shadow: 0 -1px 4px rgba(220, 38, 38, 0.35);"></span>
                    </template>
                </a>
            </div>

            <!-- 3. Right: Action Buttons (Anchored right) -->
            <div class="hidden lg:flex items-center gap-2.5 xl:gap-3 shrink-0">
                <!-- Dark / Light Theme Toggle -->
                <x-theme-toggle />

                <!-- Konsultasi Sekarang Button (Outline Blue) -->
                <a href="{{ \App\Models\Setting::whatsappUrl('Halo Pelangi Glass, saya ingin konsultasi.') }}" target="_blank" rel="noopener noreferrer" class="border-2 border-blue-600 text-blue-600 dark:text-blue-400 dark:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-950 font-semibold text-xs xl:text-[13px] px-3.5 py-1.5 xl:px-4.5 xl:py-2 rounded-xl transition-all no-underline shadow-none whitespace-nowrap active:scale-95" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Konsultasi Sekarang
                </a>

                <!-- Booking Service Button (Solid Red with Calendar Icon) -->
                <a href="{{ \App\Models\Setting::whatsappUrl('Halo Pelangi Glass, saya ingin booking jadwal service.') }}" target="_blank" rel="noopener noreferrer" class="bg-red-600 hover:bg-red-700 text-white font-semibold text-xs xl:text-[13px] px-3.5 py-1.5 xl:px-4.5 xl:py-2 rounded-xl transition-all no-underline shadow-sm hover:shadow-md flex items-center gap-1.5 whitespace-nowrap active:scale-95" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    <span>Booking Service</span>
                </a>
            </div>

            <!-- Mobile Right Controls -->
            <div class="flex lg:hidden items-center gap-2">
                <x-theme-toggle />
                <button class="p-2 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer" @click="open = !open" aria-label="Toggle menu">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div x-show="open" x-transition class="lg:hidden px-6 pb-6 pt-3 flex flex-col gap-3.5 border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xl max-h-[calc(100vh-80px)] overflow-y-auto" style="display: none;">
            <div class="flex flex-col gap-1 py-1">
                <a href="{{ url('/') }}"
                   class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between"
                   :class="(isHome && activeSection === 'beranda') ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-600'"
                   style="text-decoration: none;"
                   @click="open = false; if (isHome) { activeSection = 'beranda'; }">
                    <span>Beranda</span>
                </a>
                <a href="{{ url('/tentang') }}" class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between {{ request()->is('tentang*') ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" style="text-decoration: none;" @click="open = false">
                    <span>Tentang Kami</span>
                </a>
                <a href="{{ url('/produk') }}" class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between {{ request()->is('produk*') ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" style="text-decoration: none;" @click="open = false">
                    <span>Produk</span>
                </a>
                <a href="{{ url('/servis') }}" class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between {{ (request()->is('servis*') || request()->is('layanan*')) ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" style="text-decoration: none;" @click="open = false">
                    <span>Layanan</span>
                </a>
                <a href="{{ url('/promo') }}" class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between {{ request()->is('promo*') ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" style="text-decoration: none;" @click="open = false">
                    <span>Promo</span>
                </a>
                <a href="{{ url('/artikel') }}" class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between {{ request()->is('artikel*') ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-600' }}" style="text-decoration: none;" @click="open = false">
                    <span>Artikel</span>
                </a>
                <a href="{{ url('/#kontak') }}"
                   class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between"
                   :class="(isHome && activeSection === 'kontak') ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-600'"
                   style="text-decoration: none;"
                   @click="open = false; if (isHome) { activeSection = 'kontak'; }">
                    <span>Kontak</span>
                </a>
            </div>

            <!-- Mobile CTA Buttons -->
            <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex flex-col gap-2.5">
                <a href="{{ \App\Models\Setting::whatsappUrl('Halo Pelangi Glass, saya ingin konsultasi.') }}" target="_blank" rel="noopener noreferrer" class="w-full py-2.5 px-4 rounded-xl border-2 border-blue-600 text-blue-600 dark:text-blue-400 dark:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-950 text-center text-sm font-semibold transition-all no-underline">
                    Konsultasi Sekarang
                </a>
                <a href="{{ \App\Models\Setting::whatsappUrl('Halo Pelangi Glass, saya ingin booking jadwal service.') }}" target="_blank" rel="noopener noreferrer" class="w-full py-2.5 px-4 rounded-xl bg-red-600 hover:bg-red-700 text-white text-center text-sm font-semibold transition-all shadow-sm flex items-center justify-center gap-2 no-underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    Booking Service
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 animate-fade-up">
        @yield('content')
    </main>

    <!-- Footer (matching Layout.tsx exactly) -->
    <footer class="pt-16 pb-10 text-slate-300 border-t border-slate-800" style="background: #0b1324;">
        <div class="w-full max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10">
            <!-- Main Footer Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 xl:gap-12 pb-12 border-b border-slate-800">
                <!-- Col 1: Brand & Identity (4 cols on lg) -->
                <div class="lg:col-span-4 flex flex-col gap-4">
                    <a href="{{ url('/') }}" class="inline-block">
                        <img src="{{ asset('images/Logo_PELANGI_GLASS__Baru_.png') }}" alt="Pelangi Glass" class="h-10 sm:h-12 w-auto brightness-110">
                    </a>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed font-normal">
                        Pusat spesialis instalasi kaca mobil dan kaca film berkualitas OEM di Purwokerto sejak 1992. Menghadirkan presisi, ketahanan, dan standar keselamatan berkendara terbaik.
                    </p>
                </div>

                <!-- Col 2: Navigasi Cepat (2 cols on lg) -->
                <div class="lg:col-span-2">
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-white mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Navigasi Cepat
                    </h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm text-slate-400">
                        <li>
                            <a href="{{ url('/') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                <span class="text-blue-500 font-bold">›</span> Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/tentang') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                <span class="text-blue-500 font-bold">›</span> Tentang Pelangi Glass
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/produk') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                <span class="text-blue-500 font-bold">›</span> Katalog Produk & Kaca
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/servis') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                <span class="text-blue-500 font-bold">›</span> Layanan & Servis
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/promo') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                <span class="text-blue-500 font-bold">›</span> Promo & Penawaran
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/artikel') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                <span class="text-blue-500 font-bold">›</span> Artikel & Tips
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/#kontak') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                <span class="text-blue-500 font-bold">›</span> Lokasi & Kontak
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Layanan Unggulan (3 cols on lg) -->
                <div class="lg:col-span-3">
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-white mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Layanan Unggulan
                    </h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm text-slate-400">
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0"></span>
                            <span>Penggantian Kaca Depan OEM</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0"></span>
                            <span>Pemasangan Kaca Film Tolak Panas</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0"></span>
                            <span>Perbaikan Kaca Retak & Beret</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0"></span>
                            <span>Kaca Pintu, Samping & Belakang</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0"></span>
                            <span>Seal Ulang Kaca Bocor / Rembes</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0"></span>
                            <span>Konsultasi Kondisi Kaca Gratis</span>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Info Workshop & Kontak (3 cols on lg) -->
                <div class="lg:col-span-3 flex flex-col gap-4">
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-white mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Workshop & Jam Kerja
                    </h4>
                    <div class="flex flex-col gap-3.5 text-xs sm:text-sm text-slate-400">
                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                            <span>{{ $siteSettings['address'] ?? \App\Models\Setting::get('address', 'Purwokerto, Jawa Tengah') }}</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                            <div>
                                <div class="text-slate-200 font-medium">{{ $siteSettings['operational_hours'] ?? \App\Models\Setting::get('operational_hours', 'Senin – Jumat: 08.30 – 16.30 WIB') }}</div>
                                <div class="text-slate-400 text-xs mt-0.5">{{ $siteSettings['operational_hours_weekend'] ?? \App\Models\Setting::get('operational_hours_weekend', 'Sabtu & Minggu: Tutup (Janji Temu via WA)') }}</div>
                            </div>
                        </div>
                        @php
                            $cleanWa = \App\Models\Setting::cleanWhatsapp();
                            $phoneDisplay = $siteSettings['phone_display'] ?? \App\Models\Setting::get('phone_display', '0813-9028-8875');
                        @endphp
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                            <a href="https://wa.me/{{ $cleanWa }}" target="_blank" rel="noopener noreferrer" class="text-slate-200 hover:text-emerald-400 transition-colors font-medium no-underline">
                                {{ $phoneDisplay }}
                            </a>
                        </div>
                    </div>

                    <!-- Social media links -->
                    <div class="pt-2">
                        <div class="text-xs text-slate-400 mb-2.5">Ikuti Kami:</div>
                        <div class="flex items-center gap-2.5">
                            <a href="{{ \App\Models\Setting::get('facebook', 'https://facebook.com') }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all bg-slate-800/80 hover:bg-blue-600 text-slate-300 hover:text-white">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                            </a>
                            <a href="{{ \App\Models\Setting::get('instagram', 'https://www.instagram.com/pelangiglassofficial') }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all bg-slate-800/80 hover:bg-blue-600 text-slate-300 hover:text-white">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                            </a>
                            <a href="{{ \App\Models\Setting::get('youtube', 'https://youtube.com') }}" target="_blank" rel="noopener noreferrer" aria-label="YouTube" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all bg-slate-800/80 hover:bg-blue-600 text-slate-300 hover:text-white">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar (Properly aligned across the full width) -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
                <div>
                    <span>© {{ date('Y') }} {{ \App\Models\Setting::get('site_name', 'Pelangi Glass Purwokerto') }}. Hak Cipta Dilindungi.</span>
                </div>
                <div class="flex items-center gap-4">
                    <button onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-slate-800/80 hover:bg-slate-700 text-slate-300 hover:text-white text-xs transition-colors cursor-pointer border border-slate-700/60 shadow-xs">
                        <span>Kembali ke Atas</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m18 15-6-6-6 6"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </footer>
    <!-- Floating Hubungi Kami Button -->
    <x-whatsapp-button variant="float" label="Hubungi Kami" text="Halo Pelangi Glass, saya ingin konsultasi dan menanyakan informasi lebih lanjut." />

    <script>
        function initApp() {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }

        document.addEventListener('DOMContentLoaded', initApp);
        document.addEventListener('turbo:load', () => {
            initApp();
            if (window.Alpine && window.Alpine.initTree) {
                window.Alpine.initTree(document.body);
            }
            // Keep theme synchronized with localStorage on turbo navigations
            try {
                if (localStorage.getItem('theme') === 'dark') {
                    document.documentElement.classList.add('dark');
                } else if (localStorage.getItem('theme') === 'light') {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {}
        });
</html>
