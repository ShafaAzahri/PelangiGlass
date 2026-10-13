<script setup>
import { computed } from 'vue';

const props = defineProps({
    type: {
        type: String,
        default: 'Terlaris',
    },
    variant: {
        type: String,
        default: 'corner', // 'corner' | 'pill'
    },
});

const gradient = computed(() => {
    switch (props.type) {
        case 'Terlaris':
            return 'bg-gradient-to-r from-red-600 to-rose-600 shadow-rose-950/20';
        case 'Premium':
            return 'bg-gradient-to-r from-amber-600 via-amber-500 to-yellow-500 shadow-amber-950/20';
        case 'Baru':
            return 'bg-gradient-to-r from-blue-600 to-sky-500 shadow-blue-950/20';
        case 'Bergaransi':
        case 'Hemat':
            return 'bg-gradient-to-r from-emerald-600 to-teal-500 shadow-emerald-950/20';
        default:
            return 'bg-gradient-to-r from-red-600 to-rose-600 shadow-rose-950/20';
    }
});
</script>

<template>
    <div v-if="variant === 'corner'" class="absolute top-0 left-0 z-10">
        <span
            class="inline-flex items-center gap-1 px-2.5 py-1 text-[10.5px] font-extrabold uppercase tracking-wider text-white shadow-md rounded-br-xl select-none"
            :class="gradient"
        >
            <!-- Terlaris: Flame/Drop -->
            <svg v-if="type === 'Terlaris'" class="w-3 h-3 fill-current text-white/95" viewBox="0 0 24 24">
                <path d="M12 2c.5 3 2 4.5 4 6 2.5 1.8 4 4.5 4 8a8 8 0 1 1-16 0c0-3.5 2-6.5 4.5-8.5C9.5 6 11 4.5 12 2z"/>
            </svg>

            <!-- Premium: Star -->
            <svg v-else-if="type === 'Premium'" class="w-3 h-3 fill-current text-white/95" viewBox="0 0 24 24">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>

            <!-- Baru: Plus -->
            <svg v-else-if="type === 'Baru'" class="w-3 h-3 text-white/95" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            <!-- Diskon / Persen: Tag Icon -->
            <svg v-else-if="type && type.includes('%')" class="w-3 h-3 text-white/95" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z"/>
            </svg>

            <!-- Bergaransi / Hemat / Default: Checkmark -->
            <svg v-else class="w-3 h-3 text-white/95" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>

            <span><slot>{{ type }}</slot></span>
        </span>
    </div>

    <span
        v-else
        class="inline-flex items-center gap-1.5 text-[11px] px-2.5 py-0.5 rounded-full font-bold shadow-xs tracking-wide text-white select-none"
        :class="gradient"
    >
        <span><slot>{{ type }}</slot></span>
    </span>
</template>
