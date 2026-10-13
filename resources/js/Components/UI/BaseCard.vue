<script setup>
defineProps({
    hover: {
        type: Boolean,
        default: true,
    },
    padding: {
        type: String,
        default: 'p-5 sm:p-6',
    },
});
</script>

<template>
    <div
        class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 transition-all duration-300"
        :class="[
            padding,
            hover ? 'hover:shadow-lg hover:-translate-y-1 hover:border-blue-500/30 dark:hover:border-blue-500/30' : 'shadow-xs'
        ]"
    >
        <slot />
    </div>
</template>
