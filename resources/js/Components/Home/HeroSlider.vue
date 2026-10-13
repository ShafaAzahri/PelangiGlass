<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    banners: {
        type: Array,
        default: () => [],
    },
});

const defaultBanners = [
    { img: '/images/banner1.png', alt: 'Kaca Mobil Jernih Perjalanan Lebih Aman', url: '/servis', title: 'Kaca Mobil Jernih Perjalanan Lebih Aman' },
    { img: '/images/banner2.png', alt: 'Pelayanan Cepat, Rapi & Standar Pabrik', url: '/#kontak', title: 'Pelayanan Cepat, Rapi & Standar Pabrik' },
];

const bannerList = computed(() => {
    if (props.banners && props.banners.length > 0) {
        return props.banners.map((b) => {
            let rawUrl = b.button_url || null;
            if (rawUrl && !rawUrl.startsWith('/') && !rawUrl.startsWith('#') && !rawUrl.startsWith('http://') && !rawUrl.startsWith('https://')) {
                rawUrl = 'https://' + rawUrl;
            }
            let img = b.image_url;
            if (!img && b.image_path) {
                img = b.image_path.startsWith('http') ? b.image_path : `/storage/${b.image_path.replace(/^\/+/, '')}`;
            }
            if (!img) {
                img = '/images/banner1.png';
            }
            return {
                img,
                alt: b.title || 'Pelangi Glass Banner',
                url: rawUrl,
                title: b.title,
            };
        });
    }
    return defaultBanners;
});

const totalBanners = computed(() => bannerList.value.length);
const current = ref(0);
const isPaused = ref(false);
let timer = null;

const startTimer = () => {
    stopTimer();
    timer = setInterval(() => {
        if (!isPaused.value) {
            next();
        }
    }, 5000);
};

const stopTimer = () => {
    clearInterval(timer);
    timer = null;
};

const next = () => {
    if (totalBanners.value > 0) {
        current.value = (current.value + 1) % totalBanners.value;
    }
};

const prev = () => {
    if (totalBanners.value > 0) {
        current.value = (current.value - 1 + totalBanners.value) % totalBanners.value;
        startTimer();
    }
};

const goTo = (idx) => {
    current.value = idx;
    startTimer();
};

onMounted(() => {
    startTimer();
});

onUnmounted(() => {
    stopTimer();
});
</script>

<template>
    <section
        id="beranda"
        class="relative overflow-hidden bg-white dark:bg-slate-950 transition-colors"
        @mouseenter="isPaused = true"
        @mouseleave="isPaused = false"
    >
        <div class="relative w-full overflow-hidden min-h-[220px] sm:min-h-[320px] md:min-h-[420px]">
            <!-- Sizer image keeping ratio -->
            <img
                :src="bannerList[0]?.img || '/images/banner1.png'"
                :alt="bannerList[0]?.alt || 'Pelangi Glass Banner'"
                class="w-full h-auto block invisible pointer-events-none select-none"
                aria-hidden="true"
                loading="eager"
            >

            <!-- Slides with Crossfade -->
            <div
                v-for="(slide, index) in bannerList"
                :key="index"
                class="absolute inset-0 w-full h-full overflow-hidden transition-opacity duration-1000 ease-in-out"
                :class="current === index ? 'opacity-100 z-10 pointer-events-auto' : 'opacity-0 z-0 pointer-events-none'"
            >
                <a
                    v-if="slide.url"
                    :href="slide.url"
                    class="block w-full h-full cursor-pointer select-none group"
                    :title="slide.alt"
                >
                    <img
                        :src="slide.img"
                        :alt="slide.alt"
                        @error="$event.target.src = '/images/banner1.png'"
                        class="w-full h-full object-cover object-center block transition-transform duration-700 group-hover:scale-[1.01]"
                        :loading="index === 0 ? 'eager' : 'lazy'"
                    >
                </a>
                <img
                    v-else
                    :src="slide.img"
                    :alt="slide.alt"
                    @error="$event.target.src = '/images/banner1.png'"
                    class="w-full h-full object-cover object-center block"
                    :loading="index === 0 ? 'eager' : 'lazy'"
                >
            </div>

            <!-- Left arrow -->
            <button
                @click.stop="prev()"
                type="button"
                aria-label="Slide sebelumnya"
                class="absolute left-4 sm:left-6 top-1/2 -translate-y-1/2 z-20 w-10 sm:w-12 h-10 sm:h-12 flex items-center justify-center rounded-full bg-slate-900/70 hover:bg-blue-600 border border-white/40 text-white backdrop-blur-md shadow-lg transition-all duration-200 cursor-pointer hover:scale-110 active:scale-95"
            >
                <svg class="w-5 sm:w-6 h-5 sm:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
            </button>

            <!-- Right arrow -->
            <button
                @click.stop="next()"
                type="button"
                aria-label="Slide berikutnya"
                class="absolute right-4 sm:right-6 top-1/2 -translate-y-1/2 z-20 w-10 sm:w-12 h-10 sm:h-12 flex items-center justify-center rounded-full bg-slate-900/70 hover:bg-blue-600 border border-white/40 text-white backdrop-blur-md shadow-lg transition-all duration-200 cursor-pointer hover:scale-110 active:scale-95"
            >
                <svg class="w-5 sm:w-6 h-5 sm:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6"/>
                </svg>
            </button>

            <!-- Indicator Dots with Live Timer Progress Bar (matching Image #2) -->
            <div class="absolute bottom-5 left-1/2 -translate-x-1/2 z-30 flex items-center gap-2.5">
                <button
                    v-for="(slide, index) in bannerList"
                    :key="index"
                    @click.stop="goTo(index)"
                    type="button"
                    class="transition-all duration-300 cursor-pointer p-0 border-0 overflow-hidden relative"
                    :style="current === index
                        ? 'width: 52px; height: 8px; border-radius: 9999px; background: rgba(255, 255, 255, 0.35); box-shadow: 0 2px 8px rgba(0,0,0,0.3);'
                        : 'width: 12px; height: 8px; border-radius: 9999px; background: rgba(255, 255, 255, 0.5);'"
                    :aria-label="`Pilih slide ${index + 1}`"
                >
                    <div
                        v-if="current === index"
                        :key="current"
                        class="hero-progress-animate w-full h-full rounded-full bg-blue-600 shadow-[0_0_8px_rgba(37,99,235,1)]"
                        :style="{ animationPlayState: isPaused ? 'paused' : 'running' }"
                    ></div>
                </button>
            </div>

            <!-- Horizontal Bottom Loading Progress Bar (matching Image #2) -->
            <div class="absolute bottom-0 left-0 w-full h-[5px] z-30 bg-white/30 backdrop-blur-xs overflow-hidden">
                <div
                    :key="current"
                    class="hero-progress-animate w-full h-full"
                    style="background: linear-gradient(90deg, #2563eb 0%, #38bdf8 80%, #ffffff 100%); box-shadow: 0 0 10px rgba(56, 189, 248, 0.9);"
                    :style="{ animationPlayState: isPaused ? 'paused' : 'running' }"
                ></div>
            </div>
        </div>
    </section>
</template>

<style scoped>
@keyframes heroProgressBar {
    0% { transform: scaleX(0); }
    100% { transform: scaleX(1); }
}
.hero-progress-animate {
    transform-origin: 0% 50%;
    animation: heroProgressBar 5000ms linear forwards;
    will-change: transform;
}
</style>
