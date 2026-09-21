<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pelangi Glass - Spesialis Kaca Mobil & Kaca Film Resmi Purwokerto' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Spesialis pemasangan kaca mobil original OEM dan kaca film tolak panas bergaransi resmi di Purwokerto sejak 1992. Cepat, rapi, dan anti bocor.' }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                            dark: '#0a0f1a',
                            surface: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-white text-slate-800 antialiased selection:bg-blue-600 selection:text-white" x-data="{ mobileMenuOpen: false }">

    <!-- Top Bar (Informasi Cepat) -->
    <div class="bg-slate-900 text-slate-300 text-xs py-2 px-4 border-b border-slate-800 hidden sm:block">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-6">
                <span class="flex items-center gap-1.5"><i data-lucide="map-pin" class="w-3.5 h-3.5 text-blue-400"></i> Purwokerto, Banyumas, Jawa Tengah</span>
                <span class="flex items-center gap-1.5"><i data-lucide="clock" class="w-3.5 h-3.5 text-amber-400"></i> Senin – Jumat: 08.30 – 16.30 WIB</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp', '6281390288875')) }}" target="_blank" class="text-emerald-400 hover:text-emerald-300 flex items-center gap-1 font-semibold transition">
                    <i data-lucide="phone" class="w-3.5 h-3.5"></i> {{ \App\Models\Setting::get('phone', '+62 813-9028-8875') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 no-underline">
                <img src="{{ asset('images/logo.png') }}" alt="Pelangi Glass Purwokerto" class="h-10 sm:h-12 w-auto object-contain">
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center gap-8 text-[15px] font-medium text-slate-600">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition {{ request()->routeIs('home') ? 'text-blue-600 font-semibold' : '' }}">Beranda</a>
                <a href="{{ route('about') }}" class="hover:text-blue-600 transition {{ request()->routeIs('about') ? 'text-blue-600 font-semibold' : '' }}">Tentang Kami</a>
                <a href="{{ route('products.index') }}" class="hover:text-blue-600 transition {{ request()->routeIs('products.*') ? 'text-blue-600 font-semibold' : '' }}">Katalog Produk</a>
                <a href="{{ route('services.index') }}" class="hover:text-blue-600 transition {{ request()->routeIs('services.*') ? 'text-blue-600 font-semibold' : '' }}">Layanan & Servis</a>
                <a href="{{ route('articles.index') }}" class="hover:text-blue-600 transition {{ request()->routeIs('articles.*') ? 'text-blue-600 font-semibold' : '' }}">Artikel & Tips</a>
                <a href="{{ route('home') }}#kontak" class="hover:text-blue-600 transition">Kontak</a>
            </nav>

            <!-- CTA WA Button & Mobile Menu Toggle -->
            <div class="flex items-center gap-3">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp', '6281390288875')) }}?text={{ urlencode('Halo Pelangi Glass, saya ingin tanya informasi kaca mobil.') }}" target="_blank" class="hidden lg:inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2.5 rounded-full transition shadow-sm">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    Konsultasi Gratis
                </a>

                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-xl text-slate-700 hover:bg-slate-100 transition" aria-label="Menu">
                    <i data-lucide="menu" class="w-6 h-6" x-show="!mobileMenuOpen"></i>
                    <i data-lucide="x" class="w-6 h-6" x-show="mobileMenuOpen" style="display: none;"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden border-t border-slate-200 bg-white px-6 py-5 space-y-3 shadow-xl">
            <a href="{{ route('home') }}" class="block py-2 text-base font-medium text-slate-800 hover:text-blue-600">Beranda</a>
            <a href="{{ route('about') }}" class="block py-2 text-base font-medium text-slate-800 hover:text-blue-600">Tentang Kami</a>
            <a href="{{ route('products.index') }}" class="block py-2 text-base font-medium text-slate-800 hover:text-blue-600">Katalog Produk</a>
            <a href="{{ route('services.index') }}" class="block py-2 text-base font-medium text-slate-800 hover:text-blue-600">Layanan & Servis</a>
            <a href="{{ route('articles.index') }}" class="block py-2 text-base font-medium text-slate-800 hover:text-blue-600">Artikel & Tips</a>
            <a href="{{ route('home') }}#kontak" @click="mobileMenuOpen = false" class="block py-2 text-base font-medium text-slate-800 hover:text-blue-600">Lokasi & Kontak</a>
            <div class="pt-3 border-t border-slate-100">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp', '6281390288875')) }}" target="_blank" class="w-full flex items-center justify-center gap-2 bg-blue-600 text-white font-semibold py-3 rounded-xl">
                    <i data-lucide="message-circle" class="w-4 h-4"></i> Konsultasi WhatsApp
                </a>
            </div>
        </div>
    </header>

    <!-- Main Body Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-300 pt-16 pb-10 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-12 pb-12 border-b border-slate-800/80">
                <!-- Col 1: Brand Info -->
                <div class="lg:col-span-4 space-y-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Pelangi Glass" class="h-12 w-auto bg-white/10 p-1.5 rounded-lg">
                    <p class="text-sm text-slate-400 leading-relaxed text-justify">
                        Bengkel spesialis kaca mobil dan kaca film resmi terpercaya di Purwokerto sejak 1992. Melayani penggantian kaca depan, samping, belakang, reparasi chip retak, dan kaca film bergaransi resmi.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="https://instagram.com" target="_blank" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-blue-600 text-slate-300 hover:text-white flex items-center justify-center transition">
                            <i data-lucide="instagram" class="w-4 h-4"></i>
                        </a>
                        <a href="https://facebook.com" target="_blank" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-blue-600 text-slate-300 hover:text-white flex items-center justify-center transition">
                            <i data-lucide="facebook" class="w-4 h-4"></i>
                        </a>
                        <a href="https://youtube.com" target="_blank" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-blue-600 text-slate-300 hover:text-white flex items-center justify-center transition">
                            <i data-lucide="youtube" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Navigasi Cepat -->
                <div class="lg:col-span-2">
                    <h4 class="text-sm font-bold uppercase tracking-wider text-white mb-4">Navigasi</h4>
                    <ul class="space-y-2.5 text-sm text-slate-400">
                        <li><a href="{{ route('home') }}" class="hover:text-blue-400 transition flex items-center gap-1.5"><span class="text-blue-500">›</span> Beranda</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-blue-400 transition flex items-center gap-1.5"><span class="text-blue-500">›</span> Tentang Kami</a></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-blue-400 transition flex items-center gap-1.5"><span class="text-blue-500">›</span> Katalog Produk</a></li>
                        <li><a href="{{ route('services.index') }}" class="hover:text-blue-400 transition flex items-center gap-1.5"><span class="text-blue-500">›</span> Layanan & Servis</a></li>
                        <li><a href="{{ route('articles.index') }}" class="hover:text-blue-400 transition flex items-center gap-1.5"><span class="text-blue-500">›</span> Artikel Edukasi</a></li>
                        <li><a href="{{ route('home') }}#kontak" class="hover:text-blue-400 transition flex items-center gap-1.5"><span class="text-blue-500">›</span> Kontak & Lokasi</a></li>
                    </ul>
                </div>

                <!-- Col 3: Layanan Unggulan -->
                <div class="lg:col-span-3">
                    <h4 class="text-sm font-bold uppercase tracking-wider text-white mb-4">Layanan Unggulan</h4>
                    <ul class="space-y-2.5 text-sm text-slate-400">
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Penggantian Kaca Depan OEM</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Kaca Film V-KOOL & 3M Original</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Reparasi Kaca Retak & Chip</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Kaca Pintu, Samping & Belakang</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Seal Ulang Kaca Bocor / Rembes</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Poles Kaca & Anti Hujan</li>
                    </ul>
                </div>

                <!-- Col 4: Info Workshop -->
                <div class="lg:col-span-3 space-y-3.5">
                    <h4 class="text-sm font-bold uppercase tracking-wider text-white mb-4">Workshop & Jam Kerja</h4>
                    <div class="flex items-start gap-2.5 text-sm text-slate-400">
                        <i data-lucide="map-pin" class="w-4 h-4 text-blue-400 shrink-0 mt-0.5"></i>
                        <span>{{ \App\Models\Setting::get('address', 'Purwokerto, Banyumas, Jawa Tengah') }}</span>
                    </div>
                    <div class="flex items-start gap-2.5 text-sm text-slate-400">
                        <i data-lucide="clock" class="w-4 h-4 text-amber-400 shrink-0 mt-0.5"></i>
                        <div>
                            <div class="text-slate-200 font-medium">{{ \App\Models\Setting::get('operational_hours', 'Senin – Jumat: 08.30 – 16.30 WIB') }}</div>
                            <div class="text-xs text-slate-400 mt-0.5">{{ \App\Models\Setting::get('operational_hours_weekend', 'Sabtu & Minggu: Tutup (Janji Temu via WA)') }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5 text-sm">
                        <i data-lucide="phone" class="w-4 h-4 text-emerald-400 shrink-0"></i>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp', '6281390288875')) }}" target="_blank" class="text-slate-200 hover:text-emerald-400 transition font-semibold">
                            {{ \App\Models\Setting::get('phone', '+62 813-9028-8875') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>© {{ date('Y') }} Pelangi Glass Purwokerto. Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}#beranda" class="hover:text-slate-300 transition">Kembali ke Atas ↑</a>
                    <a href="/admin" class="hover:text-slate-300 transition">Panel Admin</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp', '6281390288875')) }}?text={{ urlencode('Halo Pelangi Glass Purwokerto, saya ingin konsultasi mengenai kaca mobil.') }}" target="_blank" class="fixed bottom-6 right-6 z-50 flex items-center gap-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm px-4 py-3 rounded-full shadow-lg transition-transform hover:scale-105" aria-label="Chat WhatsApp">
        <i data-lucide="phone" class="w-5 h-5"></i>
        <span class="hidden sm:inline">Hubungi Kami</span>
    </a>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
