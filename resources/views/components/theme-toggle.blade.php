@props([
    'class' => '',
])

<div x-data="{
    isDark: document.documentElement.classList.contains('dark'),
    toggle() {
        const performToggle = () => {
            this.isDark = !this.isDark;
            if (this.isDark) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { dark: this.isDark } }));
        };

        // If browser supports View Transitions API, animate with slide effect
        if (typeof document.startViewTransition === 'function' && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.documentElement.dataset.themeTransition = this.isDark ? 'to-light' : 'to-dark';
            const transition = document.startViewTransition(() => {
                performToggle();
            });
            transition.finished.finally(() => {
                delete document.documentElement.dataset.themeTransition;
            });
        } else {
            performToggle();
        }
    },
    init() {
        this.isDark = document.documentElement.classList.contains('dark');
        window.addEventListener('storage', (e) => {
            if (e.key === 'theme') {
                this.isDark = e.newValue === 'dark';
                document.documentElement.classList.toggle('dark', this.isDark);
            }
        });
    }
}" class="inline-flex items-center select-none {{ $class }}">
    <!-- Sliding Capsule Switch -->
    <button 
        type="button" 
        @click="toggle()" 
        class="relative w-[54px] h-[28px] rounded-full p-[2px] cursor-pointer transition-all duration-300 ease-in-out border flex items-center shadow-inner focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
        :class="isDark 
            ? 'bg-slate-800 border-slate-700 shadow-slate-950/50' 
            : 'bg-sky-100 border-sky-200/90 shadow-sky-200/50'"
        :title="isDark ? 'Beralih ke mode terang (slide ke kiri)' : 'Beralih ke mode gelap (slide ke kanan)'"
        aria-label="Toggle theme"
    >
        <!-- Background track icons -->
        <div class="absolute inset-0 flex items-center justify-between px-2 pointer-events-none text-[11px] leading-none">
            <!-- Left Sun Symbol (shown when light) -->
            <span class="text-amber-500 transition-opacity duration-200" :class="!isDark ? 'opacity-90' : 'opacity-20'">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="4"></circle>
                    <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"></path>
                </svg>
            </span>
            <!-- Right Moon Symbol (shown when dark) -->
            <span class="text-indigo-300 transition-opacity duration-200" :class="isDark ? 'opacity-90' : 'opacity-20'">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
                </svg>
            </span>
        </div>

        <!-- Sliding Knob (Slides smoothly left & right) -->
        <span 
            class="relative z-10 w-[22px] h-[22px] rounded-full shadow-md flex items-center justify-center transition-all duration-300 cubic-bezier(0.34, 1.56, 0.64, 1) transform"
            :class="isDark 
                ? 'translate-x-[26px] bg-slate-950 text-blue-400 border border-slate-700 shadow-slate-950/80 rotate-[360deg]' 
                : 'translate-x-0 bg-white text-amber-500 border border-slate-200 shadow-slate-400/30 rotate-0'"
        >
            <!-- Sun inside knob (light mode) -->
            <span x-show="!isDark" class="flex items-center justify-center">
                <svg class="w-3.5 h-3.5 fill-amber-400 text-amber-500" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="4" fill="currentColor"></circle>
                    <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"></path>
                </svg>
            </span>

            <!-- Moon inside knob (dark mode) -->
            <span x-show="isDark" style="display: none;" class="flex items-center justify-center">
                <svg class="w-3 h-3 fill-blue-400 text-blue-300" viewBox="0 0 24 24">
                    <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
                </svg>
            </span>
        </span>
    </button>
</div>
