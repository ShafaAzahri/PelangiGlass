<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import ServiceCard from '@/Components/Cards/ServiceCard.vue';
import { useWhatsApp } from '@/Composables/useWhatsApp';

const props = defineProps({
    services: {
        type: [Object, Array],
        required: true,
    },
    categories: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

const { buildUrl } = useWhatsApp();

const defaultServices = [
    {
        id: 1,
        slug: 'penggantian-kaca-depan-oem',
        name: 'Paket Ganti Kaca Depan',
        category: 'Ganti Kaca',
        desc: 'Penggantian kaca depan retak/pecah dengan kaca original OEM presisi dan standar lem sealant anti-bocor.',
        img: 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=400&h=300&fit=crop&auto=format',
        badge: 'Terlaris',
    },
    {
        id: 2,
        slug: 'ganti-kaca-samping-belakang',
        name: 'Ganti Kaca Samping & Belakang',
        category: 'Ganti Kaca',
        desc: 'Penggantian kaca pintu samping, ventilasi segitiga, dan kaca bagasi belakang untuk semua merek mobil.',
        img: 'https://images.unsplash.com/photo-1699897483215-a66a9ca292b3?w=400&h=300&fit=crop&auto=format',
        badge: 'Bergaransi',
    },
    {
        id: 3,
        slug: 'pemasangan-kaca-film-v-kool',
        name: 'Pasang Kaca Film V-KOOL',
        category: 'Kaca Film',
        desc: 'Pemasangan kaca film tolak panas premium V-KOOL berteknologi multi-layer dengan garansi resmi 5 tahun.',
        img: 'https://images.unsplash.com/photo-1526459915562-c5ca724b1d02?w=400&h=300&fit=crop&auto=format',
        badge: 'Premium',
    },
    {
        id: 4,
        slug: 'pasang-kaca-film-3m-solar-gard',
        name: 'Pasang Kaca Film 3M & Solar Gard',
        category: 'Kaca Film',
        desc: 'Kaca film penolak UV dan panas tinggi dengan beragam pilihan kegelapan (40%, 60%, 80%) original bergaransi.',
        img: 'https://images.unsplash.com/photo-1708805282706-f44730b7e527?w=400&h=300&fit=crop&auto=format',
        badge: null,
    },
    {
        id: 5,
        slug: 'perbaikan-kaca-retak-chip',
        name: 'Reparasi Kaca Retak & Chip',
        category: 'Perbaikan Kaca',
        desc: 'Perbaikan keretakan titik (chip) dan baret dengan teknologi injeksi resin khusus tanpa harus ganti kaca baru.',
        img: 'https://images.unsplash.com/photo-1608259243654-70c070e0f6ed?w=400&h=300&fit=crop&auto=format',
        badge: 'Hemat',
    },
    {
        id: 6,
        slug: 'kalibrasi-kaca-bocor',
        name: 'Kalibrasi & Perbaikan Kaca Bocor',
        category: 'Perbaikan Kaca',
        desc: 'Pembersihan sealant lama dan pemasangan ulang kaca berstandar pabrik untuk mengatasi rembesan air saat hujan.',
        img: 'https://images.unsplash.com/photo-1651084296894-105edab05b26?w=400&h=300&fit=crop&auto=format',
        badge: 'Bergaransi',
    },
    {
        id: 7,
        slug: 'penggantian-karet-seal-kaca',
        name: 'Ganti Karet Seal & Pelipit Kaca',
        category: 'Aksesoris & Perawatan',
        desc: 'Penggantian karet channel kaca mati, pelipit pintu, dan weatherstrip agar kabin kembali senyap dan kedap.',
        img: 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=400&h=300&fit=crop&auto=format',
        badge: null,
    },
    {
        id: 8,
        slug: 'poles-kaca-dan-rain-repellent',
        name: 'Poles Kaca & Rain Repellent',
        category: 'Aksesoris & Perawatan',
        desc: 'Pembersihan jamur kaca membandel disertai lapisan hidrofobik efek daun talas untuk visibilitas maksimal saat hujan.',
        img: 'https://images.unsplash.com/photo-1764428950296-be81c8decb97?w=400&h=300&fit=crop&auto=format',
        badge: 'Baru',
    },
];

const allServices = computed(() => {
    const list = props.services?.data || (Array.isArray(props.services) ? props.services : []);
    if (list.length > 0) {
        return list.map((s) => ({
            id: s.id,
            slug: s.slug,
            name: s.name,
            category: s.category?.name || s.category || 'Ganti Kaca',
            desc: s.short_description || s.description || s.desc || '',
            img: s.image_url || s.img || s.image_path || 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=400&h=300&fit=crop&auto=format',
            badge: s.badge?.value || s.badge || (s.warranty_period ? 'Bergaransi' : null),
        }));
    }
    return defaultServices;
});

const defaultCategories = ['Semua', 'Ganti Kaca', 'Kaca Film', 'Perbaikan Kaca', 'Aksesoris & Perawatan'];

const categoryList = computed(() => {
    if (props.categories && props.categories.length > 0) {
        return ['Semua', ...props.categories.map((c) => c.name)];
    }
    return defaultCategories;
});

const activeCategory = ref('Semua');
const searchQuery = ref('');

// Incremental Lazy Loading
const limit = ref(8);
const pageSize = 8;

const filteredServices = computed(() => {
    return allServices.value.filter((s) => {
        const matchCat = activeCategory.value === 'Semua' || s.category === activeCategory.value;
        const q = searchQuery.value.toLowerCase().trim();
        const matchSearch = !q ||
            s.name.toLowerCase().includes(q) ||
            s.category.toLowerCase().includes(q) ||
            s.desc.toLowerCase().includes(q);
        return matchCat && matchSearch;
    });
});

const visibleServices = computed(() => {
    return filteredServices.value.slice(0, limit.value);
});

const hasMore = computed(() => {
    return visibleServices.value.length < filteredServices.value.length;
});

const loadMore = () => {
    if (hasMore.value) {
        limit.value += pageSize;
    }
};

const filterCategory = (cat) => {
    activeCategory.value = cat;
    limit.value = pageSize;
};

// Intersection Observer for auto infinite scroll / lazy loading
const sentinelRef = ref(null);
let observer = null;

onMounted(() => {
    if ('IntersectionObserver' in window) {
        observer = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting && hasMore.value) {
                loadMore();
            }
        }, { rootMargin: '250px' });

        if (sentinelRef.value) {
            observer.observe(sentinelRef.value);
        }
    }
});

onUnmounted(() => {
    if (observer) {
        observer.disconnect();
    }
});
</script>

<template>
    <AppLayout>
        <Head title="Layanan & Servis Kaca Mobil Resmi Purwokerto">
            <meta name="description" content="Paket lengkap servis penggantian kaca mobil depan OEM, kaca film premium tolak panas, perbaikan kaca retak bergaransi di Purwokerto." />
        </Head>

        <div class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors">
            <div class="max-w-6xl mx-auto px-6 py-12">
                <!-- Search + Filter Bar (matching Image #2 exactly) -->
                <div class="flex flex-col sm:flex-row gap-4 mb-10 items-center justify-between">
                    <div class="relative flex-1 max-w-xs w-full">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                        <input
                            type="text"
                            placeholder="Cari servis / layanan..."
                            v-model="searchQuery"
                            @input="limit = pageSize"
                            class="w-full pl-9 pr-4 py-2.5 rounded-xl text-sm outline-none transition-all bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-blue-600 dark:focus:border-blue-500"
                        >
                    </div>

                    <div class="flex gap-2 flex-wrap items-center">
                        <button
                            v-for="c in categoryList"
                            :key="c"
                            @click="filterCategory(c)"
                            type="button"
                            class="px-4 py-2 rounded-full text-xs font-medium transition-all cursor-pointer border select-none"
                            :class="activeCategory === c
                                ? 'bg-blue-600 text-white border-blue-600 shadow-xs'
                                : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700'"
                        >
                            {{ c }}
                        </button>
                    </div>
                </div>

                <!-- Services 4-Column Grid (matching Image #2) -->
                <div v-if="filteredServices.length === 0" class="text-center py-20 text-slate-400">
                    Layanan tidak ditemukan.
                </div>

                <div v-else class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 items-stretch">
                    <ServiceCard
                        v-for="service in visibleServices"
                        :key="service.id"
                        :service="service"
                    />
                </div>

                <!-- Lazy Loading Trigger & Sentinel -->
                <div ref="sentinelRef" v-show="hasMore" class="py-8 text-center">
                    <button
                        @click="loadMore()"
                        type="button"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-semibold shadow-xs transition active:scale-95 cursor-pointer"
                    >
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14m7-7-7 7-7-7"/>
                        </svg>
                        <span>Tampilkan Lebih Banyak Layanan</span>
                    </button>
                </div>

                <!-- Bottom CTA Card (matching Image #2 exactly) -->
                <div class="mt-14 p-6 sm:p-8 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left shadow-xs">
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 font-medium m-0">
                        Butuh layanan khusus atau konsultasi kondisi kaca mobil Anda? Hubungi teknisi kami sekarang.
                    </p>
                    <a
                        :href="buildUrl('Halo Pelangi Glass, saya ingin konsultasi mengenai layanan khusus kaca mobil.')"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="shrink-0 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold no-underline shadow-xs transition active:scale-95"
                    >
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
