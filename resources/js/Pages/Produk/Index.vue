<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import ProductCard from '@/Components/Cards/ProductCard.vue';
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

const defaultProducts = [
    {
        id: 1,
        slug: 'kaca-film-v-kool-vk-40',
        name: 'Kaca Film V-KOOL VK 40',
        category: 'Kaca Film',
        desc: 'Film premium anti UV & panas. Garansi 5 tahun. Transmisi cahaya 40%.',
        img: 'https://images.unsplash.com/photo-1526459915562-c5ca724b1d02?w=400&h=300&fit=crop&auto=format',
        badge: 'Terlaris',
    },
    {
        id: 2,
        slug: 'kaca-film-3m-crystalline',
        name: 'Kaca Film 3M Crystalline',
        category: 'Kaca Film',
        desc: 'Teknologi multi-layer nano. Blokir 97% panas inframerah. Original 3M.',
        img: 'https://images.unsplash.com/photo-1708805282706-f44730b7e527?w=400&h=300&fit=crop&auto=format',
        badge: 'Premium',
    },
    {
        id: 3,
        slug: 'kaca-depan-avanza-gen-3',
        name: 'Kaca Depan Avanza Gen 3',
        category: 'Kaca Mobil',
        desc: 'Kaca depan original OEM presisi. Cocok untuk Toyota Avanza 201...',
        img: 'https://images.unsplash.com/photo-1699897483215-a66a9ca292b3?w=400&h=300&fit=crop&auto=format',
        badge: null,
    },
    {
        id: 4,
        slug: 'kaca-depan-xpander',
        name: 'Kaca Depan Xpander',
        category: 'Kaca Mobil',
        desc: 'Kaca depan original OEM Mitsubishi Xpander 2018–2024.',
        img: 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=400&h=300&fit=crop&auto=format',
        badge: null,
    },
    {
        id: 5,
        slug: 'rain-repellent-soft99',
        name: 'Rain Repellent Soft99',
        category: 'Perawatan',
        desc: 'Cairan anti hujan Jepang. Tahan hingga 3 bulan. Efek daun talas instan.',
        img: 'https://images.unsplash.com/photo-1764428950296-be81c8decb97?w=400&h=300&fit=crop&auto=format',
        badge: 'Baru',
    },
    {
        id: 6,
        slug: 'wiper-bosch-aerotwin',
        name: 'Wiper Bosch Aerotwin',
        category: 'Aksesoris',
        desc: 'Wiper flat beam tanpa rangka. Sapuan bersih & merata. Tersedia sem...',
        img: 'https://images.unsplash.com/photo-1526459915562-c5ca724b1d02?w=400&h=300&fit=crop&auto=format',
        badge: null,
    },
    {
        id: 7,
        slug: 'karet-seal-kaca-universal',
        name: 'Karet Seal Kaca Universal',
        category: 'Aksesoris',
        desc: 'Karet seal kaca presisi tinggi. Anti bocor & anti debu. Senyap kab...',
        img: 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=400&h=300&fit=crop&auto=format',
        badge: null,
    },
    {
        id: 8,
        slug: 'cairan-pembersih-kaca-pro',
        name: 'Cairan Pembersih Kaca Pro',
        category: 'Perawatan',
        desc: 'Formula khusus tanpa alkohol. Aman untuk semua jenis kaca film dan ka...',
        img: 'https://images.unsplash.com/photo-1651084296894-105edab05b26?w=400&h=300&fit=crop&auto=format',
        badge: null,
    },
];

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
    return defaultProducts;
});

const defaultCategories = ['Semua', 'Kaca Film', 'Kaca Mobil', 'Aksesoris', 'Perawatan'];

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
                <div v-if="filteredProducts.length === 0" class="text-center py-20 text-slate-400">
                    Produk tidak ditemukan.
                </div>

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
