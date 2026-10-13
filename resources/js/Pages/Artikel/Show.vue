<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Breadcrumbs from '@/Components/UI/Breadcrumbs.vue';
import ArticleCard from '@/Components/Cards/ArticleCard.vue';
import BaseButton from '@/Components/UI/BaseButton.vue';
import { useWhatsApp } from '@/Composables/useWhatsApp';
import { useFormatters } from '@/Composables/useFormatters';

const props = defineProps({
    article: {
        type: Object,
        required: true,
    },
    relatedArticles: {
        type: Array,
        default: () => [],
    },
});

const { buildUrl } = useWhatsApp();
const { formatDate } = useFormatters();

const breadcrumbItems = computed(() => [
    { label: 'Artikel & Tips', href: '/artikel' },
    { label: props.article.title },
]);

const formattedDate = computed(() => formatDate(props.article.published_at || props.article.created_at));
const readTime = computed(() => `${props.article.read_time_minutes || 4} Menit`);
</script>

<template>
    <AppLayout>
        <Head :title="`${article.title} - Pelangi Glass Purwokerto`">
            <meta name="description" :content="article.excerpt || article.short_description || `Baca artikel ${article.title} di Pelangi Glass Purwokerto.`" />
        </Head>

        <div class="bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen py-10 sm:py-16 transition-colors">
            <article class="max-w-4xl mx-auto px-4 sm:px-6">
                <!-- Breadcrumbs -->
                <Breadcrumbs :items="breadcrumbItems" />

                <!-- Header Meta -->
                <div class="space-y-4 mb-8">
                    <span class="inline-block text-xs font-bold px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/70 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-900">
                        {{ article.category?.name || 'Tips & Panduan' }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
                        {{ article.title }}
                    </h1>
                    <div class="flex items-center gap-4 text-xs text-slate-400 pt-1">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                            <span>{{ formattedDate }}</span>
                        </span>
                        <span>•</span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span>Waktu Baca {{ readTime }}</span>
                        </span>
                    </div>
                </div>

                <!-- Featured Image -->
                <div v-if="article.image_url" class="rounded-3xl overflow-hidden shadow-md mb-10 border border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-slate-900 h-64 sm:h-80 md:h-[400px] w-full">
                    <img
                        :src="article.image_url"
                        :alt="article.title"
                        class="w-full h-full object-cover object-top"
                    >
                </div>

                <!-- Article Content Body -->
                <div
                    v-html="article.content || article.body"
                    class="prose prose-slate dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 text-sm sm:text-base leading-relaxed space-y-5"
                />

                <!-- Consultation CTA Box -->
                <div class="mt-12 p-6 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white text-sm mb-1">
                            Punya Pertanyaan Seputar Kaca Mobil?
                        </h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Teknisi spesialis kami siap memberikan konsultasi dan estimasi biaya gratis.
                        </p>
                    </div>
                    <BaseButton
                        as="a"
                        :href="buildUrl(`Halo Pelangi Glass, saya baru membaca artikel '${article.title}' dan ingin konsultasi.`)"
                        target="_blank"
                        rel="noopener noreferrer"
                        variant="primary"
                        size="md"
                        class="shrink-0 text-xs"
                    >
                        Konsultasi via WhatsApp
                    </BaseButton>
                </div>

                <!-- Related Articles -->
                <div v-if="relatedArticles.length > 0" class="mt-14 pt-10 border-t border-slate-200 dark:border-slate-800">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                            Artikel & Tips Terkait
                        </h3>
                        <Link href="/artikel" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline no-underline">
                            Lihat Semua Tips →
                        </Link>
                    </div>

                    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <ArticleCard
                            v-for="ra in relatedArticles"
                            :key="ra.id"
                            :article="ra"
                        />
                    </div>
                </div>
            </article>
        </div>
    </AppLayout>
</template>
