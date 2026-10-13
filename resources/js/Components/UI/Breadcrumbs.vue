<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    items: {
        type: Array,
        required: true, // [{ label: 'Produk', href: '/produk' }, { label: 'Kaca Depan' }]
    },
});
</script>

<template>
    <nav class="flex items-center text-xs sm:text-sm text-slate-500 dark:text-slate-400 py-3 mb-6 overflow-x-auto no-scrollbar whitespace-nowrap" aria-label="Breadcrumb">
        <Link href="/" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors inline-flex items-center gap-1.5 no-underline">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            <span>Beranda</span>
        </Link>

        <template v-for="(item, index) in items" :key="index">
            <span class="mx-2 text-slate-400 dark:text-slate-600">/</span>
            <Link
                v-if="item.href"
                :href="item.href"
                class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors no-underline"
            >
                {{ item.label }}
            </Link>
            <span
                v-else
                class="text-slate-800 dark:text-slate-200 font-semibold"
                aria-current="page"
            >
                {{ item.label }}
            </span>
        </template>
    </nav>
</template>
