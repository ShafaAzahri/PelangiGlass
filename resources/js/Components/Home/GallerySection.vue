<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import BaseModal from '@/Components/UI/BaseModal.vue';

const props = defineProps({
    galleryItems: {
        type: Array,
        default: () => [],
    },
    galleryCategories: {
        type: Array,
        default: () => [],
    },
});

const defaultItems = [
    { cat: 'Kaca Depan', img: '/storage/gallery/avanza-gen-1.png' },
    { cat: 'Workshop', img: '/storage/gallery/bus-aneka-bintang.png' },
    { cat: 'Film Kaca', img: '/storage/gallery/brio-merah-s.png' },
    { cat: 'Kaca Depan', img: '/storage/gallery/innova.png' },
    { cat: 'Aksesoris', img: '/storage/gallery/granmax-belakang-4.png' },
    { cat: 'Workshop', img: '/storage/gallery/hino-dutro-putih.png' },
    { cat: 'Film Kaca', img: '/storage/gallery/crv-gen-3-s1.png' },
    { cat: 'Kaca Depan', img: '/storage/gallery/fortuner-gen-2.png' },
    { cat: 'Workshop', img: '/storage/gallery/isuzu-elf-4.png' },
    { cat: 'Film Kaca', img: '/storage/gallery/bmw-e-91.png' },
];

const items = computed(() => {
    if (props.galleryItems && props.galleryItems.length > 0) {
        return props.galleryItems.map((g) => ({
            cat: g.category?.name || 'Workshop',
            img: g.image_url,
        }));
    }
    return defaultItems;
});

const categories = computed(() => {
    const list = items.value.map((i) => i.cat);
    return ['Semua', ...new Set(list)];
});

const activeCategory = ref('Semua');
const trackRef = ref(null);
const isPaused = ref(false);
const isDown = ref(false);
const startX = ref(0);
const startScroll = ref(0);
let resumeTimer = null;
let rafId = null;
let pos = 0;
const speed = 0.85;

// Modal lightbox
const selectedImage = ref(null);

const filteredItems = computed(() => {
    if (activeCategory.value === 'Semua') {
        return items.value;
    }
    return items.value.filter((i) => i.cat === activeCategory.value);
});

const displayItems = computed(() => {
    const list = filteredItems.value;
    if (list.length === 0) return [];

    // Jika kategori bukan 'Semua', tampilkan list apa adanya tanpa looping/duplikasi
    if (activeCategory.value !== 'Semua') {
        return list;
    }

    // Jika 'Semua', buat looping tak terbatas
    let looped = list;
    while (looped.length < 8) {
        looped = [...looped, ...list];
    }
    return [...looped, ...looped];
});

const setCategory = (cat) => {
    activeCategory.value = cat;
    pos = 0;
    if (trackRef.value) {
        trackRef.value.scrollLeft = 0;
    }
};

const scroll = (direction) => {
    isPaused.value = true;
    const amount = direction === 'right' ? 320 : -320;
    if (trackRef.value) {
        trackRef.value.scrollBy({ left: amount, behavior: 'smooth' });
    }
    clearTimeout(resumeTimer);
    resumeTimer = setTimeout(() => {
        isPaused.value = false;
    }, 2500);
};

const onMouseDown = (e) => {
    isDown.value = true;
    isPaused.value = true;
    startX.value = e.pageX - (trackRef.value?.offsetLeft || 0);
    startScroll.value = trackRef.value?.scrollLeft || 0;
};

const onMouseMove = (e) => {
    if (!isDown.value || !trackRef.value) return;
    e.preventDefault();
    const x = e.pageX - (trackRef.value.offsetLeft || 0);
    const walk = (x - startX.value) * 1.5;
    trackRef.value.scrollLeft = startScroll.value - walk;
    pos = trackRef.value.scrollLeft;
};

const onMouseUp = () => {
    if (isDown.value) {
        isDown.value = false;
        clearTimeout(resumeTimer);
        resumeTimer = setTimeout(() => {
            isPaused.value = false;
        }, 1500);
    }
};

const handleMouseLeave = () => {
    if (!isDown.value) {
        isPaused.value = false;
    }
};

onMounted(() => {
    const track = trackRef.value;
    if (!track) return;

    const step = () => {
        if (!isPaused.value && !isDown.value && track) {
            // Hanya auto-scroll animasi jika kategori 'Semua'
            if (activeCategory.value === 'Semua') {
                pos += speed;
                const half = track.scrollWidth / 2;
                if (half > 0 && pos >= half) {
                    pos -= half;
                    track.scrollLeft = pos;
                } else {
                    track.scrollLeft = pos;
                }
            }
        }
        rafId = requestAnimationFrame(step);
    };
    rafId = requestAnimationFrame(step);
});

onUnmounted(() => {
    cancelAnimationFrame(rafId);
    clearTimeout(resumeTimer);
});
</script>

<template>
    <section id="galeri" class="py-24 bg-slate-100 dark:bg-slate-950 transition-colors">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex items-end justify-between mb-6">
                <div>
                    <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3 text-blue-600 dark:text-blue-400">
                        Galeri
                    </div>
                    <h2 class="uppercase text-slate-900 dark:text-slate-100 text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight tracking-tight">
                        Hasil Pengerjaan Kami
                    </h2>
                </div>
                <div class="hidden sm:flex gap-2">
                    <button
                        @click="scroll('left')"
                        class="w-10 h-10 rounded-full flex items-center justify-center transition-all cursor-pointer bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white hover:border-blue-600 dark:hover:border-blue-600"
                        aria-label="Sebelumnya"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                    </button>
                    <button
                        @click="scroll('right')"
                        class="w-10 h-10 rounded-full flex items-center justify-center transition-all cursor-pointer bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white hover:border-blue-600 dark:hover:border-blue-600"
                        aria-label="Berikutnya"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                    </button>
                </div>
            </div>

            <!-- Filter tabs -->
            <div class="flex flex-wrap gap-2.5 mb-8">
                <button
                    v-for="c in categories"
                    :key="c"
                    @click="setCategory(c)"
                    class="px-5 py-2 rounded-full text-xs font-semibold uppercase tracking-wider transition-all cursor-pointer border"
                    :class="activeCategory === c
                        ? 'bg-blue-600 text-white border-blue-600 shadow-md'
                        : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700'"
                >
                    {{ c }}
                </button>
            </div>
        </div>

        <!-- Horizontal scroll strip with continuous motion -->
        <div
            ref="trackRef"
            class="flex gap-3 cursor-grab active:cursor-grabbing select-none no-scrollbar px-6 overflow-x-auto"
            @mouseenter="isPaused = true"
            @mouseleave="handleMouseLeave"
            @mousedown="onMouseDown"
            @mousemove="onMouseMove"
            @mouseup="onMouseUp"
        >
            <div
                v-for="(g, i) in displayItems"
                :key="i"
                @click="selectedImage = g"
                class="relative flex-none rounded-2xl overflow-hidden group w-[300px] h-[400px] shadow-sm cursor-pointer"
            >
                <img
                    :src="g.img"
                    :alt="g.cat"
                    draggable="false"
                    loading="lazy"
                    decoding="async"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 pointer-events-none"
                >
                <div class="absolute inset-0 flex items-end p-4 pointer-events-none bg-gradient-to-t from-slate-950/70 via-transparent to-transparent">
                    <span class="text-xs font-semibold uppercase tracking-wider text-white">
                        {{ g.cat }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Image Lightbox Modal -->
        <BaseModal :show="!!selectedImage" maxWidth="4xl" @close="selectedImage = null">
            <div v-if="selectedImage" class="p-2 sm:p-4">
                <div class="flex items-center justify-between p-3 border-b border-slate-100 dark:border-slate-800 mb-2">
                    <span class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                        {{ selectedImage.cat }}
                    </span>
                    <button
                        @click="selectedImage = null"
                        class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 cursor-pointer"
                        aria-label="Tutup"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></svg>
                    </button>
                </div>
                <img :src="selectedImage.img" :alt="selectedImage.cat" class="w-full max-h-[75vh] object-contain rounded-xl">
            </div>
        </BaseModal>
    </section>
</template>
