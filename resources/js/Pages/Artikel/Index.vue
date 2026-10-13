<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
const props = defineProps({
    articles: {
        type: [Object, Array],
        required: true,
    },
    categories: {
        type: Array,
        default: () => [],
    },
});

const allArticles = computed(() => {
    const list = props.articles?.data || (Array.isArray(props.articles) ? props.articles : []);
    if (list.length > 0) {
        return list.map((a) => ({
            id: a.id,
            slug: a.slug,
            title: a.title,
            excerpt: a.excerpt || a.short_description || '',
            category: a.category?.name || a.category || 'Edukasi',
            category_color: a.category?.color_scheme,
            date: a.published_at ? new Date(a.published_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : 'Terbaru',
            readTime: `${a.read_time_minutes || 4} menit`,
            img: a.image_url || a.img || a.featured_image || '/images/default-article.webp',
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

// Incremental Lazy Loading
const limit = ref(6);
const pageSize = 6;

const filteredArticles = computed(() => {
    if (activeCategory.value === 'Semua') {
        return allArticles.value;
    }
    return allArticles.value.filter((a) => a.category === activeCategory.value);
});

const featuredArticle = computed(() => {
    return filteredArticles.value.length > 0 ? filteredArticles.value[0] : null;
});

const restArticles = computed(() => {
    return filteredArticles.value.length > 1 ? filteredArticles.value.slice(1) : [];
});

const visibleRest = computed(() => {
    return restArticles.value.slice(0, limit.value);
});

const hasMore = computed(() => {
    return visibleRest.value.length < restArticles.value.length;
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

const catStyle = (cat, colorScheme) => {
    if (colorScheme && colorScheme.startsWith('#')) {
        return `background-color: ${colorScheme}18; color: ${colorScheme}; border: 1px solid ${colorScheme}35;`;
    }
    const colors = {
        'Tips Perawatan': { bg: '#eff6ff', color: '#1d4ed8' },
        'Edukasi': { bg: '#f0fdf4', color: '#15803d' },
        'Keselamatan': { bg: '#fef2f2', color: '#b91c1c' },
        'Panduan Produk': { bg: '#fef3c7', color: '#92400e' },
        'Panduan': { bg: '#f5f3ff', color: '#6d28d9' },
    };
    const c = colors[cat] || { bg: '#eff6ff', color: '#1d4ed8' };
    return `background-color: ${c.bg}; color: ${c.color};`;
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
        <Head title="Artikel & Tips Kaca Mobil - Pelangi Glass Purwokerto">
            <meta name="description" content="Kumpulan panduan, artikel edukasi, tips menghilangkan jamur kaca mobil, dan panduan memilih kaca film terbaik dari teknisi spesialis." />
        </Head>

        <div class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors">
            <div class="max-w-6xl mx-auto px-6 py-12">
                <!-- Filter Pills (matching Image #4) -->
                <div class="flex gap-2 flex-wrap mb-10">
                    <button
                        v-for="c in categoryList"
                        :key="c"
                        @click="filterCategory(c)"
                        type="button"
                        class="px-4 py-2 rounded-full text-xs font-medium transition-all flex items-center gap-1.5 cursor-pointer border select-none"
                        :class="activeCategory === c
                            ? 'bg-blue-600 text-white border-blue-600 shadow-xs'
                            : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700'"
                    >
                        <svg v-if="c !== 'Semua'" class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l7.29-7.29c.94-.94.94-2.48 0-3.42L12 2Z"/><circle cx="7" cy="7" r=".5" fill="currentColor"/></svg>
                        <span>{{ c }}</span>
                    </button>
                </div>

                <!-- Featured Article Hero Card (matching Image #4 exactly) -->
                <div v-if="featuredArticle" class="mb-6">
                    <div class="rounded-2xl overflow-hidden flex flex-col lg:flex-row lg:h-[320px] transition-all duration-300 group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs hover:border-blue-300 dark:hover:border-blue-700">
                        <div class="overflow-hidden shrink-0 w-full lg:w-[42%] h-60 sm:h-72 lg:h-full relative bg-slate-100 dark:bg-slate-800">
                            <img
                                :src="featuredArticle.img"
                                :alt="featuredArticle.title"
                                loading="lazy"
                                decoding="async"
                                @error="$event.target.src = '/images/workshop-illustration.jpg'"
                                class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105"
                            >
                        </div>
                        <div class="p-6 sm:p-8 flex flex-col flex-1 justify-between">
                            <div>
                                <div class="flex items-center gap-2 mb-3 flex-wrap">
                                    <span
                                        class="text-xs px-2.5 py-1 rounded-full font-medium"
                                        :style="catStyle(featuredArticle.category, featuredArticle.category_color || featuredArticle.category?.color_scheme)"
                                    >
                                        {{ featuredArticle.category }}
                                    </span>
                                    <span class="flex items-center gap-1 text-xs text-slate-400">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span>{{ featuredArticle.readTime }}</span>
                                    </span>
                                </div>
                                <Link :href="`/artikel/${featuredArticle.slug}`" class="no-underline text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                                    <h2 class="font-bold text-lg sm:text-xl lg:text-2xl leading-snug line-clamp-2 mb-3">
                                        {{ featuredArticle.title }}
                                    </h2>
                                </Link>
                                <p class="text-xs sm:text-sm leading-relaxed text-slate-500 dark:text-slate-400 line-clamp-3 text-justify">
                                    {{ featuredArticle.excerpt }}
                                </p>
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-800">
                                <span class="text-xs text-slate-400">
                                    {{ featuredArticle.date }}
                                </span>
                                <Link :href="`/artikel/${featuredArticle.slug}`" class="flex items-center gap-1 text-xs font-semibold text-blue-600 hover:opacity-70 transition-all no-underline">
                                    <span>Baca selengkapnya</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <EmptyState
                    v-if="filteredArticles.length === 0"
                    title="Belum Ada Artikel"
                    message="Saat ini belum ada artikel yang diterbitkan di kategori ini. Silakan cek kategori lain atau baca tips dan panduan kami nanti."
                />

                <!-- Grid Remaining Articles (matching Image #4) -->
                <div v-else-if="visibleRest.length > 0" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div
                        v-for="article in visibleRest"
                        :key="article.id"
                        class="rounded-2xl overflow-hidden flex flex-col transition-all duration-300 group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs hover:border-blue-300 dark:hover:border-blue-700 hover:-translate-y-1 hover:shadow-md"
                    >
                        <Link :href="`/artikel/${article.slug}`" class="overflow-hidden shrink-0 w-full h-[200px] relative bg-slate-100 dark:bg-slate-800 block">
                            <img
                                :src="article.img"
                                :alt="article.title"
                                loading="lazy"
                                decoding="async"
                                @error="$event.target.src = '/images/workshop-illustration.jpg'"
                                class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105"
                            >
                        </Link>
                        <div class="p-6 flex flex-col flex-1">
                            <div class="flex items-center gap-2 mb-3 flex-wrap">
                                <span
                                    class="text-xs px-2.5 py-1 rounded-full font-medium"
                                    :style="catStyle(article.category)"
                                >
                                    {{ article.category }}
                                </span>
                                <span class="flex items-center gap-1 text-xs text-slate-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <span>{{ article.readTime }}</span>
                                </span>
                            </div>
                            <Link :href="`/artikel/${article.slug}`" class="no-underline text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                                <h3 class="font-bold mb-2 leading-snug text-sm text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 line-clamp-2">
                                    {{ article.title }}
                                </h3>
                            </Link>
                            <p class="text-xs leading-relaxed flex-1 mb-4 text-slate-500 dark:text-slate-400 line-clamp-3">
                                {{ article.excerpt }}
                            </p>
                            <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-slate-800">
                                <span class="text-xs text-slate-400">
                                    {{ article.date }}
                                </span>
                                <Link :href="`/artikel/${article.slug}`" class="flex items-center gap-1 text-xs font-semibold text-blue-600 hover:opacity-70 transition-all no-underline">
                                    <span>Baca selengkapnya</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </Link>
                            </div>
                        </div>
                    </div>
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
                        <span>Tampilkan Lebih Banyak Artikel</span>
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
