@props([
    'banners' => null,
])

@php
    $bannerList = (isset($banners) && $banners->count() > 0)
        ? $banners->map(function ($b) {
            $rawUrl = $b->button_url;
            if ($rawUrl && !str_starts_with($rawUrl, '/') && !str_starts_with($rawUrl, '#') && !str_starts_with($rawUrl, 'http://') && !str_starts_with($rawUrl, 'https://')) {
                $rawUrl = 'https://' . $rawUrl;
            }
            return [
                'img' => $b->image_url,
                'alt' => $b->title ?? 'Pelangi Glass Banner',
                'url' => $rawUrl,
                'title' => $b->title,
            ];
        })->toArray()
        : [
            ['img' => asset('images/banner1.png'), 'alt' => 'Kaca Mobil Jernih Perjalanan Lebih Aman', 'url' => url('/servis'), 'title' => 'Kaca Mobil Jernih Perjalanan Lebih Aman'],
            ['img' => asset('images/banner2.png'), 'alt' => 'Pelayanan Cepat, Rapi & Standar Pabrik', 'url' => url('/#kontak'), 'title' => 'Pelayanan Cepat, Rapi & Standar Pabrik'],
        ];
    $totalBanners = count($bannerList);
@endphp

<style>
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

<section id="beranda" class="relative overflow-hidden pt-[72px] sm:pt-[74px] bg-white dark:bg-slate-950 transition-colors" x-data="{
    current: 0,
    total: {{ $totalBanners }},
    isPaused: false,
    timer: null,
    startTimer() {
        this.stopTimer();
        this.timer = setInterval(() => {
            if (!this.isPaused) {
                this.next();
            }
        }, 5000);
    },
    stopTimer() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
    },
    next() {
        this.current = (this.current + 1) % this.total;
    },
    prev() {
        this.current = (this.current - 1 + this.total) % this.total;
        this.startTimer();
    },
    goTo(idx) {
        this.current = idx;
        this.startTimer();
    },
    init() {
        this.startTimer();
    }
}"
@mouseenter="isPaused = true"
@mouseleave="isPaused = false"
>
    <!-- Banner Container with Sizer and Smooth Crossfade -->
    <div class="relative w-full overflow-hidden">
        <!-- Natural sizer image keeping container height 1:1 on all viewports without layout shift -->
        <img 
            src="{{ $bannerList[0]['img'] }}" 
            alt="{{ $bannerList[0]['alt'] }}" 
            class="w-full h-auto block invisible pointer-events-none select-none" 
            aria-hidden="true"
            loading="eager"
            fetchpriority="high"
        >

        <!-- Stacked Slides for Soft Dissolve Crossfade -->
        @foreach($bannerList as $index => $slide)
            @php
                $slideUrl = $slide['url'] ?? null;
                $isExternal = $slideUrl && (str_starts_with($slideUrl, 'http://') || str_starts_with($slideUrl, 'https://'));
            @endphp
            <div 
                class="absolute inset-0 w-full h-full overflow-hidden"
                :class="current === {{ $index }} ? 'pointer-events-auto' : 'pointer-events-none'"
                :style="{
                    opacity: current === {{ $index }} ? 1 : 0,
                    zIndex: current === {{ $index }} ? 10 : 1
                }"
                style="{{ $index === 0 ? 'opacity: 1; z-index: 10;' : 'opacity: 0; z-index: 1;' }} transition: opacity 1200ms cubic-bezier(0.4, 0, 0.2, 1);"
            >
                @if($slideUrl)
                    <a href="{{ $slideUrl }}"
                       @if($isExternal) target="_blank" rel="noopener noreferrer" @endif
                       class="block w-full h-full cursor-pointer select-none group"
                       title="{{ $slide['alt'] }}">
                        <img 
                            src="{{ $slide['img'] }}" 
                            alt="{{ $slide['alt'] }}" 
                            class="w-full h-full object-cover object-center block transition-transform duration-700 group-hover:scale-[1.01]"
                            {{ $index === 0 ? 'loading="eager" fetchpriority="high"' : 'loading="lazy" decoding="async"' }}
                        >
                    </a>
                @else
                    <img 
                        src="{{ $slide['img'] }}" 
                        alt="{{ $slide['alt'] }}" 
                        class="w-full h-full object-cover object-center block"
                        {{ $index === 0 ? 'loading="eager" fetchpriority="high"' : 'loading="lazy" decoding="async"' }}
                    >
                @endif
            </div>
        @endforeach

        <!-- Left arrow (Next/Previous Navigation) -->
        <button 
            @click.stop="prev()" 
            type="button"
            aria-label="Slide sebelumnya"
            class="cursor-pointer transition-all hover:scale-110 active:scale-95"
            style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); z-index: 50; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border-radius: 9999px; background: rgba(15, 23, 42, 0.7); border: 1.5px solid rgba(255, 255, 255, 0.4); color: #ffffff; backdrop-filter: blur(8px); box-shadow: 0 4px 14px rgba(0, 0, 0, 0.4);"
            onmouseenter="this.style.background='#2563eb'; this.style.borderColor='#60a5fa';"
            onmouseleave="this.style.background='rgba(15, 23, 42, 0.7)'; this.style.borderColor='rgba(255, 255, 255, 0.4)';"
        >
            <svg style="width: 24px; height: 24px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </button>

        <!-- Right arrow (Next/Previous Navigation) -->
        <button 
            @click.stop="next()" 
            type="button"
            aria-label="Slide berikutnya"
            class="cursor-pointer transition-all hover:scale-110 active:scale-95"
            style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); z-index: 50; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border-radius: 9999px; background: rgba(15, 23, 42, 0.7); border: 1.5px solid rgba(255, 255, 255, 0.4); color: #ffffff; backdrop-filter: blur(8px); box-shadow: 0 4px 14px rgba(0, 0, 0, 0.4);"
            onmouseenter="this.style.background='#2563eb'; this.style.borderColor='#60a5fa';"
            onmouseleave="this.style.background='rgba(15, 23, 42, 0.7)'; this.style.borderColor='rgba(255, 255, 255, 0.4)';"
        >
            <svg style="width: 24px; height: 24px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </button>

        <!-- Dot indicators with built-in timer progress bar -->
        <div style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); z-index: 50; display: flex; align-items: center; gap: 10px;">
            @foreach($bannerList as $index => $slide)
                <button 
                    @click.stop="goTo({{ $index }})" 
                    type="button"
                    class="transition-all cursor-pointer p-0 border-0 overflow-hidden relative" 
                    :style="current === {{ $index }} 
                        ? 'width: 52px; height: 8px; border-radius: 9999px; background: rgba(255, 255, 255, 0.35); box-shadow: 0 2px 8px rgba(0,0,0,0.3);' 
                        : 'width: 12px; height: 8px; border-radius: 9999px; background: rgba(255, 255, 255, 0.5);'" 
                    aria-label="Pilih slide {{ $index + 1 }}"
                >
                    <template x-if="current === {{ $index }}">
                        <div 
                            :key="current"
                            class="hero-progress-animate w-full h-full"
                            style="height: 100%; width: 100%; border-radius: 9999px; background: #2563eb; box-shadow: 0 0 8px rgba(37, 99, 235, 1);"
                            :style="{ animationPlayState: isPaused ? 'paused' : 'running' }"
                        ></div>
                    </template>
                </button>
            @endforeach
        </div>

        <!-- Horizontal Loading Progress Bar at bottom of banner -->
        <div style="position: absolute; bottom: 0; left: 0; width: 100%; height: 5px; z-index: 50; background: rgba(255, 255, 255, 0.3); backdrop-filter: blur(4px); overflow: hidden;">
            <div 
                :key="current"
                class="hero-progress-animate w-full h-full"
                style="height: 100%; width: 100%; background: linear-gradient(90deg, #2563eb 0%, #38bdf8 80%, #ffffff 100%); box-shadow: 0 0 10px rgba(56, 189, 248, 0.9);"
                :style="{ animationPlayState: isPaused ? 'paused' : 'running' }"
            ></div>
        </div>
    </div>
</section>
