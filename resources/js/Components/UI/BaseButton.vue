<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    as: {
        type: String,
        default: 'button', // 'button' | 'a' | 'Link'
    },
    href: {
        type: String,
        default: null,
    },
    variant: {
        type: String,
        default: 'primary', // 'primary' | 'secondary' | 'outline' | 'danger' | 'ghost'
    },
    size: {
        type: String,
        default: 'md', // 'sm' | 'md' | 'lg'
    },
    loading: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    prefetch: {
        type: Boolean,
        default: false,
    },
    target: {
        type: String,
        default: null,
    },
    rel: {
        type: String,
        default: null,
    },
});

const componentTag = computed(() => {
    if (props.as === 'Link') return Link;
    if (props.as === 'a' || props.href) return 'a';
    return 'button';
});

const variantClasses = computed(() => {
    switch (props.variant) {
        case 'secondary':
            return 'bg-blue-800 hover:bg-blue-900 text-white shadow-sm';
        case 'outline':
            return 'border-2 border-blue-600 text-blue-600 dark:text-blue-400 dark:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-950';
        case 'danger':
            return 'bg-red-600 hover:bg-red-700 text-white shadow-sm';
        case 'ghost':
            return 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800';
        case 'primary':
        default:
            return 'bg-blue-600 hover:bg-blue-700 text-white shadow-sm hover:shadow-md';
    }
});

const sizeClasses = computed(() => {
    switch (props.size) {
        case 'sm':
            return 'px-3 py-1.5 text-xs rounded-lg gap-1.5';
        case 'lg':
            return 'px-6 py-3.5 text-base rounded-xl gap-2.5';
        case 'md':
        default:
            return 'px-4.5 py-2 text-sm rounded-xl gap-2';
    }
});
</script>

<template>
    <component
        :is="componentTag"
        :href="href"
        :prefetch="prefetch"
        :target="target"
        :rel="rel"
        :disabled="disabled || loading"
        class="inline-flex items-center justify-center font-semibold transition-all duration-200 active:scale-95 cursor-pointer no-underline disabled:opacity-60 disabled:cursor-not-allowed select-none"
        :class="[variantClasses, sizeClasses]"
    >
        <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <slot name="prefix" />
        <slot />
        <slot name="suffix" />
    </component>
</template>
