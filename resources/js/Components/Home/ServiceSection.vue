<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import Badge from '@/Components/UI/Badge.vue';

const props = defineProps({
    featuredServices: {
        type: Array,
        default: () => [],
    },
});

const defaultServices = [
    {
        title: 'Penggantian Kaca',
        desc: 'Kaca depan, belakang, dan samping. Produk original bergaransi resmi.',
        img: 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=600&h=400&fit=crop&auto=format',
        badge: 'Terlaris',
        slug: 'penggantian-kaca-depan-oem',
    },
    {
        title: 'Film Kaca Premium',
        desc: 'Reduksi panas & UV hingga 99%. Pilihan brand V-Kool, 3M, Solar Gard.',
        img: 'https://images.unsplash.com/photo-1526459915562-c5ca724b1d02?w=600&h=400&fit=crop&auto=format',
        badge: 'Bergaransi',
        slug: 'pemasangan-kaca-film-v-kool',
    },
    {
        title: 'Perbaikan Retak',
        desc: 'Perbaikan kaca baret ringan sebelum menjadi kerusakan permanen.',
        img: 'https://images.unsplash.com/photo-1608259243654-70c070e0f6ed?w=600&h=400&fit=crop&auto=format',
        badge: 'Hemat',
        slug: 'perbaikan-kaca-retak-chip',
    },
    {
        title: 'Aksesoris Kaca',
        desc: 'Wiper, karet seal, spion, dan perlengkapan kaca lainnya.',
        img: 'https://images.unsplash.com/photo-1651084296894-105edab05b26?w=600&h=400&fit=crop&auto=format',
        badge: null,
        slug: 'penggantian-karet-seal-kaca',
    },
    {
        title: 'Rain Repellent',
        desc: 'Cairan anti-hujan untuk visibilitas optimal saat berkendara.',
        img: 'https://images.unsplash.com/photo-1764428950296-be81c8decb97?w=600&h=400&fit=crop&auto=format',
        badge: 'Premium',
        slug: 'poles-kaca-dan-rain-repellent',
    },
    {
        title: 'Konsultasi Gratis',
        desc: 'Cek kondisi kaca mobil Anda tanpa biaya, tanpa komitmen.',
        img: 'https://images.unsplash.com/photo-1708805282695-ef186db20192?w=600&h=400&fit=crop&auto=format',
        badge: 'Baru',
        slug: 'kalibrasi-kaca-bocor',
    },
];

const servicesToShow = computed(() => {
    if (props.featuredServices && props.featuredServices.length > 0) {
        return props.featuredServices.map((s) => ({
            title: s.name,
            desc: s.short_description || (s.description ? s.description.substring(0, 95) + '...' : ''),
            img: s.image_url || s.image_path || 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=600&h=400&fit=crop&auto=format',
            badge: s.badge?.value || s.badge || (s.warranty_period ? 'Bergaransi' : null),
            slug: s.slug,
        }));
    }
    return defaultServices;
});
</script>

<template>
    <section id="layanan" class="py-24 bg-slate-50 dark:bg-slate-950 transition-colors">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex items-end justify-between mb-14 flex-wrap gap-4">
                <div>
                    <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3 text-blue-600 dark:text-blue-400">
                        LAYANAN
                    </div>
                    <h2 class="uppercase text-slate-900 dark:text-slate-100 text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight tracking-tight">
                        SEMUA KEBUTUHAN<br />KACA MOBIL ANDA
                    </h2>
                </div>
                <Link href="/servis" class="inline-flex items-center gap-2 text-sm font-medium transition-all text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 no-underline">
                    <span>Lihat Semua Paket Servis</span>
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                    </svg>
                </Link>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <Link
                    v-for="(s, idx) in servicesToShow"
                    :key="idx"
                    :href="s.slug ? `/servis/${s.slug}` : '/servis'"
                    class="rounded-2xl overflow-hidden group transition-all duration-300 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs hover:border-blue-300 dark:hover:border-blue-700 hover:-translate-y-1 flex flex-col no-underline relative"
                >
                    <div class="overflow-hidden w-full relative h-[180px] bg-slate-100 dark:bg-slate-800">
                        <img
                            :src="s.img"
                            :alt="s.title"
                            loading="lazy"
                            decoding="async"
                            @error="$event.target.src = 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=600&h=400&fit=crop&auto=format'"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        >
                        <!-- Top-Left Corner Badge with Icon (matching Image #1) -->
                        <Badge v-if="s.badge" :type="s.badge" variant="corner" />
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold uppercase mb-2 text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition text-lg tracking-wide">
                            {{ s.title }}
                        </h3>
                        <p class="text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                            {{ s.desc }}
                        </p>
                    </div>
                </Link>
            </div>
        </div>
    </section>
</template>
