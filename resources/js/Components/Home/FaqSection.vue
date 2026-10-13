<script setup>
import { ref, computed } from 'vue';
import { useWhatsApp } from '@/Composables/useWhatsApp';

const props = defineProps({
    faqs: {
        type: Array,
        default: () => [],
    },
});

const { buildUrl } = useWhatsApp();

const faqsList = computed(() => {
    if (props.faqs && props.faqs.length > 0) {
        return props.faqs.map((f) => ({
            q: f.question,
            a: f.answer,
        }));
    }
    return [];
});

const openIndex = ref(0);

const toggle = (idx) => {
    openIndex.value = openIndex.value === idx ? null : idx;
};
</script>

<template>
    <section v-if="faqsList.length > 0" class="py-24 bg-slate-50 dark:bg-slate-950 transition-colors">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-12 lg:gap-20">
                <!-- Left: Title & Help Note -->
                <div class="lg:w-72 shrink-0">
                    <div class="text-xs font-semibold tracking-[0.18em] uppercase mb-4 text-blue-600 dark:text-blue-400">
                        FAQ
                    </div>
                    <h2 class="uppercase mb-5 text-slate-900 dark:text-slate-100 text-3xl sm:text-4xl font-black leading-tight tracking-tight">
                        Pertanyaan yang Sering Ditanyakan
                    </h2>
                    <p class="text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                        <a
                            :href="buildUrl('Halo Pelangi Glass, saya ada pertanyaan mengenai kaca mobil / kaca film.')"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-blue-600 dark:text-blue-400 font-semibold no-underline hover:underline"
                        >
                            Hubungi tim kami
                        </a>
                        via WhatsApp, kami siap membantu.
                    </p>
                </div>

                <!-- Right: Accordion -->
                <div class="flex-1 rounded-2xl overflow-hidden bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
                    <div
                        v-for="(faq, idx) in faqsList"
                        :key="idx"
                        class="border-b border-slate-100 dark:border-slate-800 last:border-b-0"
                    >
                        <button
                            @click="toggle(idx)"
                            type="button"
                            class="w-full flex items-center justify-between gap-4 px-7 py-5 text-left bg-transparent border-0 cursor-pointer select-none"
                        >
                            <span class="font-semibold text-sm text-slate-900 dark:text-slate-100">
                                {{ faq.q }}
                            </span>
                            <span
                                class="shrink-0 w-7 h-7 rounded-full border flex items-center justify-center transition-all"
                                :class="openIndex === idx ? 'border-blue-600 bg-blue-600 text-white' : 'border-slate-300 dark:border-slate-700 text-slate-400'"
                            >
                                <svg v-if="openIndex === idx" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/></svg>
                                <svg v-else class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                            </span>
                        </button>
                        <div v-show="openIndex === idx" class="px-7 pb-6 transition-all duration-200">
                            <p class="text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                                {{ faq.a }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
