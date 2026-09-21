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
    <nav class="fixed top-0 w-full z-50 bg-white/95 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3.5 md:py-4 flex items-center justify-between">
            <a href="{{ url('/') }}" class="no-underline flex items-center max-w-[220px] sm:max-w-[280px] md:w-[320px]">
                <img src="{{ asset('images/Logo_PELANGI_GLASS__Baru_.png') }}" alt="Pelangi Glass" class="h-10 sm:h-12 md:h-14 w-auto object-contain">
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="{{ url('/') }}" class="text-[15px] font-medium transition-colors {{ request()->is('/') ? 'text-blue-600 font-semibold' : 'text-slate-600 hover:text-blue-600' }}" style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">Beranda</a>
                <a href="{{ url('/tentang') }}" class="text-[15px] font-medium transition-colors {{ request()->is('tentang*') ? 'text-blue-600 font-semibold' : 'text-slate-600 hover:text-blue-600' }}" style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">Tentang</a>
                <a href="{{ url('/produk') }}" class="text-[15px] font-medium transition-colors {{ request()->is('produk*') ? 'text-blue-600 font-semibold' : 'text-slate-600 hover:text-blue-600' }}" style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">Produk</a>
                <a href="{{ url('/servis') }}" class="text-[15px] font-medium transition-colors {{ request()->is('servis*') ? 'text-blue-600 font-semibold' : 'text-slate-600 hover:text-blue-600' }}" style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">Servis</a>
                <a href="{{ url('/artikel') }}" class="text-[15px] font-medium transition-colors {{ request()->is('artikel*') ? 'text-blue-600 font-semibold' : 'text-slate-600 hover:text-blue-600' }}" style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">Artikel</a>
                <a href="{{ url('/#kontak') }}" class="text-[15px] font-medium text-slate-600 hover:text-blue-600 transition-colors" style="font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;">Kontak</a>
            </div>

            <!-- Mobile Right Controls -->
            <div class="flex md:hidden items-center">
                <button class="p-2 rounded-xl text-slate-700 hover:bg-slate-100 transition-colors cursor-pointer" @click="open = !open" aria-label="Toggle menu">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div x-show="open" x-transition class="md:hidden px-6 pb-6 pt-2 flex flex-col gap-3.5 border-t border-slate-200 bg-white shadow-xl" style="display: none;">
            <a href="{{ url('/') }}" class="text-sm font-medium py-1.5 {{ request()->is('/') ? 'text-blue-600 font-bold' : 'text-slate-700 hover:text-blue-600' }}" style="text-decoration: none;" @click="open = false">Beranda</a>
            <a href="{{ url('/tentang') }}" class="text-sm font-medium py-1.5 {{ request()->is('tentang*') ? 'text-blue-600 font-bold' : 'text-slate-700 hover:text-blue-600' }}" style="text-decoration: none;" @click="open = false">Tentang</a>
            <a href="{{ url('/produk') }}" class="text-sm font-medium py-1.5 {{ request()->is('produk*') ? 'text-blue-600 font-bold' : 'text-slate-700 hover:text-blue-600' }}" style="text-decoration: none;" @click="open = false">Produk</a>
            <a href="{{ url('/servis') }}" class="text-sm font-medium py-1.5 {{ request()->is('servis*') ? 'text-blue-600 font-bold' : 'text-slate-700 hover:text-blue-600' }}" style="text-decoration: none;" @click="open = false">Servis</a>
            <a href="{{ url('/artikel') }}" class="text-sm font-medium py-1.5 {{ request()->is('artikel*') ? 'text-blue-600 font-bold' : 'text-slate-700 hover:text-blue-600' }}" style="text-decoration: none;" @click="open = false">Artikel</a>
            <a href="{{ url('/#kontak') }}" class="text-sm font-medium py-1.5 text-slate-700 hover:text-blue-600" style="text-decoration: none;" @click="open = false">Kontak</a>
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
                    <div class="flex flex-wrap gap-2 pt-1">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-blue-400"></i>
                            Garansi Pemasangan
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium bg-amber-500/10 text-amber-400 border border-amber-500/20">
                            Sejak 1992
                        </span>
                    </div>
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
                            <span>Purwokerto, Jawa Tengah</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <i data-lucide="clock" class="w-4 h-4 text-amber-400 shrink-0 mt-0.5"></i>
                            <div>
                                <div class="text-slate-200 font-medium">Senin – Jumat: 08.30 – 16.30 WIB</div>
                                <div class="text-slate-400 text-xs mt-0.5">Sabtu & Minggu: Tutup (Janji Temu via WA)</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="phone" class="w-4 h-4 text-emerald-400 shrink-0"></i>
                            <a href="https://wa.me/6281390288875" target="_blank" rel="noopener noreferrer" class="text-slate-200 hover:text-emerald-400 transition-colors font-medium no-underline">
                                0813-9028-8875
                            </a>
                        </div>
                    </div>

                    <!-- Social media links -->
                    <div class="pt-2">
                        <div class="text-xs text-slate-400 mb-2.5">Ikuti Kami:</div>
                        <div class="flex items-center gap-2.5">
                            <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all bg-slate-800/80 hover:bg-blue-600 text-slate-300 hover:text-white">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                            </a>
                            <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" aria-label="Twitter" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all bg-slate-800/80 hover:bg-blue-600 text-slate-300 hover:text-white">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                            </a>
                            <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" aria-label="YouTube" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all bg-slate-800/80 hover:bg-blue-600 text-slate-300 hover:text-white">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58a2.78 2.78 0 0 0 1.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.47a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"></path><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="white"></polygon></svg>
                            </a>
                            <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all bg-slate-800/80 hover:bg-blue-600 text-slate-300 hover:text-white">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400 text-center sm:text-left">
                <div>
                    <span>© {{ date('Y') }} Pelangi Glass Purwokerto. Hak Cipta Dilindungi.</span>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ url('/admin') }}" class="hover:text-slate-300 transition-colors no-underline">Panel Admin</a>
                    <button onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-800/60 hover:bg-slate-800 text-slate-300 hover:text-white text-xs transition-colors cursor-pointer border-0">
                        <span>Kembali ke Atas</span>
                        <i data-lucide="chevron-up" class="w-3.5 h-3.5"></i>
                    </button>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button (matching Layout.tsx exactly) -->
    <a href="https://wa.me/6281390288875" target="_blank" rel="noopener noreferrer" class="fixed bottom-6 right-6 z-50 w-14 h-14 rounded-full flex items-center justify-center shadow-lg transition-all hover:scale-110" style="background: #25d366; text-decoration: none;" aria-label="Chat WhatsApp">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="white">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"></path>
        </svg>
    </a>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
