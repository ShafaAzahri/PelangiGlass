@extends('layouts.app', ['title' => $product->name . ' - Pelangi Glass'])

@section('content')

    <div class="pt-[76px] md:pt-[88px] bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen transition-colors">
        <section class="py-12 sm:py-16">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-2 text-xs text-slate-400 mb-8" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    <a href="{{ url('/') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition no-underline text-slate-500 dark:text-slate-400">Beranda</a>
                    <span>/</span>
                    <a href="{{ url('/produk') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition no-underline text-slate-500 dark:text-slate-400">Katalog Produk</a>
                    <span>/</span>
                    <span class="text-slate-700 dark:text-slate-200 truncate max-w-xs">{{ $product->name }}</span>
                </nav>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
                    <!-- Product Image -->
                    <div class="lg:col-span-6 space-y-4">
                        <div class="rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm relative">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy" decoding="async" class="w-full h-80 sm:h-96 object-cover">
                            @if($product->badge)
                                <x-badge :type="$product->badge->value" class="absolute top-4 left-4 text-xs px-3 py-1 shadow-md" />
                            @endif
                        </div>
                    </div>

                    <!-- Product Information -->
                    <div class="lg:col-span-6 space-y-6">
                        <div>
                            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider block mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $product->category->name }}
                            </span>
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-slate-100 leading-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $product->name }}
                            </h1>
                            @if($product->vehicle_compatibility)
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mt-2 flex items-center gap-1.5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                    <i data-lucide="car" class="w-4 h-4 text-slate-400"></i>
                                    Kompatibilitas: {{ $product->vehicle_compatibility }}
                                </p>
                            @endif
                        </div>

                        <!-- Price Card -->
                        <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 space-y-1">
                            <span class="text-xs text-slate-400 block" style="font-family: 'Plus Jakarta Sans', sans-serif;">Estimasi Biaya / Harga Produk:</span>
                            <div class="text-2xl font-black text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $product->estimated_price ? 'Rp ' . number_format($product->estimated_price, 0, ',', '.') : 'Tanya via WhatsApp' }}
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">* Harga dapat bervariasi sesuai tipe dan tahun kendaraan Anda.</p>
                        </div>

                        <!-- Descriptions -->
                        <div class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed space-y-4 border-t border-slate-200 dark:border-slate-800 pt-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            <h4 class="font-bold text-slate-800 dark:text-slate-200 text-sm">Deskripsi & Spesifikasi Produk:</h4>
                            {!! $product->full_description ?? '<p>' . e($product->short_description) . '</p>' !!}
                        </div>

                        <!-- Action Button -->
                        <div class="pt-4 border-t border-slate-200 dark:border-slate-800">
                            <x-whatsapp-button :text="'Halo Pelangi Glass, saya ingin tanya ketersediaan stok & harga untuk ' . $product->name" label="Tanya Harga via WhatsApp" class="w-full py-4 text-sm font-bold rounded-xl shadow-md" />
                        </div>
                    </div>
                </div>

                <!-- Produk Terkait -->
                @if(isset($relatedProducts) && $relatedProducts->count() > 0)
                    <div class="mt-16 pt-10 border-t border-slate-200 dark:border-slate-800">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                Produk Terkait Lainnya
                            </h3>
                            <a href="{{ url('/produk') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition no-underline" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                Lihat Semua Produk →
                            </a>
                        </div>

                        <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-5">
                            @foreach($relatedProducts as $rp)
                                <a href="{{ url('/produk/' . $rp->slug) }}" class="rounded-2xl overflow-hidden flex flex-col transition-all duration-300 group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-blue-300 dark:hover:border-blue-700 hover:-translate-y-1 hover:shadow-md no-underline">
                                    <div class="overflow-hidden shrink-0 relative" style="height: 140px;">
                                        <img src="{{ $rp->image_url }}" alt="{{ $rp->name }}" loading="lazy" decoding="async" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                        @if($rp->badge)
                                            <x-badge :type="$rp->badge->value" class="absolute top-2 left-2 text-[10px] px-2 py-0.5 shadow-xs" />
                                        @endif
                                    </div>
                                    <div class="p-4 flex flex-col flex-1">
                                        <div class="text-[11px] font-semibold text-blue-600 mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                            {{ $rp->category->name }}
                                        </div>
                                        <h4 class="font-bold text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition text-xs line-clamp-2 mb-1.5 leading-snug" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                            {{ $rp->name }}
                                        </h4>
                                        <div class="mt-auto text-xs font-bold text-blue-800 dark:text-blue-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                            {{ $rp->estimated_price ? 'Rp ' . number_format($rp->estimated_price, 0, ',', '.') : 'Hubungi Kami' }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Back button -->
                <div class="mt-10">
                    <a href="{{ url('/produk') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-blue-600 hover:text-blue-800 transition no-underline" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali ke Katalog Produk
                    </a>
                </div>
            </div>
        </section>
    </div>

@endsection
