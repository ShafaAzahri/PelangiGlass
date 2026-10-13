<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useFormatters } from '@/Composables/useFormatters';

const props = defineProps({
    article: {
        type: Object,
        required: true,
    },
});

const { formatDate } = useFormatters();

const articleTitle = computed(() => props.article.title || '');
const articleSlug = computed(() => props.article.slug || props.article.id || '');
const categoryTitle = computed(() => props.article.category?.name || props.article.category || 'Tips & Panduan');
const imageUrl = computed(() => props.article.image_url || props.article.image || '/images/default-article.webp');
const articleExcerpt = computed(() => props.article.excerpt || props.article.short_description || '');
const publishDate = computed(() => formatDate(props.article.published_at || props.article.created_at));
</script>

<template>
    <article class="bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-xs hover:border-blue-300 dark:hover:border-blue-700 hover:-translate-y-1 hover:shadow-md transition-all duration-300 flex flex-col h-full group">
        <!-- Cover Image -->
        <Link :href="`/artikel/${articleSlug}`" class="relative block h-48 overflow-hidden bg-slate-100 dark:bg-slate-800">
            <img
                :src="imageUrl"
                :alt="articleTitle"
                loading="lazy"
                decoding="async"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
            >
            <div class="absolute top-3 left-3">
                <span class="inline-block px-2.5 py-1 text-[11px] font-bold text-blue-700 dark:text-blue-300 bg-white/95 dark:bg-slate-900/95 backdrop-blur-xs rounded-lg shadow-xs">
                    {{ categoryTitle }}
                </span>
            </div>
        </Link>

        <!-- Content -->
        <div class="p-5 flex flex-col flex-1">
            <div class="text-[11px] text-slate-400 dark:text-slate-500 mb-2">
                {{ publishDate }}
            </div>

            <Link :href="`/artikel/${articleSlug}`" class="no-underline text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                <h3 class="text-base font-bold leading-snug line-clamp-2 mb-2">
                    {{ articleTitle }}
                </h3>
            </Link>

            <p v-if="articleExcerpt" class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed line-clamp-3 mb-4">
                {{ articleExcerpt }}
            </p>

            <div class="mt-auto pt-3 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between">
                <Link
                    :href="`/artikel/${articleSlug}`"
                    class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 inline-flex items-center gap-1 no-underline"
                >
                    <span>Baca Selengkapnya</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                    </svg>
                </Link>
            </div>
        </div>
    </article>
</template>
