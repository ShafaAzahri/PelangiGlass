<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Breadcrumbs from '@/Components/UI/Breadcrumbs.vue';
import BaseButton from '@/Components/UI/BaseButton.vue';
import { useWhatsApp } from '@/Composables/useWhatsApp';

const props = defineProps({
    promo: {
        type: Object,
        required: true,
    },
});

const { buildUrl } = useWhatsApp();

const copied = ref(false);

const promoName = computed(() => props.promo.name || props.promo.title || 'Promo');
const promoImg = computed(() => props.promo.img || props.promo.image_url || props.promo.image || '/images/banner2.png');
const promoCode = computed(() => props.promo.code || '');
const promoCategory = computed(() => props.promo.category || 'Penawaran Spesial');
const validUntil = computed(() => props.promo.valid_until || props.promo.end_date || 'Selama Persediaan Ada');
const discountText = computed(() => {
    if (props.promo.discount_percent) {
        const val = props.promo.discount_percent.toString().trim();
        return val.startsWith('Diskon') ? val : `Diskon ${val.endsWith('%') ? val : val + '%'}`;
    }
    return props.promo.badge || 'PROMO SPESIAL';
});

const breadcrumbItems = computed(() => [
    { label: 'Promo Spesial', href: '/promo' },
    { label: promoName.value },
]);

const copyCode = () => {
    navigator.clipboard.writeText(promoCode.value);
    copied.value = true;
    setTimeout(() => {
        copied.value = false;
    }, 2000);
};
</script>

<template>
    <AppLayout>
        <Head :title="`${promoName} - Pelangi Glass Purwokerto`">
            <meta name="description" :content="promo.desc || `Klaim promo ${promoName} di Pelangi Glass Purwokerto.`" />
        </Head>

        <div class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen py-10 sm:py-14 transition-colors">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <!-- Breadcrumbs -->
                <Breadcrumbs :items="breadcrumbItems" />

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
                    <!-- Left: Promo Visual Image & Code -->
                    <div class="lg:col-span-6 space-y-4">
                        <div class="rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm relative">
                            <img
                                :src="promoImg"
                                :alt="promoName"
                                @error="$event.target.src = '/images/banner2.png'"
                                class="w-full h-80 sm:h-96 object-cover"
                            >
                            <span class="absolute top-4 left-4 inline-block px-3 py-1 text-xs font-bold uppercase tracking-wider text-white bg-red-600 rounded-full shadow-md">
                                {{ discountText }}
                            </span>
                        </div>

                        <!-- Voucher Code Box -->
                        <div v-if="promo.code" class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 flex items-center justify-between">
                            <div>
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-0.5">
                                    Kode Voucher Promo:
                                </span>
                                <span class="text-base font-bold font-mono text-slate-900 dark:text-slate-100">
                                    {{ promoCode }}
                                </span>
                                <span class="text-[11px] text-slate-400 block mt-0.5">
                                    Berlaku s/d {{ validUntil }}
                                </span>
                            </div>
                            <button
                                type="button"
                                @click="copyCode"
                                class="px-3.5 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 hover:border-blue-500 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 transition cursor-pointer"
                            >
                                <span v-if="!copied">Salin Kode</span>
                                <span v-else class="text-emerald-600 dark:text-emerald-400 font-bold">Tersalin!</span>
                            </button>
                        </div>
                    </div>

                    <!-- Right: Info & Syarat -->
                    <div class="lg:col-span-6 space-y-6">
                        <div>
                            <span class="text-xs font-bold text-red-600 uppercase tracking-wider block mb-1">
                                {{ promoCategory }}
                            </span>
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white leading-tight mb-3">
                                {{ promoName }}
                            </h1>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ promo.desc }}
                            </p>
                        </div>

                        <!-- Price Display -->
                        <div v-if="promo.promo_price || promo.original_price" class="flex items-center gap-3 py-1 flex-wrap">
                            <span v-if="promo.promo_price" class="text-2xl font-black text-red-600 dark:text-red-400">
                                {{ promo.promo_price }}
                            </span>
                            <span v-if="promo.original_price" class="text-sm text-slate-400 line-through">
                                {{ promo.original_price }}
                            </span>
                            <span v-if="discountText" class="px-2.5 py-1 rounded-md text-xs font-bold text-white bg-red-600">
                                {{ discountText }}
                            </span>
                        </div>

                        <!-- Syarat & Ketentuan -->
                        <div v-if="promo.terms && promo.terms.length > 0" class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 space-y-3">
                            <h4 class="font-bold text-slate-800 dark:text-slate-200 text-sm">Syarat & Ketentuan Promo:</h4>
                            <ul class="space-y-2 text-xs text-slate-600 dark:text-slate-400 list-disc pl-4">
                                <li v-for="(term, idx) in promo.terms" :key="idx">
                                    {{ term }}
                                </li>
                            </ul>
                        </div>

                        <!-- Klaim Promo CTA -->
                        <div class="pt-4 border-t border-slate-200 dark:border-slate-800">
                            <BaseButton
                                as="a"
                                :href="buildUrl(`Halo Pelangi Glass, saya ingin klaim promo: ${promoName}.`)"
                                target="_blank"
                                rel="noopener noreferrer"
                                variant="danger"
                                size="lg"
                                class="w-full text-sm font-bold shadow-md"
                            >
                                <template #prefix>
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                </template>
                                Klaim Promo Ini via WhatsApp
                            </BaseButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
