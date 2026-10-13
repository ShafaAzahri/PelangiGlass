<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import ProductCard from '@/Components/Cards/ProductCard.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
import { useWhatsApp } from '@/Composables/useWhatsApp';

const props = defineProps({
    products: {
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

const allProducts = computed(() => {
    const list = props.products?.data || (Array.isArray(props.products) ? props.products : []);
    if (list.length > 0) {
        return list.map((p) => ({
            id: p.id,
            slug: p.slug,
            name: p.name,
            category: p.category?.name || p.category || 'Kaca Mobil',
            desc: p.short_description || p.desc || '',
            img: p.image_url || p.img || p.main_image || '/images/banner1.png',
            badge: p.badge?.value || p.badge || null,
        }));
    }
    return [];
});

const categoryList = computed(() => {
    if (props.categories && props.categories.length > 0) {
        return ['Semua', ...props.categories.map((c) => c.name || c)];
    }
    return ['Semua'];
});

const activeCategory = ref('Semua');
const searchQuery = ref('');

// Incremental Lazy Loading
const limit = ref(8);
const pageSize = 8;

const filteredProducts = computed(() => {
    return allProducts.value.filter((p) => {
        const matchCat = activeCategory.value === 'Semua' || p.category === activeCategory.value;
        const q = searchQuery.value.toLowerCase().trim();
        const matchSearch = !q ||
            p.name.toLowerCase().includes(q) ||
            p.category.toLowerCase().includes(q) ||
            p.desc.toLowerCase().includes(q);
        return matchCat && matchSearch;
    });
});

const visibleProducts = computed(() => {
    return filteredProducts.value.slice(0, limit.value);
});

const hasMore = computed(() => {
    return visibleProducts.value.length < filteredProducts.value.length;
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
        <Head title="Katalog Produk & Kaca Mobil Resmi Purwokerto">
            <meta name="description" content="Katalog lengkap kaca depan, kaca samping, kaca belakang, dan kaca film kualitas OEM resmi di Pelangi Glass Purwokerto." />
        </Head>

        <div class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors">
            <div class="max-w-6xl mx-auto px-6 py-12">
                <!-- Search + Filter Bar (matching Image #1 exactly) -->
                <div class="flex flex-col sm:flex-row gap-4 mb-10 items-center justify-between">
                    <div class="relative flex-1 max-w-xs w-full">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                        <input
                            type="text"
                            placeholder="Cari nama atau tipe mobil..."
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
                                : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700'"
                        >
                            {{ c }}
                        </button>
                    </div>
                </div>

                <!-- Products 4-Column Grid -->
                <!-- Empty State -->
                <EmptyState
                    v-if="filteredProducts.length === 0"
                    title="Belum Ada Produk Ditampilkan"
                    message="Saat ini belum ada produk aktif di katalog atau produk yang cocok dengan pencarian Anda. Silakan hubungi kami untuk informasi ketersediaan stok."
                    action-label="Tanya Stok via WhatsApp"
                    :action-href="buildUrl('Halo Pelangi Glass, saya ingin tanya ketersediaan stok produk kaca mobil.')"
                />

                <div v-else class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 items-stretch">
                    <ProductCard
                        v-for="product in visibleProducts"
                        :key="product.id"
                        :product="product"
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
                        <span>Tampilkan Lebih Banyak Produk</span>
                    </button>
                </div>

                <!-- Bottom CTA Card (matching Image #1 exactly) -->
                <div class="mt-14 p-6 sm:p-8 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left shadow-xs">
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 font-medium m-0">
                        Produk tidak ada di daftar? Hubungi kami, kami bisa bantu carikan.
                    </p>
                    <a
                        :href="buildUrl('Halo Pelangi Glass, produk yang saya cari tidak ada di daftar. Mohon informasinya.')"
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
