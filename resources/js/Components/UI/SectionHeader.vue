<script setup>
defineProps({
    badge: { type: String, default: '' },
    title: { type: String, required: true },
    subtitle: { type: String, default: '' },
    align: { type: String, default: 'center' }, // 'center' | 'left'
});
</script>

<template>
    <div :class="['mb-10 sm:mb-14', align === 'center' ? 'text-center max-w-3xl mx-auto' : 'text-left max-w-2xl']">
        <span
            v-if="badge"
            class="inline-block px-3 py-1 text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/60 rounded-full border border-blue-200 dark:border-blue-900 mb-3"
        >
            {{ badge }}
        </span>
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
            {{ title }}
        </h2>
        <p v-if="subtitle" class="mt-3 sm:mt-4 text-sm sm:text-base text-slate-600 dark:text-slate-400 leading-relaxed font-normal">
            {{ subtitle }}
        </p>
        <div v-if="$slots.action" class="mt-5">
            <slot name="action" />
        </div>
    </div>
</template>
