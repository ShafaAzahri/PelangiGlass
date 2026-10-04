<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
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

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-white text-slate-900 flex flex-col min-h-screen selection:bg-blue-600 selection:text-white" x-data="{ open: false }">

    <!-- Navbar (Fixed Top - matching Layout.tsx exactly) -->
    <nav class="fixed top-0 w-full z-50 transition-all duration-300 bg-white border-b border-slate-200 shadow-xs">
        <!-- Top Precision Brand Accent Line -->
        <div class="w-full h-[2.5px] bg-gradient-to-r from-blue-700 via-blue-500 via-sky-400 via-slate-200 to-red-600"></div>
        <div class="relative z-10 w-full max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 h-[72px] sm:h-[74px] flex items-center justify-between">
            <!-- 1. Left: Brand Logo -->
            <a href="{{ url('/') }}" class="no-underline flex items-center shrink-0 py-1">
                <img src="{{ asset('images/Logo_PELANGI_GLASS__Baru_.png') }}" alt="Pelangi Glass" class="h-8.5 sm:h-9 md:h-10 xl:h-10.5 w-auto object-contain drop-shadow-xs">
            </a>

            <!-- 2. Center: Desktop Navigation Links (Centered with safe margins) -->
            <div class="hidden lg:flex items-center justify-center gap-4 xl:gap-6 2xl:gap-7 h-full flex-1 mx-4 xl:mx-8">
                <a href="{{ url('/') }}" class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 {{ request()->is('/') ? 'text-[#0f2c59] font-bold' : 'text-slate-700 hover:text-blue-600' }}" style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">
                    <span>Beranda</span>
                    @if(request()->is('/'))
                        <span class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm" style="box-shadow: 0 -1px 4px rgba(220, 38, 38, 0.35);"></span>
                    @endif
                </a>
                <a href="{{ url('/tentang') }}" class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 {{ request()->is('tentang*') ? 'text-[#0f2c59] font-bold' : 'text-slate-700 hover:text-blue-600' }}" style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">
                    <span>Tentang Kami</span>
                    @if(request()->is('tentang*'))
                        <span class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm" style="box-shadow: 0 -1px 4px rgba(220, 38, 38, 0.35);"></span>
                    @endif
                </a>
                <a href="{{ url('/produk') }}" class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 {{ request()->is('produk*') ? 'text-[#0f2c59] font-bold' : 'text-slate-700 hover:text-blue-600' }}" style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">
                    <span>Produk</span>
                    @if(request()->is('produk*'))
                        <span class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm" style="box-shadow: 0 -1px 4px rgba(220, 38, 38, 0.35);"></span>
                    @endif
                </a>
                <a href="{{ url('/servis') }}" class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 {{ (request()->is('servis*') || request()->is('layanan*')) ? 'text-[#0f2c59] font-bold' : 'text-slate-700 hover:text-blue-600' }}" style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">
                    <span>Layanan</span>
                    @if(request()->is('servis*') || request()->is('layanan*'))
                        <span class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm" style="box-shadow: 0 -1px 4px rgba(220, 38, 38, 0.35);"></span>
                    @endif
                </a>
                <a href="{{ url('/promo') }}" class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 {{ request()->is('promo*') ? 'text-[#0f2c59] font-bold' : 'text-slate-700 hover:text-blue-600' }}" style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">
                    <span>Promo</span>
                    @if(request()->is('promo*'))
                        <span class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm" style="box-shadow: 0 -1px 4px rgba(220, 38, 38, 0.35);"></span>
                    @endif
                </a>
                <a href="{{ url('/artikel') }}" class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 {{ request()->is('artikel*') ? 'text-[#0f2c59] font-bold' : 'text-slate-700 hover:text-blue-600' }}" style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">
                    <span>Artikel</span>
                    @if(request()->is('artikel*'))
                        <span class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm" style="box-shadow: 0 -1px 4px rgba(220, 38, 38, 0.35);"></span>
                    @endif
                </a>
                <a href="{{ url('/#kontak') }}" class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 text-slate-700 hover:text-blue-600" style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">
                    <span>Kontak</span>
                </a>
            </div>

            <!-- 3. Right: Action Buttons (Anchored right) -->
            <div class="hidden lg:flex items-center gap-2.5 xl:gap-3 shrink-0">
                <!-- Konsultasi Sekarang Button (Outline Blue) -->
                <a href="https://wa.me/6281390288875?text={{ urlencode('Halo Pelangi Glass, saya ingin konsultasi.') }}" target="_blank" rel="noopener noreferrer" class="border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-semibold text-xs xl:text-[13px] px-3.5 py-1.5 xl:px-4.5 xl:py-2 rounded-xl transition-all no-underline shadow-none whitespace-nowrap active:scale-95" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Konsultasi Sekarang
                </a>

                <!-- Booking Service Button (Solid Red with Calendar Icon) -->
                <a href="https://wa.me/6281390288875?text={{ urlencode('Halo Pelangi Glass, saya ingin booking jadwal service.') }}" target="_blank" rel="noopener noreferrer" class="bg-red-600 hover:bg-red-700 text-white font-semibold text-xs xl:text-[13px] px-3.5 py-1.5 xl:px-4.5 xl:py-2 rounded-xl transition-all no-underline shadow-sm hover:shadow-md flex items-center gap-1.5 whitespace-nowrap active:scale-95" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    <span>Booking Service</span>
                </a>
            </div>

            <!-- Mobile Right Controls -->
            <div class="flex lg:hidden items-center">
                <button class="p-2 rounded-xl text-slate-700 hover:bg-slate-100 transition-colors cursor-pointer" @click="open = !open" aria-label="Toggle menu">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div x-show="open" x-transition class="lg:hidden px-6 pb-6 pt-3 flex flex-col gap-3.5 border-t border-slate-200 bg-white shadow-xl max-h-[calc(100vh-80px)] overflow-y-auto" style="display: none;">
            <div class="flex flex-col gap-1 py-1">
                <a href="{{ url('/') }}" class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between {{ request()->is('/') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }}" style="text-decoration: none;" @click="open = false">
                    <span>Beranda</span>
                </a>
                <a href="{{ url('/tentang') }}" class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between {{ request()->is('tentang*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }}" style="text-decoration: none;" @click="open = false">
                    <span>Tentang Kami</span>
                </a>
                <a href="{{ url('/produk') }}" class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between {{ request()->is('produk*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }}" style="text-decoration: none;" @click="open = false">
                    <span>Produk</span>
                </a>
                <a href="{{ url('/servis') }}" class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between {{ (request()->is('servis*') || request()->is('layanan*')) ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }}" style="text-decoration: none;" @click="open = false">
                    <span>Layanan</span>
                </a>
                <a href="{{ url('/promo') }}" class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between {{ request()->is('promo*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }}" style="text-decoration: none;" @click="open = false">
                    <span>Promo</span>
                </a>
                <a href="{{ url('/artikel') }}" class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between {{ request()->is('artikel*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-blue-600' }}" style="text-decoration: none;" @click="open = false">
                    <span>Artikel</span>
                </a>
                <a href="{{ url('/#kontak') }}" class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between text-slate-700 hover:bg-slate-50 hover:text-blue-600" style="text-decoration: none;" @click="open = false">
                    <span>Kontak</span>
                </a>
            </div>

            <!-- Mobile CTA Buttons -->
            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2.5">
                <a href="https://wa.me/6281390288875?text={{ urlencode('Halo Pelangi Glass, saya ingin konsultasi.') }}" target="_blank" rel="noopener noreferrer" class="w-full py-2.5 px-4 rounded-xl border-2 border-blue-600 text-blue-600 hover:bg-blue-50 text-center text-sm font-semibold transition-all no-underline">
                    Konsultasi Sekarang
                </a>
                <a href="https://wa.me/6281390288875?text={{ urlencode('Halo Pelangi Glass, saya ingin booking jadwal service.') }}" target="_blank" rel="noopener noreferrer" class="w-full py-2.5 px-4 rounded-xl bg-red-600 hover:bg-red-700 text-white text-center text-sm font-semibold transition-all shadow-sm flex items-center justify-center gap-2 no-underline">
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
    <footer class="pt-16 pb-8 text-slate-300" style="background: #0b1324; border-top: 1px solid #1e293b;">
        <div class="max-w-6xl mx-auto px-6">
            <!-- Main Footer Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-slate-800">
                <!-- Col 1: Brand & Identity -->
                <div class="flex flex-col gap-4">
                    <a href="{{ url('/') }}" class="inline-block">
                        <img src="{{ asset('images/Logo_PELANGI_GLASS__Baru_.png') }}" alt="Pelangi Glass" class="h-10 sm:h-12 w-auto brightness-110">
                    </a>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed font-normal">
                        Pusat spesialis instalasi kaca mobil dan kaca film berkualitas OEM di Purwokerto sejak 1992. Menghadirkan presisi, ketahanan, dan standar keselamatan berkendara terbaik.
                    </p>
                </div>

                <!-- Col 2: Navigasi Cepat -->
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-white mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Navigasi Cepat
                    </h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm text-slate-400">
                        <li>
                            <a href="{{ url('/') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                <span class="text-blue-500">›</span> Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/tentang') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                <span class="text-blue-500">›</span> Tentang Pelangi Glass
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/produk') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                <span class="text-blue-500">›</span> Katalog Produk & Kaca
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/servis') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                <span class="text-blue-500">›</span> Layanan & Servis
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/promo') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                <span class="text-blue-500">›</span> Promo & Penawaran Spesial
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/artikel') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                <span class="text-blue-500">›</span> Artikel & Tips Perawatan
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/#kontak') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                <span class="text-blue-500">›</span> Lokasi & Kontak
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Layanan Unggulan -->
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-white mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Layanan Unggulan
                    </h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm text-slate-400">
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500/70 shrink-0"></span>
                            <span>Penggantian Kaca Depan OEM</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500/70 shrink-0"></span>
                            <span>Pemasangan Kaca Film Tolak Panas</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500/70 shrink-0"></span>
                            <span>Perbaikan Kaca Retak & Beret</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500/70 shrink-0"></span>
                            <span>Kaca Pintu, Samping & Belakang</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500/70 shrink-0"></span>
                            <span>Seal Ulang Kaca Bocor / Rembes</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500/70 shrink-0"></span>
                            <span>Konsultasi Kondisi Kaca Gratis</span>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Info Workshop & Kontak -->
                <div class="flex flex-col gap-4">
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-white mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Workshop & Jam Kerja
                    </h4>
                    <div class="flex flex-col gap-3 text-xs sm:text-sm text-slate-400">
                        <div class="flex items-start gap-2.5">
                            <i data-lucide="map-pin" class="w-4 h-4 text-blue-400 shrink-0 mt-0.5"></i>
                            <span>{{ \App\Models\Setting::get('address', 'Purwokerto, Jawa Tengah') }}</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i data-lucide="clock" class="w-4 h-4 text-amber-400 shrink-0 mt-0.5"></i>
                            <div>
                                <div class="text-slate-200 font-medium">{{ \App\Models\Setting::get('operational_hours', 'Senin – Jumat: 08.30 – 16.30 WIB') }}</div>
                                <div class="text-slate-400 text-xs mt-0.5">{{ \App\Models\Setting::get('operational_hours_weekend', 'Sabtu & Minggu: Tutup (Janji Temu via WA)') }}</div>
                            </div>
                        </div>
                        @php
                            $waNumber = \App\Models\Setting::get('whatsapp', '6281390288875');
                            $cleanWa = preg_replace('/[^0-9]/', '', $waNumber);
                            if (str_starts_with($cleanWa, '0')) {
                                $cleanWa = '62' . substr($cleanWa, 1);
                            }
                            $phoneDisplay = \App\Models\Setting::get('phone_display', '0813-9028-8875');
                        @endphp
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="phone" class="w-4 h-4 text-emerald-400 shrink-0"></i>
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

            <!-- Bottom Bar -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400 text-center sm:text-left">
                <div>
                    <span>© {{ date('Y') }} {{ \App\Models\Setting::get('site_name', 'Pelangi Glass Purwokerto') }}. Hak Cipta Dilindungi.</span>
                </div>
                <div class="flex items-center gap-4">
                    <button onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-800/60 hover:bg-slate-800 text-slate-300 hover:text-white text-xs transition-colors cursor-pointer border-0">
                        <span>Kembali ke Atas</span>
                        <i data-lucide="chevron-up" class="w-3.5 h-3.5"></i>
                    </button>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Hubungi Kami Button -->
    <a href="https://wa.me/{{ $cleanWa ?? '6281390288875' }}?text={{ urlencode('Halo Pelangi Glass, saya ingin konsultasi dan menanyakan informasi lebih lanjut.') }}" target="_blank" rel="noopener noreferrer" class="fixed bottom-6 right-6 z-50 px-5 py-3 rounded-full flex items-center justify-center gap-2.5 shadow-xl transition-all duration-300 hover:scale-105 active:scale-95 text-white font-semibold text-sm no-underline hover:bg-blue-700" style="background: #2563eb; text-decoration: none; box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.45);" aria-label="Hubungi Kami">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
        <span>Hubungi Kami</span>
    </a>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
