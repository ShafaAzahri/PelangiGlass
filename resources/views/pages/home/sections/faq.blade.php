@props([
    'faqs' => null,
])

@php
    $defaultFaqs = [
        ['q' => 'Berapa lama proses penggantian kaca mobil?', 'a' => 'Umumnya 2–3 jam untuk kaca depan atau belakang. Untuk kaca samping bisa lebih cepat, sekitar 1–1,5 jam. Kami akan informasikan estimasi waktu yang lebih tepat setelah melihat kondisi kendaraan Anda.'],
        ['q' => 'Apakah ada garansi setelah penggantian kaca?', 'a' => 'Ya, kami memberikan garansi kebocoran 1 tahun untuk setiap penggantian kaca. Jika ada kebocoran dalam periode garansi, kami akan perbaiki tanpa biaya tambahan.'],
        ['q' => 'Merek kaca apa saja yang tersedia?', 'a' => 'Kami menyediakan kaca original OEM dan berbagai merek aftermarket berkualitas seperti Asahimas, AGC, Pilkington, dan lainnya. Pilihan disesuaikan dengan kebutuhan dan anggaran Anda.'],
        ['q' => 'Apakah bisa dipanggil ke lokasi (mobile service)?', 'a' => 'Untuk kondisi tertentu kami dapat melayani kunjungan ke lokasi di area Purwokerto dan sekitarnya. Hubungi kami via WhatsApp untuk konfirmasi ketersediaan dan area jangkauan.'],
        ['q' => 'Merek film kaca apa yang direkomendasikan?', 'a' => 'Kami merekomendasikan V-Kool, 3M, dan Solar Gard — merek premium dengan teknologi penolak panas dan UV terbaik. Semua dilengkapi garansi film 3–5 tahun dan sertifikat keaslian.'],
        ['q' => 'Apakah asuransi kendaraan bisa digunakan?', 'a' => 'Kami dapat membantu proses klaim asuransi untuk penggantian kaca. Bawa serta dokumen kendaraan dan polis asuransi Anda, tim kami akan membantu prosesnya.'],
    ];

    $faqsList = (isset($faqs) && $faqs->count() > 0)
        ? $faqs->map(fn($f) => ['q' => $f->question, 'a' => $f->answer])->toArray()
        : $defaultFaqs;
@endphp

<section class="py-24 bg-slate-50 dark:bg-slate-950 transition-colors" x-data="{ open: 0 }">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-20">
            <!-- Left — sticky label + heading -->
            <div class="lg:w-72 shrink-0">
                <div class="text-xs font-semibold tracking-[0.18em] uppercase mb-4 text-blue-600 dark:text-blue-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    FAQ
                </div>
                <h2 class="uppercase mb-5 text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(2rem, 4vw, 2.8rem); font-weight: 900; line-height: 1.05;">
                    Pertanyaan yang Sering Ditanyakan
                </h2>
                <p class="text-sm leading-relaxed text-slate-600 dark:text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    <a href="{{ \App\Models\Setting::whatsappUrl('Halo Pelangi Glass, saya ada pertanyaan mengenai kaca mobil / kaca film.') }}" target="_blank" rel="noopener noreferrer" style="color: #2563eb; font-weight: 600; text-decoration: none;">
                        Hubungi tim kami
                    </a>
                    via WhatsApp, kami siap membantu.
                </p>
            </div>

            <!-- Right — accordion card -->
            <div class="flex-1 rounded-2xl overflow-hidden bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
                @foreach($faqsList as $idx => $faq)
                    <div class="border-b border-slate-100 dark:border-slate-800 last:border-b-0">
                        <button class="w-full flex items-center justify-between gap-4 px-7 py-5 text-left bg-transparent border-0 cursor-pointer" @click="open = open === {{ $idx }} ? null : {{ $idx }}">
                            <span class="font-semibold text-sm text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $faq['q'] }}
                            </span>
                            <span class="shrink-0 w-7 h-7 rounded-full border flex items-center justify-center transition-all" :style="open === {{ $idx }} ? 'border-color: #2563eb; background: #2563eb;' : 'border-color: #e2e8f0; background: transparent;'">
                                <template x-if="open === {{ $idx }}">
                                    <svg width="10" height="2" viewBox="0 0 10 2" fill="none"><path d="M1 1h8" stroke="#fff" stroke-width="1.8" stroke-linecap="round"></path></svg>
                                </template>
                                <template x-if="open !== {{ $idx }}">
                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M5 1v8M1 5h8" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round"></path></svg>
                                </template>
                            </span>
                        </button>
                        <div class="px-7 pb-6" x-show="open === {{ $idx }}" x-transition>
                            <p class="text-sm leading-relaxed text-slate-600 dark:text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $faq['a'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
