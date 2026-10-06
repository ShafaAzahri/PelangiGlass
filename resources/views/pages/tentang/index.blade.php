@extends('layouts.app')

@section('content')

@php
    $storyTitle = $siteSettings['about_story_title'] ?? 'Lebih dari ' . ($siteSettings['years_experience'] ?? '30+') . ' Tahun Melayani Purwokerto';
    $storyP1 = $siteSettings['about_story_p1'] ?? 'Berdiri sejak 1992, Pelangi Glass hadir sebagai solusi kaca otomotif terpercaya di Purwokerto dan Banyumas. Dirintis dengan semangat pelayanan terbaik, kami telah melayani puluhan ribu pelanggan selama lebih dari tiga dekade.';
    $storyP2 = $siteSettings['about_story_p2'] ?? 'Dengan pengalaman panjang dan tim teknisi yang terus berkembang, kami berkomitmen menghadirkan kualitas kerja yang presisi, produk bergaransi resmi, serta layanan yang ramah dan transparan bagi setiap pelanggan.';

    $statFounded = $siteSettings['about_stat_founded'] ?? '1992';
    $statExperience = $siteSettings['years_experience'] ?? \App\Models\Setting::get('years_experience', '30+');
    $statCustomers = $siteSettings['about_stat_customers'] ?? '10.000+';
    $statWarranty = $siteSettings['about_stat_warranty'] ?? '100%';

    $visionTitle = $siteSettings['about_vision_title'] ?? 'Visi Kami';
    $visionStatement = $siteSettings['about_vision_statement'] ?? 'Menjadi perusahaan kaca otomotif terdepan, terbesar, dan terpercaya di Jawa Tengah melalui inovasi teknologi dan standar pelayanan unggul, dengan komitmen pada kualitas layanan dan kesejahteraan karyawan.';

    $defaultPillars = [
        ['title' => 'Kualitas Terbaik', 'desc' => 'Produk dan material untuk keamanan Anda'],
        ['title' => 'Inovasi Teknologi', 'desc' => 'Berinovasi mengikuti teknologi terkini'],
        ['title' => 'Pelayanan Unggul', 'desc' => 'Layanan cepat, ramah, dan profesional'],
        ['title' => 'Terpercaya Selalu', 'desc' => 'Pilihan tepat dengan hasil terbaik & bergaransi'],
    ];
    $rawPillars = $siteSettings['about_vision_pillars'] ?? null;
    $pillars = $rawPillars ? json_decode($rawPillars, true) : $defaultPillars;
    if (!is_array($pillars)) $pillars = $defaultPillars;

    $missionTitle = $siteSettings['about_mission_title'] ?? 'Misi Kami';
    $defaultMissions = [
        ['text' => 'Menjamin kesejahteraan, keselamatan, dan pengembangan karyawan sebagai fondasi utama keberlanjutan perusahaan.'],
        ['text' => 'Mengembangkan kompetensi teknisi dan tim pelayanan melalui pelatihan rutin, sertifikasi profesional, dan standar kerja yang jelas.'],
        ['text' => 'Menyediakan produk kaca otomotif berkualitas tinggi dan bersertifikasi dengan standar keamanan yang teruji sesuai kebutuhan pelanggan.'],
        ['text' => 'Memastikan setiap proses layanan berjalan cepat, presisi, dan aman melalui penerapan SOP, disiplin keselamatan, serta pemanfaatan teknologi yang relevan.'],
        ['text' => 'Membangun jaringan layanan yang luas dan mudah dijangkau di Purwokerto, Jawa Tengah, hingga wilayah strategis nasional.'],
        ['text' => 'Menciptakan pengalaman pelanggan terbaik melalui pelayanan yang ramah, responsif, edukatif, informatif, dan solutif, termasuk penguatan after-sales dan CRM.'],
        ['text' => 'Mengembangkan kemitraan strategis dan menjalankan praktik bisnis berkelanjutan yang bertanggung jawab terhadap lingkungan.'],
    ];
    $rawMissions = $siteSettings['about_missions'] ?? null;
    $missions = $rawMissions ? json_decode($rawMissions, true) : $defaultMissions;
    if (!is_array($missions)) $missions = $defaultMissions;

    $midPoint = (int) ceil(count($missions) / 2);
    $col1 = array_slice($missions, 0, $midPoint);
    $col2 = array_slice($missions, $midPoint);
@endphp

    <div class="pt-[76px] md:pt-[88px] min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors">
        <!-- Sejarah singkat (matching TentangKami.tsx exactly) -->
        <div class="max-w-6xl mx-auto px-6 py-16">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3 text-blue-600 dark:text-blue-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Perjalanan Kami
                    </div>
                    <h2 class="uppercase mb-5 text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.8rem, 3.5vw, 2.8rem); font-weight: 800; line-height: 1.05;">
                        {{ $storyTitle }}
                    </h2>
                    <p class="text-sm leading-relaxed mb-4 text-slate-600 dark:text-slate-300" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ $storyP1 }}
                    </p>
                    <p class="text-sm leading-relaxed text-slate-600 dark:text-slate-300" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ $storyP2 }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-2xl p-6 text-center bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
                        <div class="font-black mb-1 text-blue-600 dark:text-blue-400" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2rem;">
                            {{ $statFounded }}
                        </div>
                        <div class="text-xs text-slate-500 dark:text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            Tahun Berdiri
                        </div>
                    </div>
                    <div class="rounded-2xl p-6 text-center bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
                        <div class="font-black mb-1 text-blue-600 dark:text-blue-400" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2rem;">
                            {{ $statExperience }}
                        </div>
                        <div class="text-xs text-slate-500 dark:text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            Tahun Pengalaman
                        </div>
                    </div>
                    <div class="rounded-2xl p-6 text-center bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
                        <div class="font-black mb-1 text-blue-600 dark:text-blue-400" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2rem;">
                            {{ $statCustomers }}
                        </div>
                        <div class="text-xs text-slate-500 dark:text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            Pelanggan Dilayani
                        </div>
                    </div>
                    <div class="rounded-2xl p-6 text-center bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
                        <div class="font-black mb-1 text-blue-600 dark:text-blue-400" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2rem;">
                            {{ $statWarranty }}
                        </div>
                        <div class="text-xs text-slate-500 dark:text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            Garansi Pekerjaan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- VISI (matching TentangKami.tsx exactly) -->
        <div class="py-16 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 transition-colors">
            <div class="max-w-6xl mx-auto px-6">
                <div>
                    <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3 text-blue-600 dark:text-blue-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Visi Perusahaan
                    </div>
                    <h2 class="uppercase mb-8 text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 800; line-height: 1.05;">
                        {{ $visionTitle }}
                    </h2>
                </div>

                <!-- Visi statement -->
                <div class="rounded-3xl p-8 md:p-12 mb-10" style="background: linear-gradient(135deg, #1e3a5f 0%, #1e40af 100%);">
                    <p class="leading-relaxed text-center" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1rem, 2.5vw, 1.25rem); color: #e2e8f0; max-width: 720px; margin: 0 auto;">
                        {{ $visionStatement }}
                    </p>
                </div>

                <!-- Visi pillars -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($pillars as $p)
                        <div class="rounded-2xl p-6 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xs">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4 bg-blue-50 dark:bg-slate-700 text-blue-600 dark:text-blue-400">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"/></svg>
                            </div>
                            <div class="font-bold mb-1 uppercase text-xs tracking-wide text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $p['title'] ?? '' }}
                            </div>
                            <div class="text-xs leading-relaxed text-slate-500 dark:text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $p['desc'] ?? '' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- MISI (matching TentangKami.tsx exactly) -->
        <div class="max-w-6xl mx-auto px-6 py-16">
            <div>
                <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3 text-blue-600 dark:text-blue-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Misi Perusahaan
                </div>
                <h2 class="uppercase mb-10 text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 800; line-height: 1.05;">
                    {{ $missionTitle }}
                </h2>
            </div>

            <div class="grid md:grid-cols-2 gap-4 items-start">
                <div class="flex flex-col gap-4">
                    @foreach($col1 as $idx => $m)
                        <div class="flex gap-5 rounded-2xl p-6 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 font-black text-base bg-blue-700 dark:bg-blue-600 text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $idx + 1 }}
                            </div>
                            <p class="text-sm leading-relaxed text-slate-600 dark:text-slate-300" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $m['text'] ?? '' }}
                            </p>
                        </div>
                    @endforeach
                </div>
                <div class="flex flex-col gap-4">
                    @foreach($col2 as $idx => $m)
                        <div class="flex gap-5 rounded-2xl p-6 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 font-black text-base bg-blue-700 dark:bg-blue-600 text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $midPoint + $idx + 1 }}
                            </div>
                            <p class="text-sm leading-relaxed text-slate-600 dark:text-slate-300" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $m['text'] ?? '' }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- CTA (matching TentangKami.tsx exactly) -->
        <div class="max-w-6xl mx-auto px-6 py-16 text-center">
            <h2 class="uppercase mb-3 text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.5rem, 3vw, 2.2rem); font-weight: 800;">
                Siap Percayakan Kaca Mobil Anda?
            </h2>
            <p class="text-sm mb-8 text-slate-600 dark:text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Hubungi kami sekarang untuk konsultasi gratis.
            </p>
            <x-whatsapp-button variant="pill" label="Hubungi Kami" text="Halo Pelangi Glass, saya ingin konsultasi mengenai kaca mobil / kaca film." class="px-8 py-3.5" />
        </div>
    </div>

@endsection
