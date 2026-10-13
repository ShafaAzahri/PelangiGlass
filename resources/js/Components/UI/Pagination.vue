<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <nav v-if="links && links.length > 3" class="flex items-center justify-center gap-1.5 mt-10 sm:mt-12 select-none" aria-label="Pagination">
        <template v-for="(link, index) in links" :key="index">
            <span
                v-if="!link.url"
                class="px-3.5 py-2 text-xs sm:text-sm font-medium text-slate-400 dark:text-slate-600 rounded-lg border border-slate-200 dark:border-slate-800 cursor-not-allowed opacity-50"
                v-html="link.label"
            />
            <Link
                v-else
                :href="link.url"
                preserve-scroll
                class="px-3.5 py-2 text-xs sm:text-sm font-semibold rounded-lg border transition-colors duration-150 no-underline"
                :class="link.active
                    ? 'bg-blue-600 text-white border-blue-600 shadow-xs'
                    : 'bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-600'"
                v-html="link.label"
            />
        </template>
    </nav>
</template>
