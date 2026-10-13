<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PromoCard from '@/Components/Cards/PromoCard.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
import { useWhatsApp } from '@/Composables/useWhatsApp';

const { buildUrl } = useWhatsApp();

const props = defineProps({
    promos: {
        type: Array,
        default: () => [],
    },
    categories: {
        type: Array,
        default: () => ['Semua', 'Kaca Film', 'Ganti Kaca', 'Perbaikan Kaca', 'Aksesoris & Perawatan'],
    },
});

const allPromos = computed(() => {
    return Array.isArray(props.promos) ? props.promos : [];
});

const defaultCategories = ['Semua', 'Kaca Film', 'Ganti Kaca', 'Perbaikan Kaca', 'Aksesoris & Perawatan'];

const categoryList = computed(() => {
    if (props.categories && props.categories.length > 0) {
        return props.categories;
    }
    return defaultCategories;
});

const activeCategory = ref('Semua');
const searchQuery = ref('');

// Incremental Lazy Loading
const limit = ref(8);
const pageSize = 8;

const filteredPromos = computed(() => {
    return allPromos.value.filter((p) => {
        const matchCat = activeCategory.value === 'Semua' || p.category === activeCategory.value;
        const q = searchQuery.value.toLowerCase().trim();
        const matchSearch = !q ||
            (p.name && p.name.toLowerCase().includes(q)) ||
            (p.title && p.title.toLowerCase().includes(q)) ||
            (p.code && p.code.toLowerCase().includes(q)) ||
            (p.desc && p.desc.toLowerCase().includes(q));
        return matchCat && matchSearch;
    });
});

const visiblePromos = computed(() => {
    return filteredPromos.value.slice(0, limit.value);
});

const hasMore = computed(() => {
    return visiblePromos.value.length < filteredPromos.value.length;
});

const loadMore = () => {
    if (hasMore.value) {
        limit.value += pageSize;
    }
};

const filterCategory = (c) => {
    activeCategory.value = c;
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
        <Head title="Promo & Diskon Spesial - Pelangi Glass Purwokerto">
            <meta name="description" content="Kumpulan penawaran promo diskon ganti kaca mobil, diskon pemasangan kaca film V-Kool & 3M resmi di Pelangi Glass Purwokerto." />
        </Head>

        <div class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors">
            <div class="max-w-6xl mx-auto px-6 py-12">
                <!-- Search + Filter Bar (matching Image #3 exactly) -->
                <div class="flex flex-col sm:flex-row gap-4 mb-10 items-center justify-between">
                    <div class="relative flex-1 max-w-xs w-full">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                        <input
                            type="text"
                            placeholder="Cari promo atau kode voucher..."
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

                <!-- Promos 4-Column Grid (matching Image #3) -->
                <!-- Empty State -->
                <EmptyState
                    v-if="filteredPromos.length === 0"
                    title="Belum Ada Promo Aktif"
                    message="Saat ini belum ada penawaran promo khusus di katalog. Silakan hubungi kami via WhatsApp untuk konsultasi harga terbaik atau penawaran spesial langsung dari teknisi kami."
                    action-label="Konsultasi Penawaran via WhatsApp"
                    :action-href="buildUrl('Halo Pelangi Glass, saya ingin menanyakan penawaran spesial atau promo yang sedang berlangsung.')"
                />

                <div v-else class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 items-stretch">
                    <PromoCard
                        v-for="promo in visiblePromos"
                        :key="promo.id || promo.slug"
                        :promo="promo"
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
                        <span>Tampilkan Lebih Banyak Promo</span>
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
