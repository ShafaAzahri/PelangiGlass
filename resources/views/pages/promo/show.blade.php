@extends('layouts.app')

@section('content')

<div class="pt-[76px] md:pt-[88px] bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen transition-colors" x-data="{
    copied: false,
    code: '{{ $promo['code'] }}',
    copyCode() {
        navigator.clipboard.writeText(this.code);
        this.copied = true;
        setTimeout(() => this.copied = false, 2000);
    }
}">
    <section class="py-12 sm:py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-8" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                <a href="{{ url('/') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition no-underline text-slate-500 dark:text-slate-400">Beranda</a>
                <span>/</span>
                <a href="{{ url('/promo') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition no-underline text-slate-500 dark:text-slate-400">Promo Spesial</a>
                <span>/</span>
                <span class="text-slate-700 dark:text-slate-200 truncate max-w-xs">{{ $promo['name'] }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
                <!-- Promo Image -->
                <div class="lg:col-span-6 space-y-4">
                    <div class="rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm relative">
                        <img src="{{ $promo['img'] }}" alt="{{ $promo['name'] }}" loading="lazy" decoding="async" class="w-full h-80 sm:h-96 object-cover">
                        @if (!empty($promo['badge']))
                            <x-badge :type="$promo['badge']" class="absolute top-4 left-4 text-xs px-3 py-1 shadow-md" />
                        @endif
                    </div>

                    <!-- Voucher Code Box -->
                    <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-0.5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                Kode Voucher Promo:
                            </span>
                            <span class="text-base font-bold font-mono text-slate-900 dark:text-slate-100">
                                {{ $promo['code'] }}
                            </span>
                            <span class="text-[11px] text-slate-400 block mt-0.5">
                                Berlaku s/d {{ $promo['valid_until'] }}
                            </span>
                        </div>
                        <button type="button" @click="copyCode()" class="px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 hover:border-blue-500 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 transition flex items-center gap-1.5 cursor-pointer" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            <span x-show="!copied">Salin Kode</span>
                            <span x-show="copied" style="display: none;" class="text-emerald-600 dark:text-emerald-400 font-bold">Tersalin!</span>
                        </button>
                    </div>
                </div>

                <!-- Promo Info -->
                <div class="lg:col-span-6 space-y-6">
                    <div>
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider block mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ $promo['category'] }}
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-slate-100 leading-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ $promo['name'] }}
                        </h1>
                        <div class="mt-4 flex items-baseline gap-3 flex-wrap">
                            <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">
                                Harga Promo:
                            </span>
                            <span class="text-2xl font-black text-red-600" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $promo['promo_price'] }}
                            </span>
                            <span class="text-sm text-slate-400 line-through" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $promo['original_price'] }}
                            </span>
                            <span class="px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-700">
                                Hemat {{ $promo['discount_percent'] }}
                            </span>
                        </div>
                    </div>

                    @if (!empty($promo['vehicle_compatibility']))
                        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                Kesesuaian Kendaraan:
                            </span>
                            <div class="text-sm font-semibold text-slate-800 dark:text-slate-200" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $promo['vehicle_compatibility'] }}
                            </div>
                        </div>
                    @endif

                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed text-justify" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ $promo['desc'] }}
                    </p>

                    @if (!empty($promo['benefits']))
                        <div class="space-y-2">
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider block" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                Detail Paket:
                            </span>
                            <ul class="space-y-1.5 text-xs text-slate-600 dark:text-slate-400">
                                @foreach ($promo['benefits'] as $b)
                                    <li class="flex items-start gap-2">
                                        <span class="text-blue-600 font-bold">•</span>
                                        <span>{{ $b }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="pt-4 border-t border-slate-200 dark:border-slate-800">
                        <x-whatsapp-button :text="'Halo Pelangi Glass, saya ingin klaim ' . $promo['name'] . ' (Kode: ' . $promo['code'] . ')'" label="Klaim Promo via WhatsApp" class="w-full py-4 text-sm font-bold rounded-xl shadow-md" />
                    </div>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-slate-200 dark:border-slate-800">
                <a href="{{ url('/promo') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition no-underline" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    ← Kembali ke Katalog Promo
                </a>
            </div>
        </div>
    </section>
</div>

@endsection
