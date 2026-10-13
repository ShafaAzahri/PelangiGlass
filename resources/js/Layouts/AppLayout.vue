<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import ThemeToggle from '@/Components/UI/ThemeToggle.vue';
import { useWhatsApp } from '@/Composables/useWhatsApp';

const page = usePage();
const { buildUrl, bookingUrl, displayPhone, cleanNumber } = useWhatsApp();

const mobileMenuOpen = ref(false);

const currentUrl = computed(() => page.url);

const isCurrent = (path) => {
    if (path === '/') {
        return currentUrl.value === '/' || currentUrl.value === '';
    }
    return currentUrl.value.startsWith(path);
};

const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
};
</script>

<template>
    <div class="bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 flex flex-col min-h-screen selection:bg-blue-600 selection:text-white transition-colors duration-200">
        <!-- 1. Top Fixed Navbar -->
        <header class="fixed top-0 w-full z-50 transition-all duration-300 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 shadow-xs">
            <!-- Brand Accent Gradient Line -->
            <div class="w-full h-[2.5px] bg-gradient-to-r from-blue-700 via-blue-500 via-sky-400 via-slate-200 to-red-600"></div>

            <div class="relative z-10 w-full max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 h-[72px] sm:h-[74px] flex items-center justify-between">
                <!-- Left: Logo -->
                <Link href="/" class="no-underline flex items-center shrink-0 py-1" @click="mobileMenuOpen = false">
                    <img src="/images/Logo_PELANGI_GLASS__Baru_.png" alt="Pelangi Glass" class="h-8.5 sm:h-9 md:h-10 xl:h-10.5 w-auto object-contain drop-shadow-xs">
                </Link>

                <!-- Center: Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center justify-center gap-4 xl:gap-6 2xl:gap-7 h-full flex-1 mx-4 xl:mx-8">
                    <Link
                        href="/"
                        prefetch
                        class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 no-underline"
                        :class="isCurrent('/') ? 'text-[#0f2c59] dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400'"
                    >
                        <span>Beranda</span>
                        <span v-if="isCurrent('/')" class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm shadow-[0_-1px_4px_rgba(220,38,38,0.35)]"></span>
                    </Link>

                    <Link
                        href="/tentang"
                        prefetch
                        class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 no-underline"
                        :class="isCurrent('/tentang') ? 'text-[#0f2c59] dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400'"
                    >
                        <span>Tentang Kami</span>
                        <span v-if="isCurrent('/tentang')" class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm shadow-[0_-1px_4px_rgba(220,38,38,0.35)]"></span>
                    </Link>

                    <Link
                        href="/produk"
                        prefetch
                        class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 no-underline"
                        :class="isCurrent('/produk') ? 'text-[#0f2c59] dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400'"
                    >
                        <span>Produk</span>
                        <span v-if="isCurrent('/produk')" class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm shadow-[0_-1px_4px_rgba(220,38,38,0.35)]"></span>
                    </Link>

                    <Link
                        href="/servis"
                        prefetch
                        class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 no-underline"
                        :class="(isCurrent('/servis') || isCurrent('/layanan')) ? 'text-[#0f2c59] dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400'"
                    >
                        <span>Layanan</span>
                        <span v-if="isCurrent('/servis') || isCurrent('/layanan')" class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm shadow-[0_-1px_4px_rgba(220,38,38,0.35)]"></span>
                    </Link>

                    <Link
                        href="/promo"
                        prefetch
                        class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 no-underline"
                        :class="isCurrent('/promo') ? 'text-[#0f2c59] dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400'"
                    >
                        <span>Promo</span>
                        <span v-if="isCurrent('/promo')" class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm shadow-[0_-1px_4px_rgba(220,38,38,0.35)]"></span>
                    </Link>

                    <Link
                        href="/artikel"
                        prefetch
                        class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 no-underline"
                        :class="isCurrent('/artikel') ? 'text-[#0f2c59] dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400'"
                    >
                        <span>Artikel</span>
                        <span v-if="isCurrent('/artikel')" class="absolute bottom-0 left-1.5 right-1.5 xl:left-2 xl:right-2 h-[3.5px] bg-red-600 rounded-t-sm shadow-[0_-1px_4px_rgba(220,38,38,0.35)]"></span>
                    </Link>

                    <a
                        href="/#kontak"
                        class="relative h-full flex items-center text-[13px] xl:text-[14px] 2xl:text-[14.5px] font-medium text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors py-2 whitespace-nowrap px-1.5 xl:px-2 no-underline"
                    >
                        <span>Kontak</span>
                    </a>
                </nav>

                <!-- Right: Actions & Theme Toggle -->
                <div class="hidden lg:flex items-center gap-2.5 xl:gap-3 shrink-0">
                    <ThemeToggle />

                    <a
                        :href="buildUrl('Halo Pelangi Glass, saya ingin konsultasi.')"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="border-2 border-blue-600 text-blue-600 dark:text-blue-400 dark:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-950 font-semibold text-xs xl:text-[13px] px-3.5 py-1.5 xl:px-4.5 xl:py-2 rounded-xl transition-all no-underline shadow-none whitespace-nowrap active:scale-95"
                    >
                        Konsultasi Sekarang
                    </a>

                    <a
                        :href="bookingUrl()"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold text-xs xl:text-[13px] px-3.5 py-1.5 xl:px-4.5 xl:py-2 rounded-xl transition-all no-underline shadow-xs hover:shadow-md flex items-center gap-1.5 whitespace-nowrap active:scale-95"
                    >
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>Booking Service</span>
                    </a>
                </div>

                <!-- Mobile Header Controls -->
                <div class="flex lg:hidden items-center gap-2">
                    <ThemeToggle />
                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        type="button"
                        class="p-2 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer"
                        aria-label="Toggle menu"
                    >
                        <svg v-if="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Drawer Menu -->
            <div
                v-show="mobileMenuOpen"
                class="lg:hidden px-6 pb-6 pt-3 flex flex-col gap-3.5 border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xl max-h-[calc(100vh-80px)] overflow-y-auto"
            >
                <div class="flex flex-col gap-1 py-1">
                    <Link
                        href="/"
                        class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between no-underline"
                        :class="isCurrent('/') ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-600'"
                        @click="mobileMenuOpen = false"
                    >
                        <span>Beranda</span>
                    </Link>
                    <Link
                        href="/tentang"
                        class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between no-underline"
                        :class="isCurrent('/tentang') ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-600'"
                        @click="mobileMenuOpen = false"
                    >
                        <span>Tentang Kami</span>
                    </Link>
                    <Link
                        href="/produk"
                        class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between no-underline"
                        :class="isCurrent('/produk') ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-600'"
                        @click="mobileMenuOpen = false"
                    >
                        <span>Produk</span>
                    </Link>
                    <Link
                        href="/servis"
                        class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between no-underline"
                        :class="(isCurrent('/servis') || isCurrent('/layanan')) ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-600'"
                        @click="mobileMenuOpen = false"
                    >
                        <span>Layanan</span>
                    </Link>
                    <Link
                        href="/promo"
                        class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between no-underline"
                        :class="isCurrent('/promo') ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-600'"
                        @click="mobileMenuOpen = false"
                    >
                        <span>Promo</span>
                    </Link>
                    <Link
                        href="/artikel"
                        class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between no-underline"
                        :class="isCurrent('/artikel') ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-600'"
                        @click="mobileMenuOpen = false"
                    >
                        <span>Artikel</span>
                    </Link>
                    <a
                        href="/#kontak"
                        class="text-sm font-medium py-2 px-3 rounded-lg flex items-center justify-between text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-600 no-underline"
                        @click="mobileMenuOpen = false"
                    >
                        <span>Kontak</span>
                    </a>
                </div>

                <!-- Mobile Action CTA -->
                <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex flex-col gap-2.5">
                    <a
                        :href="buildUrl('Halo Pelangi Glass, saya ingin konsultasi.')"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="w-full py-2.5 px-4 rounded-xl border-2 border-blue-600 text-blue-600 dark:text-blue-400 dark:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-950 text-center text-sm font-semibold transition-all no-underline"
                    >
                        Konsultasi Sekarang
                    </a>
                    <a
                        :href="bookingUrl()"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="w-full py-2.5 px-4 rounded-xl bg-red-600 hover:bg-red-700 text-white text-center text-sm font-semibold transition-all shadow-xs flex items-center justify-center gap-2 no-underline active:scale-95"
                    >
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>Booking Service</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Flash notification (if any) -->
        <div v-if="page.props.flash?.success" class="fixed top-20 right-4 z-50 max-w-md bg-emerald-600 text-white px-5 py-3.5 rounded-xl shadow-xl flex items-center gap-3 animate-fade-up">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <span class="text-sm font-medium">{{ page.props.flash.success }}</span>
        </div>

        <div v-if="page.props.flash?.error" class="fixed top-20 right-4 z-50 max-w-md bg-red-600 text-white px-5 py-3.5 rounded-xl shadow-xl flex items-center gap-3 animate-fade-up">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>
            <span class="text-sm font-medium">{{ page.props.flash.error }}</span>
        </div>

        <!-- 2. Main Slot Content (with top padding for fixed navbar) -->
        <main class="flex-1 pt-[72px] sm:pt-[74px]">
            <slot />
        </main>

        <!-- 3. Global Footer -->
        <footer class="pt-16 pb-10 text-slate-300 border-t border-slate-800" style="background: #0b1324;">
            <div class="w-full max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 xl:gap-12 pb-12 border-b border-slate-800">
                    <!-- Col 1: Brand & Identity -->
                    <div class="lg:col-span-4 flex flex-col gap-4">
                        <Link href="/" class="inline-block no-underline">
                            <img src="/images/Logo_PELANGI_GLASS__Baru_.png" alt="Pelangi Glass" class="h-10 sm:h-12 w-auto brightness-110">
                        </Link>
                        <p class="text-xs sm:text-sm text-slate-400 leading-relaxed font-normal">
                            Pusat spesialis instalasi kaca mobil dan kaca film berkualitas OEM di Purwokerto sejak 1992. Menghadirkan presisi, ketahanan, dan standar keselamatan berkendara terbaik.
                        </p>
                    </div>

                    <!-- Col 2: Navigasi Cepat -->
                    <div class="lg:col-span-2">
                        <h4 class="text-sm font-semibold uppercase tracking-wider text-white mb-4">
                            Navigasi Cepat
                        </h4>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-slate-400 list-none p-0 m-0">
                            <li>
                                <Link href="/" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                    <span class="text-blue-500 font-bold">›</span> Beranda
                                </Link>
                            </li>
                            <li>
                                <Link href="/tentang" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                    <span class="text-blue-500 font-bold">›</span> Tentang Pelangi Glass
                                </Link>
                            </li>
                            <li>
                                <Link href="/produk" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                    <span class="text-blue-500 font-bold">›</span> Katalog Produk & Kaca
                                </Link>
                            </li>
                            <li>
                                <Link href="/servis" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                    <span class="text-blue-500 font-bold">›</span> Layanan & Servis
                                </Link>
                            </li>
                            <li>
                                <Link href="/promo" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                    <span class="text-blue-500 font-bold">›</span> Promo & Penawaran
                                </Link>
                            </li>
                            <li>
                                <Link href="/artikel" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                    <span class="text-blue-500 font-bold">›</span> Artikel & Tips
                                </Link>
                            </li>
                            <li>
                                <a href="/#kontak" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1.5 no-underline">
                                    <span class="text-blue-500 font-bold">›</span> Lokasi & Kontak
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Col 3: Layanan Unggulan -->
                    <div class="lg:col-span-3">
                        <h4 class="text-sm font-semibold uppercase tracking-wider text-white mb-4">
                            Layanan Unggulan
                        </h4>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-slate-400 list-none p-0 m-0">
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

                    <!-- Col 4: Info Workshop & Kontak -->
                    <div class="lg:col-span-3 flex flex-col gap-4">
                        <h4 class="text-sm font-semibold uppercase tracking-wider text-white mb-1">
                            Workshop & Jam Kerja
                        </h4>
                        <div class="flex flex-col gap-3.5 text-xs sm:text-sm text-slate-400">
                            <div class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                                </svg>
                                <span>{{ page.props.contact?.address || 'Purwokerto, Jawa Tengah' }}</span>
                            </div>

                            <div class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                                </svg>
                                <div>
                                    <div class="text-slate-200 font-medium">{{ page.props.contact?.operational_hours || 'Senin – Jumat: 08.30 – 16.30 WIB' }}</div>
                                    <div class="text-slate-400 text-xs mt-0.5">{{ page.props.contact?.operational_hours_weekend || 'Sabtu & Minggu: Tutup (Janji Temu via WA)' }}</div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                                </svg>
                                <a :href="`https://wa.me/${cleanNumber}`" target="_blank" rel="noopener noreferrer" class="text-slate-200 hover:text-emerald-400 transition-colors font-medium no-underline">
                                    {{ displayPhone }}
                                </a>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="pt-2">
                            <div class="text-xs text-slate-400 mb-2.5">Ikuti Kami:</div>
                            <div class="flex items-center gap-2.5">
                                <a :href="page.props.contact?.facebook || 'https://facebook.com'" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all bg-slate-800/80 hover:bg-blue-600 text-slate-300 hover:text-white">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                                </a>
                                <a :href="page.props.contact?.instagram || 'https://www.instagram.com/pelangiglassofficial'" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all bg-slate-800/80 hover:bg-blue-600 text-slate-300 hover:text-white">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                                </a>
                                <a :href="page.props.contact?.youtube || 'https://youtube.com'" target="_blank" rel="noopener noreferrer" aria-label="YouTube" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all bg-slate-800/80 hover:bg-blue-600 text-slate-300 hover:text-white">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
                    <div>
                        <span>© {{ new Date().getFullYear() }} {{ page.props.app?.name || 'Pelangi Glass Purwokerto' }}. Hak Cipta Dilindungi.</span>
                    </div>
                    <div>
                        <button
                            @click="scrollToTop"
                            type="button"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-slate-800/80 hover:bg-slate-700 text-slate-300 hover:text-white text-xs transition-colors cursor-pointer border border-slate-700/60 shadow-xs"
                        >
                            <span>Kembali ke Atas</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m18 15-6-6-6 6"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </footer>

        <!-- 4. Floating WhatsApp Action Button (Matching Image #1) -->
        <a
            :href="buildUrl('Halo Pelangi Glass, saya ingin konsultasi dan menanyakan informasi lebih lanjut.')"
            target="_blank"
            rel="noopener noreferrer"
            class="fixed bottom-6 right-6 z-40 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 active:scale-95 flex items-center gap-2.5 no-underline font-semibold text-sm select-none"
            aria-label="Hubungi Kami via WhatsApp"
        >
            <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.196 8.196 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24m4.52 11.66c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.02-1.25-.75-.67-1.26-1.5-1.4-1.75-.15-.25-.02-.39.11-.51.11-.11.25-.29.37-.44.13-.15.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.12-.56-1.34-.76-1.84-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.87.85-.87 2.08 0 1.22.89 2.41 1.87 3.56 1.83 2.14 4.55 3.16 7.02 2.72 1.2-.21 2.17-1.07 2.51-2.22l.06-.26-.82-1.14z"/>
            </svg>
            <span>Hubungi Kami</span>
        </a>
    </div>
</template>
