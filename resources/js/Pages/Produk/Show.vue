<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Breadcrumbs from '@/Components/UI/Breadcrumbs.vue';
import ProductCard from '@/Components/Cards/ProductCard.vue';
import BaseButton from '@/Components/UI/BaseButton.vue';
import { useWhatsApp } from '@/Composables/useWhatsApp';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    relatedProducts: {
        type: Array,
        default: () => [],
    },
});

const { productInquiryUrl } = useWhatsApp();

const selectedImage = ref(null);

const allGalleryImages = computed(() => {
    const list = [];
    if (props.product.image_url) {
        list.push(props.product.image_url);
    }
    if (Array.isArray(props.product.gallery_urls)) {
        for (const url of props.product.gallery_urls) {
            if (url && !list.includes(url)) {
                list.push(url);
            }
        }
    }
    return list;
});

const currentMainImage = computed(() => {
    return selectedImage.value || props.product.image_url;
});

const breadcrumbItems = computed(() => [
    { label: 'Katalog Produk', href: '/produk' },
    { label: props.product.name },
]);

</script>

<template>
    <AppLayout>
        <Head :title="`${product.name} - Pelangi Glass Purwokerto`">
            <meta name="description" :content="product.short_description || `Detail produk ${product.name} di Pelangi Glass Purwokerto.`" />
        </Head>

        <div class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen py-10 sm:py-14 transition-colors">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <!-- Breadcrumbs -->
                <Breadcrumbs :items="breadcrumbItems" />

                <!-- Product Detail Top Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-stretch">
                    <!-- Left: Main Image & Interactive Gallery Thumbnails -->
                    <div class="lg:col-span-6 space-y-4">
                        <div class="rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm relative">
                            <img
                                :src="currentMainImage"
                                :alt="product.name"
                                class="w-full h-80 sm:h-96 object-cover transition-all duration-300"
                            >
                            <span
                                v-if="product.badge"
                                class="absolute top-4 left-4 inline-block px-3 py-1 text-xs font-bold uppercase tracking-wider text-white bg-blue-600 rounded-full shadow-md"
                            >
                                {{ product.badge?.value || product.badge }}
                            </span>
                        </div>

                        <!-- Gallery Thumbnails (if additional photos uploaded) -->
                        <div v-if="allGalleryImages.length > 1" class="space-y-2">
                            <span class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider block">
                                Galeri Foto Produk ({{ allGalleryImages.length }} Foto)
                            </span>
                            <div class="flex items-center gap-3 overflow-x-auto pb-2">
                                <button
                                    v-for="(img, idx) in allGalleryImages"
                                    :key="idx"
                                    type="button"
                                    @click="selectedImage = img"
                                    class="w-20 h-20 rounded-2xl overflow-hidden border-2 transition-all shrink-0 cursor-pointer p-0.5 bg-white dark:bg-slate-900"
                                    :class="currentMainImage === img ? 'border-blue-600 shadow-md scale-105 ring-2 ring-blue-500/20' : 'border-slate-200 dark:border-slate-800 opacity-70 hover:opacity-100'"
                                    :aria-label="`Pilih foto ${idx + 1}`"
                                >
                                    <img :src="img" :alt="`${product.name} foto ${idx + 1}`" class="w-full h-full object-cover rounded-xl">
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Info -->
                    <!-- Right: Info (Flex column stretched to match left image height) -->
                    <div class="lg:col-span-6 flex flex-col justify-between h-full">
                        <div class="space-y-6">
                        <div>
                            <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider block mb-1">
                                {{ product.category?.name || 'Kaca Mobil' }}
                            </span>
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white leading-tight">
                                {{ product.name }}
                            </h1>
                            <p v-if="product.vehicle_compatibility" class="text-xs font-semibold text-slate-500 dark:text-slate-400 mt-2 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9C2.1 11.1 2 11.6 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg>
                                <span>Kompatibilitas: {{ product.vehicle_compatibility }}</span>
                            </p>
                        </div>


                        <!-- Description & Specs -->
                        <div class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed space-y-4 border-t border-slate-200 dark:border-slate-800 pt-4">
                            <h4 class="font-bold text-slate-800 dark:text-slate-200 text-sm">Deskripsi & Spesifikasi Produk:</h4>
                            <div v-if="product.full_description" v-html="product.full_description" class="prose dark:prose-invert max-w-none text-sm leading-relaxed" />
                            <p v-else class="text-sm text-slate-600 dark:text-slate-400">
                                {{ product.short_description }}
                            </p>
                        </div>
                        </div>
                        <!-- WhatsApp Action CTA (Aligned flush with bottom of left column) -->
                        <div class="pt-6 mt-6 lg:mt-auto border-t border-slate-200 dark:border-slate-800">
                            <BaseButton
                                as="a"
                                :href="productInquiryUrl(product.name)"
                                target="_blank"
                                rel="noopener noreferrer"
                                variant="primary"
                                size="lg"
                                class="w-full text-sm font-bold shadow-md"
                            >
                                <template #prefix>
                                    <svg class="w-4 h-4 mr-2 shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.196 8.196 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24m4.52 11.66c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.02-1.25-.75-.67-1.26-1.5-1.4-1.75-.15-.25-.02-.39.11-.51.11-.11.25-.29.37-.44.13-.15.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.12-.56-1.34-.76-1.84-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.87.85-.87 2.08 0 1.22.89 2.41 1.02 2.58.12.17 1.76 2.68 4.26 3.76.6.26 1.06.41 1.42.53.6.19 1.15.16 1.58.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.17-.48-.3"/>
                                    </svg>
                                </template>
                                Konsultasi & Tanya Ketersediaan via WhatsApp
                            </BaseButton>
                        </div>
                    </div>
                </div>

                <!-- Related Products -->
                <div v-if="relatedProducts.length > 0" class="mt-16 pt-10 border-t border-slate-200 dark:border-slate-800">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                            Produk Terkait Lainnya
                        </h3>
                        <Link href="/produk" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline no-underline">
                            Lihat Semua Produk →
                        </Link>
                    </div>

                    <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-5">
                        <ProductCard
                            v-for="rp in relatedProducts"
                            :key="rp.id"
                            :product="rp"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
