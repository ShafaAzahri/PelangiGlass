@extends('layouts.app')

@section('content')

<div class="min-h-screen pt-[76px] md:pt-[88px] bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors" x-data="{
    active: 'Semua',
    search: '',
    categories: {{ json_encode($categories) }},
    promos: {{ json_encode($promos) }},
    limit: 8,
    pageSize: 8,
    get filtered() {
        return this.promos.filter(p => {
            const matchCat = this.active === 'Semua' || p.category === this.active;
            const s = this.search.toLowerCase();
            const matchSearch = !s || p.name.toLowerCase().includes(s) ||
                (p.vehicle_compatibility && p.vehicle_compatibility.toLowerCase().includes(s)) ||
                (p.code && p.code.toLowerCase().includes(s)) ||
                (p.desc && p.desc.toLowerCase().includes(s));
            return matchCat && matchSearch;
        });
    },
    get visiblePromos() {
        return this.filtered.slice(0, this.limit);
    },
    get hasMore() {
        return this.visiblePromos.length < this.filtered.length;
    },
    loadMore() {
        if (this.hasMore) {
            this.limit += this.pageSize;
        }
    },
    filterCategory(c) {
        this.active = c;
        this.limit = this.pageSize;
    }
}">
    <div class="max-w-6xl mx-auto px-6 py-12">
        <!-- Search + Filter -->
        <div class="flex flex-col sm:flex-row gap-4 mb-10">
            <div class="relative flex-1 max-w-xs">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" placeholder="Cari promo atau kode voucher..." x-model="search" @input="limit = pageSize" class="w-full pl-9 pr-4 py-2.5 rounded-xl text-sm outline-none transition-all bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-blue-600 dark:focus:border-blue-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            </div>
            <div class="flex gap-2 flex-wrap">
                <template x-for="c in categories" :key="c">
                    <button @click="filterCategory(c)" :class="active === c ? 'bg-blue-600 text-white border border-blue-600 shadow-xs' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700'" class="px-4 py-2 rounded-full text-xs font-medium transition-all cursor-pointer" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="c"></button>
                </template>
            </div>
        </div>

        <!-- Grid Promos -->
        <template x-if="filtered.length === 0">
            <div class="text-center py-20 text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Promo tidak ditemukan.
            </div>
        </template>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 items-stretch" x-show="filtered.length > 0">
            <template x-for="promo in visiblePromos" :key="promo.id">
                <div class="rounded-2xl overflow-hidden transition-all duration-300 group flex flex-col h-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs hover:border-blue-300 dark:hover:border-blue-700 hover:-translate-y-1 hover:shadow-md">
                    <a :href="'/promo/' + (promo.slug || promo.id)" class="relative overflow-hidden block shrink-0" style="height: 180px;">
                        <img :src="promo.img" :alt="promo.name" loading="lazy" decoding="async" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <template x-if="promo.badge">
                            <div class="absolute top-0 left-0 z-10">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10.5px] font-extrabold uppercase tracking-wider text-white shadow-md rounded-br-xl select-none bg-gradient-to-r from-red-600 to-rose-600 shadow-rose-950/20"
                                      style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                    <svg class="w-3 h-3 fill-current text-white/95" viewBox="0 0 24 24"><path d="M12 2c.5 3 2 4.5 4 6 2.5 1.8 4 4.5 4 8a8 8 0 1 1-16 0c0-3.5 2-6.5 4.5-8.5C9.5 6 11 4.5 12 2z"/></svg>
                                    <span x-text="promo.badge"></span>
                                </span>
                            </div>
                        </template>
                    </a>
                    <div class="p-5 flex flex-col flex-1">
                        <div class="text-xs font-medium mb-1 text-blue-600" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="promo.category"></div>
                        <a :href="'/promo/' + (promo.slug || promo.id)" class="no-underline text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                            <h3 class="font-bold text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition text-[0.95rem] leading-[1.3] line-clamp-2 min-h-[2.5rem] mb-1.5" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="promo.name"></h3>
                        </a>
                        <div class="min-h-[1.75rem] flex items-center gap-2 flex-wrap mb-2">
                            <span class="text-xs font-bold text-red-600" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="promo.promo_price"></span>
                            <span class="text-[11px] text-slate-400 line-through" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="promo.original_price"></span>
                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-700" x-text="'-' + promo.discount_percent"></span>
                        </div>
                        <p class="text-xs leading-relaxed text-slate-500 dark:text-slate-400 line-clamp-2 min-h-[2.25rem] text-justify mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;" x-text="promo.desc"></p>
                        <a :href="'https://wa.me/{{ \App\Models\Setting::cleanWhatsapp() }}?text=Halo%20Pelangi%20Glass,%20saya%20ingin%20klaim%20' + encodeURIComponent(promo.name) + '%20(Kode:%20' + encodeURIComponent(promo.code) + ')'" target="_blank" rel="noopener noreferrer" class="mt-auto w-full flex items-center justify-center gap-1.5 py-2.5 rounded-xl text-xs font-semibold text-white transition-all hover:opacity-90 bg-blue-700 hover:bg-blue-800 no-underline" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            <x-icons.whatsapp class="w-3.5 h-3.5 shrink-0" />
                            <span>Klaim Promo via WA</span>
                        </a>
                    </div>
                </div>
            </template>
        </div>

        <!-- Lazy Loading Sentinel (x-intersect) -->
        <div x-show="hasMore" x-intersect.margin.200px="loadMore()" class="py-8 text-center">
            <button @click="loadMore()" type="button" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-semibold shadow-xs transition active:scale-95 cursor-pointer" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                <i data-lucide="arrow-down" class="w-3.5 h-3.5"></i>
                <span>Tampilkan Lebih Banyak Promo</span>
            </button>
        </div>

        <!-- Bottom CTA Card -->
        <x-cta-card
            message="Promo yang Anda cari belum tersedia? Hubungi kami, kami siap berikan penawaran harga terbaik."
            button-label="Hubungi Kami"
            whatsapp-text="Halo Pelangi Glass, saya ingin konsultasi promo dan penawaran khusus kaca mobil."
        />
    </div>
</div>

@endsection
