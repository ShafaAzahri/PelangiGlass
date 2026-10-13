<script setup>
import BaseButton from './BaseButton.vue';

defineProps({
    title: {
        type: String,
        default: 'Tidak Ada Data Ditemukan',
    },
    message: {
        type: String,
        default: 'Coba ubah kata kunci pencarian atau bersihkan filter yang dipilih.',
    },
    actionLabel: {
        type: String,
        default: null,
    },
    actionHref: {
        type: String,
        default: null,
    },
});

defineEmits(['action']);
</script>

<template>
    <div class="py-16 text-center max-w-md mx-auto px-4">
        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.3-4.3"></path>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">
            {{ title }}
        </h3>
        <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed">
            {{ message }}
        </p>
        <BaseButton
            v-if="actionLabel"
            :as="actionHref ? 'Link' : 'button'"
            :href="actionHref"
            @click="$emit('action')"
            variant="outline"
            size="sm"
        >
            {{ actionLabel }}
        </BaseButton>
    </div>
</template>
