<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import Badge from '@/Components/UI/Badge.vue';
import { useWhatsApp } from '@/Composables/useWhatsApp';

const props = defineProps({
    promo: {
        type: Object,
        required: true,
    },
});

const { buildUrl } = useWhatsApp();

const promoTitle = computed(() => props.promo.name || props.promo.title || '');
const promoSlug = computed(() => props.promo.slug || props.promo.id || '');
const imageUrl = computed(() => {
    return props.promo.img || props.promo.image_url || props.promo.image || '/images/banner2.png';
});
const categoryName = computed(() => props.promo.category || 'Promo');
const description = computed(() => props.promo.desc || props.promo.description || '');

const badgeValue = computed(() => {
    const pct = props.promo.discount_percent || props.promo.badge;
    if (!pct) return null;
    const str = pct.toString().trim();
    return str.startsWith('-') ? str : (str.endsWith('%') ? str : `${str}%`);
});

const promoClaimUrl = computed(() => {
    return buildUrl(`Halo Pelangi Glass, saya ingin klaim promo: ${promoTitle.value}.`);
});
</script>

<template>
    <div class="rounded-2xl overflow-hidden transition-all duration-300 group flex flex-col h-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs hover:border-blue-300 dark:hover:border-blue-700 hover:-translate-y-1 hover:shadow-md">
        <!-- Image Cover with Ribbon -->
        <Link :href="`/promo/${promoSlug}`" class="relative block h-[180px] overflow-hidden bg-slate-100 dark:bg-slate-800 shrink-0">
            <img
                :src="imageUrl"
                :alt="promoTitle"
                loading="lazy"
                decoding="async"
                @error="$event.target.src = '/images/banner2.png'"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
            >
            <Badge v-if="badgeValue" :type="badgeValue" variant="corner" />
        </Link>

        <!-- Content (matching Image #3) -->
        <div class="p-5 flex flex-col flex-1">
            <div class="text-xs font-medium mb-1 text-blue-600 dark:text-blue-400">
                {{ categoryName }}
            </div>

            <Link :href="`/promo/${promoSlug}`" class="no-underline text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                <h3 class="font-bold text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition text-[0.95rem] leading-snug line-clamp-1 mb-1.5">
                    {{ promoTitle }}
                </h3>
            </Link>

            <!-- Price Row (Clean without Hemat Rp) -->
            <div v-if="promo.promo_price || promo.original_price" class="flex items-center gap-2 mb-1 flex-wrap">
                <span v-if="promo.promo_price" class="text-xs font-bold text-red-600 dark:text-red-400">
                    {{ promo.promo_price }}
                </span>
                <span v-if="promo.original_price" class="text-[11px] text-slate-400 line-through">
                    {{ promo.original_price }}
                </span>
            </div>

            <!-- Description -->
            <p v-if="description" class="text-xs leading-relaxed text-slate-500 dark:text-slate-400 line-clamp-2 text-justify mb-3.5">
                {{ description }}
            </p>

            <!-- Bottom CTA Button (matching Image #3 exactly) -->
            <a
                :href="promoClaimUrl"
                target="_blank"
                rel="noopener noreferrer"
                class="mt-auto w-full flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-semibold text-white transition-all hover:opacity-90 bg-blue-600 hover:bg-blue-700 no-underline shadow-xs hover:scale-[1.02] active:scale-95"
            >
                <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.196 8.196 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24m4.52 11.66c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.02-1.25-.75-.67-1.26-1.5-1.4-1.75-.15-.25-.02-.39.11-.51.11-.11.25-.29.37-.44.13-.15.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.12-.56-1.34-.76-1.84-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.87.85-.87 2.08 0 1.22.89 2.41 1.02 2.58.12.17 1.76 2.68 4.26 3.76.6.26 1.06.41 1.42.53.6.19 1.15.16 1.58.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.17-.48-.3"/>
                </svg>
                <span>Klaim Promo via WA</span>
            </a>
        </div>
    </div>
</template>
