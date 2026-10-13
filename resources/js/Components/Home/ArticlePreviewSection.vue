<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useFormatters } from '@/Composables/useFormatters';

const props = defineProps({
    articles: {
        type: Array,
        default: () => [],
    },
});

const { formatDate } = useFormatters();

const defaultArticles = [
    {
        slug: 'cara-membersihkan-jamur-kaca-mobil',
        title: 'Cara Efektif Membersihkan Jamur Kaca Mobil Sendiri di Rumah',
        excerpt: 'Jamur kaca dan kerak air sering mengganggu visibilitas saat berkendara di malam hari atau hujan deras. Simak cara aman membersihkannya tanpa merusak lapisan kaca.',
        category: 'Tips Perawatan',
        date: '2 Sep 2026',
        readTime: '4 menit',
        img: '/storage/articles/bersihkan-kaca-dari-jamur.png',
    },
    {
        slug: 'panduan-merawat-kabin-dan-kaca-mobil',
        title: 'Panduan Merawat Kebersihan Kabin & Kaca Mobil Agar Bebas Bau dan Lembap',
        excerpt: 'Kabin yang bersih dan kaca bebas embun membuat perjalanan jauh lebih nyaman. Pelajari tips perawatan sirkulasi AC, pembersihan karpet, dan perawatan kaca film.',
        category: 'Tips Perawatan',
        date: '28 Agu 2026',
        readTime: '5 menit',
        img: '/storage/articles/cara-merawat-kabin-mobil.png',
    },
    {
        slug: 'penyebab-alarm-mobil-bunyi-terus-dan-solusinya',
        title: 'Penyebab Alarm Mobil Bunyi Terus Menerus dan Cara Mengatasinya',
        excerpt: 'Alarm mobil tiba-tiba berbunyi tanpa sebab di tengah malam? Kenali faktor penyebabnya mulai dari baterai remote, switch pintu, sensor getar kaca, hingga modul alarm.',
        category: 'Edukasi',
        date: '20 Agu 2026',
        readTime: '4 menit',
        img: '/storage/articles/alarm-mobil-nyala-terus.png',
    },
];

const articlesList = computed(() => {
    if (props.articles && props.articles.length > 0) {
        return props.articles.map((a) => ({
            slug: a.slug,
            title: a.title,
            excerpt: a.excerpt || a.short_description || '',
            category: a.category?.name || 'Tips Perawatan',
            date: a.published_at ? formatDate(a.published_at) : 'Terbaru',
            readTime: `${a.read_time_minutes || 4} menit`,
            img: a.image_url || '/images/default-article.webp',
        }));
    }
    return defaultArticles;
});
</script>

<template>
    <section class="py-24 bg-slate-50 dark:bg-slate-950 transition-colors">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex items-end justify-between mb-12 flex-wrap gap-4">
                <div>
                    <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3 text-blue-600 dark:text-blue-400">
                        Blog
                    </div>
                    <h2 class="uppercase text-slate-900 dark:text-slate-100 text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight tracking-tight">
                        Artikel & Tips
                    </h2>
                </div>
                <Link
                    href="/artikel"
                    class="inline-flex items-center gap-2 text-sm font-medium transition-all text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 no-underline"
                >
                    <span>Lihat Semua Artikel</span>
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                    </svg>
                </Link>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <article
                    v-for="(a, idx) in articlesList"
                    :key="idx"
                    class="rounded-2xl overflow-hidden flex flex-col transition-all duration-300 group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs hover:border-blue-300 dark:hover:border-blue-700 hover:-translate-y-1 hover:shadow-md"
                >
                    <Link :href="`/artikel/${a.slug}`" class="overflow-hidden shrink-0 w-full h-[220px] relative bg-slate-100 dark:bg-slate-800 block">
                        <img
                            :src="a.img"
                            :alt="a.title"
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105"
                        >
                    </Link>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-3 flex-wrap">
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-400">
                                {{ a.category }}
                            </span>
                            <span class="flex items-center gap-1 text-xs text-slate-400">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <span>{{ a.readTime }}</span>
                            </span>
                        </div>
                        <Link :href="`/artikel/${a.slug}`" class="no-underline text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            <h3 class="font-bold mb-2 leading-snug text-base line-clamp-2">
                                {{ a.title }}
                            </h3>
                        </Link>
                        <p class="text-xs leading-relaxed flex-1 mb-4 text-slate-500 dark:text-slate-400 line-clamp-3">
                            {{ a.excerpt }}
                        </p>
                        <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-slate-800/80">
                            <span class="text-xs text-slate-400">
                                {{ a.date }}
                            </span>
                            <Link :href="`/artikel/${a.slug}`" class="flex items-center gap-1 text-xs font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors no-underline">
                                <span>Baca selengkapnya</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                            </Link>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>
