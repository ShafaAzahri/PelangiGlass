<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();

const yearsExperience = computed(() => {
    return page.props.settings?.years_experience || '30+';
});
const tagline = computed(() => {
    return page.props.settings?.tagline || 'Pemasangan Presisi Kaca Mobil Original OEM & Kaca Film Bergaransi Resmi';
});

const defaultFacilities = [
    { name: 'Free Coffee & Teh', icon: 'coffee', is_active: true },
    { name: 'Free Charging', icon: 'charging', is_active: true },
    { name: 'Air Panas & Dingin', icon: 'water', is_active: true },
    { name: 'TV LED Hiburan', icon: 'tv', is_active: true },
    { name: 'Kipas Angin', icon: 'fan', is_active: true },
];

const facilitiesTitle = computed(() => {
    return page.props.settings?.waiting_room_facilities_title || 'Fasilitas Ruang Tunggu Pelanggan';
});

const facilities = computed(() => {
    const raw = page.props.settings?.waiting_room_facilities;
    if (!raw) return defaultFacilities;
    try {
        const parsed = typeof raw === 'string' ? JSON.parse(raw) : raw;
        if (Array.isArray(parsed) && parsed.length > 0) {
            return parsed.filter((item) => item.is_active !== false);
        }
    } catch (e) {}
    return defaultFacilities;
});
</script>

<template>
    <section id="tentang" class="py-16 lg:py-20 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
                <!-- Kolom Kiri: Visual Workshop Kaca Mobil -->
                <div class="lg:col-span-6 flex">
                    <div class="w-full h-full min-h-[380px] sm:min-h-[440px] lg:min-h-[490px] rounded-2xl overflow-hidden shadow-lg border border-slate-200/80 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 flex">
                        <img
                            src="/images/workshop-illustration.jpg"
                            alt="Workshop Spesialis Kaca Mobil Pelangi Glass"
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full min-h-[380px] sm:min-h-[440px] lg:min-h-[490px] object-cover object-center block transition-transform duration-700 hover:scale-[1.02]"
                        >
                    </div>
                </div>

                <!-- Kolom Kanan: Profil, Nilai Kepercayaan & Fasilitas -->
                <div class="lg:col-span-6">
                    <div class="flex flex-wrap items-center gap-2 mb-2.5">
                        <span class="text-xs font-bold tracking-wider text-blue-600 dark:text-blue-400 uppercase">
                            Spesialis Kaca Mobil Sejak 1992 • Purwokerto
                        </span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-slate-100 tracking-tight leading-tight mb-3">
                        Selamat Datang di<br class="hidden sm:inline" /> Pelangi Glass Purwokerto
                    </h2>

                    <p class="text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3.5">
                        {{ tagline }}
                    </p>

                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-5 text-justify">
                        Selama lebih dari {{ yearsExperience }} tahun, Pelangi Glass dipercaya melayani penggantian, pemasangan, dan perbaikan kaca untuk berbagai tipe dan merek mobil. Dikerjakan langsung oleh teknisi spesialis dengan standar lem sealant internasional anti-bocor serta estimasi biaya yang transparan.
                    </p>

                    <!-- 3 Key Stats Row -->
                    <div class="grid grid-cols-3 gap-3 py-3.5 mb-5 border-y border-slate-100 dark:border-slate-800">
                        <div>
                            <div class="text-xl sm:text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ yearsExperience }}</div>
                            <div class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">Tahun Pengalaman</div>
                        </div>
                        <div>
                            <div class="text-xl sm:text-2xl font-black text-blue-600 dark:text-blue-400 tracking-tight">100%</div>
                            <div class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">Kaca Asli OEM</div>
                        </div>
                        <div>
                            <div class="text-xl sm:text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">Semua</div>
                            <div class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">Merek & Tipe Mobil</div>
                        </div>
                    </div>

                    <!-- Fasilitas Ruang Tunggu Pelanggan -->
                    <div class="mb-5">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-2.5">
                            {{ facilitiesTitle }}
                        </span>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            <div
                                v-for="(item, idx) in facilities"
                                :key="idx"
                                class="flex items-center gap-2 py-2 px-2.5 rounded-lg bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700 text-slate-700 dark:text-slate-200 text-xs font-medium"
                            >
                                <!-- Coffee / Tea -->
                                <svg v-if="item.icon === 'coffee'" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8h1a4 4 0 1 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/><line x1="6" x2="6" y1="2" y2="4"/><line x1="10" x2="10" y1="2" y2="4"/><line x1="14" x2="14" y1="2" y2="4"/></svg>

                                <!-- Charging -->
                                <svg v-else-if="item.icon === 'charging'" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/></svg>

                                <!-- Water -->
                                <svg v-else-if="item.icon === 'water'" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15.2 22H8.8a2 2 0 0 1-2-1.79L5 3h14l-1.8 17.21A2 2 0 0 1 15.2 22Z"/></svg>

                                <!-- TV -->
                                <svg v-else-if="item.icon === 'tv'" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="20" height="15" x="2" y="7" rx="2" ry="2"/><polyline points="17 2 12 7 7 2"/></svg>

                                <!-- Fan -->
                                <svg v-else-if="item.icon === 'fan'" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.827 16.379a6.082 6.082 0 0 1-8.618-7.002l5.412 1.45a6.082 6.082 0 0 1 7.002-8.618l-1.45 5.412a6.082 6.082 0 0 1 8.618 7.002l-5.412-1.45a6.082 6.082 0 0 1-7.002 8.618l1.45-5.412Z"/><path d="M12 12v.01"/></svg>

                                <!-- Wi-Fi -->
                                <svg v-else-if="item.icon === 'wifi'" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h.01"/><path d="M2 8.82a15 15 0 0 1 20 0"/><path d="M5 12.859a10 10 0 0 1 14 0"/><path d="M8.5 16.429a5 5 0 0 1 7 0"/></svg>

                                <!-- AC -->
                                <svg v-else-if="item.icon === 'ac'" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 16a3 3 0 0 1-3-3 3 3 0 0 1 3-3h12a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H8Z"/><path d="M6 10V6"/><path d="M10 10V6"/><path d="M14 10V6"/></svg>

                                <!-- Sofa -->
                                <svg v-else-if="item.icon === 'sofa'" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 9V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v3"/><path d="M2 11v5a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a2 2 0 0 0-4 0v2H6v-2a2 2 0 0 0-4 0Z"/><path d="M4 18v2"/><path d="M20 18v2"/></svg>

                                <!-- Toilet -->
                                <svg v-else-if="item.icon === 'toilet'" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 12h10"/><path d="M12 7v10"/><circle cx="12" cy="12" r="9"/></svg>

                                <!-- Parking -->
                                <svg v-else-if="item.icon === 'parking'" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 17V7h4a3 3 0 0 1 0 6H9"/></svg>

                                <!-- Default Check -->
                                <svg v-else class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>

                                <span class="truncate text-[11px] sm:text-xs">{{ item.name }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Link ke Halaman Tentang -->
                    <div>
                        <Link href="/tentang" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors uppercase tracking-wider no-underline">
                            <span>Pelajari Profil Lengkap</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
