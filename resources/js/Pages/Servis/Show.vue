<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Breadcrumbs from '@/Components/UI/Breadcrumbs.vue';
import ServiceCard from '@/Components/Cards/ServiceCard.vue';
import BaseButton from '@/Components/UI/BaseButton.vue';
import { useWhatsApp } from '@/Composables/useWhatsApp';

const props = defineProps({
    service: {
        type: Object,
        required: true,
    },
    otherServices: {
        type: Array,
        default: () => [],
    },
});

const { bookingUrl } = useWhatsApp();

const breadcrumbItems = computed(() => [
    { label: 'Layanan & Servis', href: '/servis' },
    { label: props.service.name },
]);

const duration = computed(() => props.service.duration_estimate || '2-3 Jam');
const warranty = computed(() => props.service.warranty_period ? `Garansi ${props.service.warranty_period}` : 'Garansi Resmi');
</script>

<template>
    <AppLayout>
        <Head :title="`${service.name} - Pelangi Glass Purwokerto`">
            <meta name="description" :content="service.short_description || `Layanan ${service.name} bergaransi resmi di Pelangi Glass Purwokerto.`" />
        </Head>

        <div class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen py-10 sm:py-14 transition-colors">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <!-- Breadcrumbs -->
                <Breadcrumbs :items="breadcrumbItems" />

                <!-- Detail Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
                    <!-- Left: Service Visual Image -->
                    <div class="lg:col-span-6">
                        <div class="rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm relative">
                            <img
                                :src="service.image_url"
                                :alt="service.name"
                                class="w-full h-80 sm:h-96 object-cover"
                            >
                            <span class="absolute top-4 left-4 inline-block px-3 py-1 text-xs font-bold uppercase tracking-wider text-white bg-blue-600 rounded-full shadow-md">
                                {{ warranty }}
                            </span>
                        </div>
                    </div>

                    <!-- Right: Info & Booking Card -->
                    <div class="lg:col-span-6 space-y-6">
                        <div>
                            <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider block mb-1">
                                {{ service.category?.name || 'Paket Layanan' }}
                            </span>
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white leading-tight mb-3">
                                {{ service.name }}
                            </h1>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ service.short_description }}
                            </p>
                        </div>

                        <!-- Stats Box -->
                        <div class="grid grid-cols-2 gap-4 p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800">
                            <div>
                                <span class="text-xs text-slate-400 block mb-1">Estimasi Pengerjaan:</span>
                                <div class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                    <span>{{ duration }}</span>
                                </div>
                            </div>
                            <div>
                                <span class="text-xs text-slate-400 block mb-1">Jaminan Kualitas:</span>
                                <div class="text-lg font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                    <span>{{ warranty }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Description & Features -->
                        <div class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed space-y-4 border-t border-slate-200 dark:border-slate-800 pt-4">
                            <h4 class="font-bold text-slate-800 dark:text-slate-200 text-sm">Rincian & Prosedur Pengerjaan:</h4>
                            <div v-if="service.full_description" v-html="service.full_description" class="prose dark:prose-invert max-w-none text-sm leading-relaxed" />
                            <p v-else class="text-sm text-slate-600 dark:text-slate-400">
                                {{ service.description || service.short_description }}
                            </p>
                        </div>

                        <!-- Booking Button -->
                        <div class="pt-4 border-t border-slate-200 dark:border-slate-800">
                            <BaseButton
                                as="a"
                                :href="bookingUrl(service.name)"
                                target="_blank"
                                rel="noopener noreferrer"
                                variant="primary"
                                size="lg"
                                class="w-full text-sm font-bold shadow-md"
                            >
                                <template #prefix>
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                </template>
                                Booking Jadwal Servis Sekarang
                            </BaseButton>
                        </div>
                    </div>
                </div>

                <!-- Other Services -->
                <div v-if="otherServices.length > 0" class="mt-16 pt-10 border-t border-slate-200 dark:border-slate-800">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                            Layanan Terkait Lainnya
                        </h3>
                        <Link href="/servis" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline no-underline">
                            Lihat Semua Layanan →
                        </Link>
                    </div>

                    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <ServiceCard
                            v-for="s in otherServices"
                            :key="s.id"
                            :service="s"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
