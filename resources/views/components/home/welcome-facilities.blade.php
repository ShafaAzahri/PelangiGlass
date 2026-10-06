<section id="tentang" class="py-16 lg:py-20 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 transition-colors">
    <div class="max-w-7xl mx-auto px-6 sm:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
            <!-- Kolom Kiri: Visual Workshop Kaca Mobil -->
            <div class="lg:col-span-6 flex">
                <div class="w-full h-full min-h-[380px] sm:min-h-[440px] lg:min-h-[490px] rounded-2xl overflow-hidden shadow-lg border border-slate-200/80 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 flex">
                    <img src="{{ asset('images/workshop-illustration.jpg') }}" alt="Workshop Spesialis Kaca Mobil Pelangi Glass" loading="lazy" decoding="async" class="w-full h-full min-h-[380px] sm:min-h-[440px] lg:min-h-[490px] object-cover object-center block transition-transform duration-700 hover:scale-[1.02]">
                </div>
            </div>

            <!-- Kolom Kanan: Profil, Nilai Kepercayaan & Fasilitas -->
            <div class="lg:col-span-6">
                <!-- Eyebrow Spesialisasi -->
                <div class="flex flex-wrap items-center gap-2 mb-2.5">
                    <span class="text-xs font-bold tracking-wider text-blue-600 uppercase" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Spesialis Kaca Mobil Sejak 1992 • Purwokerto
                    </span>
                </div>

                <!-- Title Utama -->
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-slate-100 tracking-tight leading-tight mb-3" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Selamat Datang di<br class="hidden sm:inline" /> Pelangi Glass Purwokerto
                </h2>

                <!-- Tagline Elegan -->
                <p class="text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3.5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    {{ \App\Models\Setting::get('tagline', 'Pemasangan Presisi Kaca Mobil Original OEM & Kaca Film Bergaransi Resmi') }}
                </p>

                <!-- Narasi Ringkas & Berwibawa (Text Justify) -->
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-5 text-justify" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Selama lebih dari {{ $siteSettings['years_experience'] ?? \App\Models\Setting::get('years_experience', '30+') }} tahun, Pelangi Glass dipercaya melayani penggantian, pemasangan, dan perbaikan kaca untuk berbagai tipe dan merek mobil. Dikerjakan langsung oleh teknisi spesialis dengan standar lem sealant internasional anti-bocor serta estimasi biaya yang transparan.
                </p>

                <!-- 3 Key Stats Row -->
                <div class="grid grid-cols-3 gap-3 py-3.5 mb-5 border-y border-slate-100 dark:border-slate-800">
                    <div>
                        <div class="text-xl sm:text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ $siteSettings['years_experience'] ?? \App\Models\Setting::get('years_experience', '30+') }}</div>
                        <div class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">Tahun Pengalaman</div>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-black text-blue-600 dark:text-blue-400 tracking-tight">100%</div>
                        <div class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">Kaca Asli OEM</div>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">Semua</div>
                        <div class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">Merek & Tipe Mobil</div>
                    </div>
                </div>

                <!-- Fasilitas Ruang Tunggu Pelanggan -->
                <div class="mb-5">
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-2.5">
                        Fasilitas Ruang Tunggu Pelanggan
                    </span>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        <div class="flex items-center gap-2 py-2 px-2.5 rounded-lg bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700 text-slate-700 dark:text-slate-200 text-xs font-medium">
                            <i data-lucide="coffee" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 shrink-0"></i>
                            <span class="truncate text-[11px] sm:text-xs">Free Coffee & Teh</span>
                        </div>
                        <div class="flex items-center gap-2 py-2 px-2.5 rounded-lg bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700 text-slate-700 dark:text-slate-200 text-xs font-medium">
                            <i data-lucide="smartphone-charging" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 shrink-0"></i>
                            <span class="truncate text-[11px] sm:text-xs">Free Charging</span>
                        </div>
                        <div class="flex items-center gap-2 py-2 px-2.5 rounded-lg bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700 text-slate-700 dark:text-slate-200 text-xs font-medium">
                            <i data-lucide="glass-water" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 shrink-0"></i>
                            <span class="truncate text-[11px] sm:text-xs">Air Panas & Dingin</span>
                        </div>
                        <div class="flex items-center gap-2 py-2 px-2.5 rounded-lg bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700 text-slate-700 dark:text-slate-200 text-xs font-medium">
                            <i data-lucide="tv" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 shrink-0"></i>
                            <span class="truncate text-[11px] sm:text-xs">TV LED Hiburan</span>
                        </div>
                        <div class="flex items-center gap-2 py-2 px-2.5 rounded-lg bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700 text-slate-700 dark:text-slate-200 text-xs font-medium">
                            <i data-lucide="fan" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 shrink-0"></i>
                            <span class="truncate text-[11px] sm:text-xs">Kipas Angin</span>
                        </div>
                    </div>
                </div>

                <!-- Link ke Halaman Tentang -->
                <div>
                    <a href="{{ url('/tentang') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors uppercase tracking-wider no-underline">
                        Pelajari Profil Lengkap <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
