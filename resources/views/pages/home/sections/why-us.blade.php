@php
    $beresValues = [
        [
            'letter' => 'B',
            'title' => 'Bersih & Presisi',
            'desc' => 'Mengerjakan setiap layanan dengan rapi, detail, dan akurat.',
            'color' => '#2563eb',
            'img' => asset('images/bersih.png')
        ],
        [
            'letter' => 'E',
            'title' => 'Efisien & Cepat',
            'desc' => 'Menghargai waktu pelanggan dan bekerja dengan ritme produktif.',
            'color' => '#2563eb',
            'img' => asset('images/efisien_dan_cepat.png')
        ],
        [
            'letter' => 'R',
            'title' => 'Ramah & Nyaman',
            'desc' => 'Melayani dengan sikap baik agar pelanggan merasa dihargai dan tenang.',
            'color' => '#2563eb',
            'img' => asset('images/ramah.png')
        ],
        [
            'letter' => 'E',
            'title' => 'Edukatif',
            'desc' => 'Membimbing pelanggan agar memahami kondisi kaca dan solusi yang tepat secara jujur dan jelas.',
            'color' => '#2563eb',
            'img' => asset('images/edukatif.png')
        ],
        [
            'letter' => 'S',
            'title' => 'Safety First',
            'desc' => 'Menjadikan keamanan dan keselamatan teknis operasional bagi karyawan dan pelanggan sebagai prioritas utama dalam setiap langkah kerja.',
            'color' => '#2563eb',
            'img' => asset('images/safety.png')
        ],
    ];
@endphp

<section class="py-24 bg-white dark:bg-slate-900 transition-colors">
    <div class="max-w-6xl mx-auto px-6">
        <!-- Header -->
        <div class="text-center mb-4">
            <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3 text-blue-600 dark:text-blue-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                KEUNGGULAN
            </div>
            <h2 class="uppercase mb-3 text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 800; line-height: 1.05;">
                KENAPA HARUS <span class="text-blue-600 dark:text-blue-400">PILIH KAMI?</span>
            </h2>
            <div class="mb-12"></div>
        </div>

        <!-- Cards — baris 1: 3 card, baris 2: 2 card -->
        <div class="flex flex-col gap-5">
            <!-- Baris 1: 3 card -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                @foreach(array_slice($beresValues, 0, 3) as $v)
                    <div class="rounded-3xl flex flex-col overflow-hidden transition-all duration-300 bg-slate-50 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 hover:border-blue-400 dark:hover:border-blue-500 hover:-translate-y-1">
                        <div class="w-full overflow-hidden flex items-center justify-center bg-blue-50 dark:bg-slate-900" style="height: 280px;">
                            <img src="{{ $v['img'] }}" alt="{{ $v['title'] }}" loading="lazy" decoding="async" class="w-full h-full object-cover">
                        </div>
                        <div class="p-7 flex flex-col flex-1">
                            <h3 class="font-bold mb-3 leading-snug text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.1rem;">
                                {{ $v['title'] }}
                            </h3>
                            <p class="text-sm leading-relaxed text-slate-500 dark:text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $v['desc'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Baris 2: 2 card -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                @foreach(array_slice($beresValues, 3, 2) as $v)
                    <div class="rounded-3xl flex flex-col overflow-hidden transition-all duration-300 bg-slate-50 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 hover:border-blue-400 dark:hover:border-blue-500 hover:-translate-y-1">
                        <div class="w-full overflow-hidden flex items-center justify-center bg-blue-50 dark:bg-slate-900" style="height: 280px;">
                            <img src="{{ $v['img'] }}" alt="{{ $v['title'] }}" loading="lazy" decoding="async" class="w-full h-full object-cover">
                        </div>
                        <div class="p-7 flex flex-col flex-1">
                            <h3 class="font-bold mb-3 leading-snug text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.1rem;">
                                {{ $v['title'] }}
                            </h3>
                            <p class="text-sm leading-relaxed text-slate-500 dark:text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $v['desc'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
