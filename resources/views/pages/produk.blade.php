@extends('layouts.app')

@section('content')

    <!-- Header Banner -->
    <section class="bg-slate-950 text-white py-14 sm:py-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-2xl relative z-10">
            <span class="text-xs font-bold tracking-[0.2em] text-blue-400 uppercase">Katalog Resmi</span>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight mt-2 mb-3">
                Katalog Produk & Kaca Film
            </h1>
            <p class="text-slate-300 text-sm leading-relaxed">
                Pilihan kaca mobil original OEM, kaca film tolak panas kelas dunia, aksesoris karet seal, dan produk perawatan kaca terlengkap.
            </p>
        </div>
    </section>

    <!-- Content & Filter Section -->
    <section class="py-16 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter & Search Controls -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs mb-10 flex flex-col md:flex-row items-center justify-between gap-4">
                <!-- Tabs Kategori -->
                <div class="flex flex-wrap gap-2 w-full md:w-auto">
                    <a href="{{ route('products.index') }}" 
                       class="px-4 py-2 rounded-full text-xs font-semibold transition {{ !request('kategori') ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Semua Kategori
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('products.index', array_merge(request()->query(), ['kategori' => $cat->slug])) }}" 
                           class="px-4 py-2 rounded-full text-xs font-semibold transition {{ request('kategori') === $cat->slug ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>

                <!-- Search Input -->
                <form action="{{ route('products.index') }}" method="GET" class="w-full md:w-72 relative">
                    @if(request('kategori'))
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    @endif
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama produk / tipe mobil..." class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 focus:outline-none focus:border-blue-600 transition">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-2.5"></i>
                </form>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-xs hover:border-blue-300 hover:shadow-md transition flex flex-col justify-between group">
                            <div>
                                <!-- Image with Badge -->
                                <div class="relative h-48 overflow-hidden bg-slate-100">
                                    <img src="{{ $product->main_image ?? asset('images/logo.png') }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    @if($product->badge)
                                        <span class="absolute top-3 left-3 text-[11px] font-bold px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 border border-amber-200 shadow-xs">
                                            {{ $product->badge->value }}
                                        </span>
                                    @endif
                                </div>

                                <div class="p-5 space-y-2">
                                    <span class="text-xs font-bold text-blue-600 uppercase tracking-wider block">
                                        {{ $product->category->name }}
                                    </span>
                                    <h3 class="font-bold text-slate-900 text-sm sm:text-base leading-snug group-hover:text-blue-600 transition">
                                        {{ $product->name }}
                                    </h3>
                                    @if($product->vehicle_compatibility)
                                        <p class="text-[11px] font-semibold text-slate-500 flex items-center gap-1">
                                            <i data-lucide="car" class="w-3.5 h-3.5 text-slate-400"></i>
                                            {{ $product->vehicle_compatibility }}
                                        </p>
                                    @endif
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2 pt-1">
                                        {{ $product->short_description }}
                                    </p>
                                </div>
                            </div>

                            <div class="p-5 pt-0 border-t border-slate-100 mt-4 space-y-3">
                                <div class="flex items-center justify-between text-xs pt-3">
                                    <span class="text-slate-400">Estimasi Biaya:</span>
                                    <span class="font-bold text-slate-900">
                                        {{ $product->estimated_price ? 'Rp ' . number_format($product->estimated_price, 0, ',', '.') : 'Tanya via WA' }}
                                    </span>
                                </div>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp', '6281390288875')) }}?text={{ urlencode('Halo Pelangi Glass, saya ingin tanya harga dan ketersediaan ' . $product->name) }}" target="_blank" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-xl flex items-center justify-center gap-1.5 transition shadow-xs">
                                    <i data-lucide="message-circle" class="w-3.5 h-3.5"></i> Tanya via WhatsApp
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white p-12 rounded-3xl border border-slate-200 text-center max-w-md mx-auto space-y-4">
                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                        <i data-lucide="search-x" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Produk Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-500">Silakan gunakan kata kunci lain atau hubungi kami langsung via WhatsApp untuk pengecekan stok kaca mobil Anda.</p>
                    <a href="{{ route('products.index') }}" class="inline-block text-xs font-semibold text-blue-600 hover:underline">Reset Filter</a>
                </div>
            @endif
        </div>
    </section>

@endsection
