@props([
    'galleryItems' => null,
    'galleryCategories' => null,
])

@php
    $defaultGalleryItems = [
        ['cat' => 'Kaca Depan', 'img' => 'https://images.unsplash.com/photo-1618934116136-16d28f184b10?w=600&auto=format'],
        ['cat' => 'Workshop', 'img' => 'https://images.unsplash.com/photo-1708805282695-ef186db20192?w=600&auto=format'],
        ['cat' => 'Film Kaca', 'img' => 'https://images.unsplash.com/photo-1526459915562-c5ca724b1d02?w=600&auto=format'],
        ['cat' => 'Kaca Depan', 'img' => 'https://images.unsplash.com/photo-1608259243654-70c070e0f6ed?w=600&auto=format'],
        ['cat' => 'Aksesoris', 'img' => 'https://images.unsplash.com/photo-1651084296894-105edab05b26?w=600&auto=format'],
        ['cat' => 'Workshop', 'img' => 'https://images.unsplash.com/photo-1779599507365-1944b37b2980?w=600&auto=format'],
        ['cat' => 'Film Kaca', 'img' => 'https://images.unsplash.com/photo-1764428950296-be81c8decb97?w=600&auto=format'],
        ['cat' => 'Aksesoris', 'img' => 'https://images.unsplash.com/photo-1625047509248-ec889cbff17f?w=600&auto=format'],
        ['cat' => 'Workshop', 'img' => 'https://images.unsplash.com/photo-1615906655593-ad0386982a0f?w=600&auto=format'],
        ['cat' => 'Kaca Depan', 'img' => 'https://images.unsplash.com/photo-1761014586544-53fe5e1f1e25?w=600&auto=format'],
    ];
    $homeGalleryItems = (isset($galleryItems) && $galleryItems->count() > 0)
        ? $galleryItems->map(fn($g) => ['cat' => $g->category?->name ?? 'Workshop', 'img' => $g->image_url])->toArray()
        : $defaultGalleryItems;
    $homeGalleryCats = array_values(array_unique(array_merge(['Semua'], array_column($homeGalleryItems, 'cat'))));
@endphp

<section id="galeri" class="py-24 bg-slate-100 dark:bg-slate-950 transition-colors" x-data="{
    active: 'Semua',
    galleryCats: {{ json_encode($homeGalleryCats) }},
    items: {{ json_encode($homeGalleryItems) }},
    isPaused: false,
    speed: 0.85,
    pos: 0,
    resumeTimer: null,
    rafId: null,
    isDown: false,
    startX: 0,
    startScroll: 0,
    getDisplayItems() {
        const filtered = this.active === 'Semua' 
            ? this.items 
            : this.items.filter(item => item.cat === this.active);
        let list = filtered;
        while (list.length < 8) {
            list = [...list, ...filtered];
        }
        return [...list, ...list];
    },
    setCategory(cat) {
        this.active = cat;
        this.pos = 0;
        if (this.$refs.track) {
            this.$refs.track.scrollLeft = 0;
        }
    },
    init() {
        const track = this.$refs.track;
        if (!track) return;
        this.pos = track.scrollLeft;

        const step = () => {
            if (!this.isPaused && !this.isDown && track) {
                this.pos += this.speed;
                const half = track.scrollWidth / 2;
                if (half > 0 && this.pos >= half) {
                    this.pos -= half;
                    track.scrollLeft = this.pos;
                } else {
                    track.scrollLeft = this.pos;
                }
            }
            this.rafId = requestAnimationFrame(step);
        };
        this.rafId = requestAnimationFrame(step);
    },
    onScroll() {
        if ((this.isPaused || this.isDown) && this.$refs.track) {
            this.pos = this.$refs.track.scrollLeft;
        }
    },
    scroll(dir) {
        this.isPaused = true;
        const amount = dir === 'right' ? 320 : -320;
        if (this.$refs.track) {
            this.$refs.track.scrollBy({ left: amount, behavior: 'smooth' });
            setTimeout(() => {
                if (this.$refs.track) {
                    this.pos = this.$refs.track.scrollLeft;
                    const half = this.$refs.track.scrollWidth / 2;
                    if (half > 0) {
                        if (this.pos >= half) this.pos -= half;
                        if (this.pos < 0) this.pos += half;
                        this.$refs.track.scrollLeft = this.pos;
                    }
                }
            }, 400);
        }
        clearTimeout(this.resumeTimer);
        this.resumeTimer = setTimeout(() => {
            this.isPaused = false;
        }, 2500);
    },
    onMouseDown(e) {
        this.isDown = true;
        this.isPaused = true;
        this.startX = e.pageX - this.$refs.track.offsetLeft;
        this.startScroll = this.$refs.track.scrollLeft;
    },
    onMouseMove(e) {
        if (!this.isDown) return;
        e.preventDefault();
        const x = e.pageX - this.$refs.track.offsetLeft;
        const walk = (x - this.startX) * 1.5;
        this.$refs.track.scrollLeft = this.startScroll - walk;
        this.pos = this.$refs.track.scrollLeft;
    },
    onMouseUp() {
        if (this.isDown) {
            this.isDown = false;
            clearTimeout(this.resumeTimer);
            this.resumeTimer = setTimeout(() => {
                this.isPaused = false;
            }, 1500);
        }
    }
}">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex items-end justify-between mb-6">
            <div>
                <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3 text-blue-600 dark:text-blue-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Galeri
                </div>
                <h2 class="uppercase text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 800; line-height: 1.05;">
                    Hasil Pengerjaan Kami
                </h2>
            </div>
            <div class="hidden sm:flex gap-2">
                <button @click="scroll('left')" class="w-10 h-10 rounded-full flex items-center justify-center transition-all cursor-pointer bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white hover:border-blue-600 dark:hover:border-blue-600" aria-label="Sebelumnya">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                </button>
                <button @click="scroll('right')" class="w-10 h-10 rounded-full flex items-center justify-center transition-all cursor-pointer bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white hover:border-blue-600 dark:hover:border-blue-600" aria-label="Berikutnya">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                </button>
            </div>
        </div>

        <!-- Filter tabs -->
        <div class="flex flex-wrap gap-2.5 mb-8">
            <template x-for="c in galleryCats" :key="c">
                <button @click="setCategory(c)" :class="active === c ? 'bg-blue-600 text-white border-blue-600 shadow-md' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700'" class="px-5 py-2 rounded-full text-xs font-semibold uppercase tracking-wider transition-all cursor-pointer border" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="c"></button>
            </template>
        </div>
    </div>

    <!-- Horizontal scroll strip with continuous motion -->
    <div 
        x-ref="track" 
        class="flex gap-3 cursor-grab active:cursor-grabbing select-none no-scrollbar px-6" 
        style="overflow-x: auto; scroll-behavior: auto;"
        @mouseenter="isPaused = true"
        @mouseleave="if (!isDown) isPaused = false"
        @touchstart="isPaused = true"
        @touchend="clearTimeout(resumeTimer); resumeTimer = setTimeout(() => isPaused = false, 1500)"
        @mousedown="onMouseDown($event)"
        @mousemove="onMouseMove($event)"
        @mouseup="onMouseUp()"
        @mouseleave.self="onMouseUp()"
        @scroll="onScroll()"
    >
        <template x-for="(g, i) in getDisplayItems()" :key="i">
            <div class="relative flex-none rounded-2xl overflow-hidden group" style="width: 300px; height: 400px; box-shadow: 0 2px 10px rgba(15,23,42,0.1);">
                <img :src="g.img" :alt="g.cat" draggable="false" loading="lazy" decoding="async" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 pointer-events-none">
                <div class="absolute inset-0 flex items-end p-4 pointer-events-none" style="background: linear-gradient(to top, rgba(15,23,42,0.65) 0%, transparent 55%);">
                    <span class="text-xs font-semibold uppercase tracking-wider text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="g.cat"></span>
                </div>
            </div>
        </template>
    </div>
</section>
