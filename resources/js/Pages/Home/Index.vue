<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import HeroSlider from '@/Components/Home/HeroSlider.vue';
import WelcomeFacilities from '@/Components/Home/WelcomeFacilities.vue';
import ServiceSection from '@/Components/Home/ServiceSection.vue';
import WhyUsSection from '@/Components/Home/WhyUsSection.vue';
import GallerySection from '@/Components/Home/GallerySection.vue';
import TestimonialSection from '@/Components/Home/TestimonialSection.vue';
import ArticlePreviewSection from '@/Components/Home/ArticlePreviewSection.vue';
import FaqSection from '@/Components/Home/FaqSection.vue';
import ContactSection from '@/Components/Home/ContactSection.vue';

defineProps({
    banners: { type: Array, default: () => [] },
    featuredServices: { type: Array, default: () => [] },
    galleryCategories: { type: Array, default: () => [] },
    galleryItems: { type: Array, default: () => [] },
    testimonials: { type: Array, default: () => [] },
    articles: { type: Array, default: () => [] },
    faqs: { type: Array, default: () => [] },
    products: { type: Array, default: () => [] },
});
</script>

<template>
    <AppLayout>
        <Head title="Spesialis Kaca Mobil & Kaca Film Resmi Purwokerto">
            <meta name="description" content="Pusat spesialis instalasi kaca mobil dan kaca film berkualitas OEM di Purwokerto sejak 1992. Menghadirkan presisi, ketahanan, dan standar keselamatan berkendara terbaik." />
        </Head>

        <!-- 1. Hero Slider Banner -->
        <HeroSlider :banners="banners" />

        <!-- 2. Profil & Fasilitas Workshop -->
        <WelcomeFacilities />

        <!-- 3. Layanan Unggulan -->
        <ServiceSection :featuredServices="featuredServices" />

        <!-- 4. Keunggulan Nilai B-E-R-E-S -->
        <WhyUsSection />

        <!-- 5. Galeri Pengerjaan Portofolio -->
        <GallerySection :galleryItems="galleryItems" :galleryCategories="galleryCategories" />

        <!-- 6. Testimoni Pelanggan -->
        <TestimonialSection :testimonials="testimonials" />

        <!-- 7. Artikel & Edukasi Tips -->
        <ArticlePreviewSection :articles="articles" />

        <!-- 8. FAQ Tanya Jawab -->
        <FaqSection :faqs="faqs" />

        <!-- 9. Form Kontak & Lokasi Workshop -->
        <ContactSection />
    </AppLayout>
</template>
