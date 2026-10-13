<script setup>
const beresValues = [
    {
        letter: 'B',
        title: 'Bersih & Presisi',
        desc: 'Mengerjakan setiap layanan dengan rapi, detail, dan akurat.',
        img: '/images/bersih.png',
    },
    {
        letter: 'E',
        title: 'Efisien & Cepat',
        desc: 'Menghargai waktu pelanggan dan bekerja dengan ritme produktif.',
        img: '/images/efisien_dan_cepat.png',
    },
    {
        letter: 'R',
        title: 'Ramah & Nyaman',
        desc: 'Melayani dengan sikap baik agar pelanggan merasa dihargai dan tenang.',
        img: '/images/ramah.png',
    },
    {
        letter: 'E',
        title: 'Edukatif',
        desc: 'Membimbing pelanggan agar memahami kondisi kaca dan solusi yang tepat secara jujur dan jelas.',
        img: '/images/edukatif.png',
    },
    {
        letter: 'S',
        title: 'Safety First',
        desc: 'Menjadikan keamanan dan keselamatan teknis operasional bagi karyawan dan pelanggan sebagai prioritas utama dalam setiap langkah kerja.',
        img: '/images/safety.png',
    },
];
</script>

<template>
    <section class="py-24 bg-white dark:bg-slate-900 transition-colors">
        <div class="max-w-6xl mx-auto px-6">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3 text-blue-600 dark:text-blue-400">
                    KEUNGGULAN
                </div>
                <h2 class="uppercase mb-3 text-slate-900 dark:text-slate-100 text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight tracking-tight">
                    KENAPA HARUS <span class="text-blue-600 dark:text-blue-400">PILIH KAMI?</span>
                </h2>
            </div>

            <!-- Cards -->
            <div class="flex flex-col gap-5">
                <!-- Baris 1: 3 card -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div
                        v-for="(v, idx) in beresValues.slice(0, 3)"
                        :key="idx"
                        class="rounded-3xl flex flex-col overflow-hidden transition-all duration-300 bg-slate-50 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 hover:border-blue-400 dark:hover:border-blue-500 hover:-translate-y-1"
                    >
                        <div class="w-full overflow-hidden flex items-center justify-center bg-blue-50 dark:bg-slate-900 h-[280px]">
                            <img :src="v.img" :alt="v.title" loading="lazy" decoding="async" class="w-full h-full object-cover">
                        </div>
                        <div class="p-7 flex flex-col flex-1">
                            <h3 class="font-bold mb-3 leading-snug text-slate-900 dark:text-slate-100 text-lg">
                                {{ v.title }}
                            </h3>
                            <p class="text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                                {{ v.desc }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Baris 2: 2 card -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div
                        v-for="(v, idx) in beresValues.slice(3, 5)"
                        :key="idx"
                        class="rounded-3xl flex flex-col overflow-hidden transition-all duration-300 bg-slate-50 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 hover:border-blue-400 dark:hover:border-blue-500 hover:-translate-y-1"
                    >
                        <div class="w-full overflow-hidden flex items-center justify-center bg-blue-50 dark:bg-slate-900 h-[280px]">
                            <img :src="v.img" :alt="v.title" loading="lazy" decoding="async" class="w-full h-full object-cover">
                        </div>
                        <div class="p-7 flex flex-col flex-1">
                            <h3 class="font-bold mb-3 leading-snug text-slate-900 dark:text-slate-100 text-lg">
                                {{ v.title }}
                            </h3>
                            <p class="text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                                {{ v.desc }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
