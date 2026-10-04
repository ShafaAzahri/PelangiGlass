@extends('layouts.app')

@section('content')

    <div class="pt-[76px] md:pt-[88px]" style="background: #f8fafc; min-height: 100vh;">
        <!-- Sejarah singkat (matching TentangKami.tsx exactly) -->
        <div class="max-w-6xl mx-auto px-6 py-16">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3" style="color: #2563eb; font-family: 'Plus Jakarta Sans', sans-serif;">
                        Perjalanan Kami
                    </div>
                    <h2 class="uppercase mb-5" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.8rem, 3.5vw, 2.8rem); font-weight: 800; lineHeight: 1.05; color: #0f172a;">
                        Lebih dari {{ \App\Models\Setting::get('years_experience', '30+') }} Tahun<br />Melayani Purwokerto
                    </h2>
                    <p class="text-sm leading-relaxed mb-4" style="color: #64748b; font-family: 'Plus Jakarta Sans', sans-serif;">
                        Berdiri sejak 1992, Pelangi Glass hadir sebagai solusi kaca otomotif terpercaya di Purwokerto dan Banyumas. Dirintis dengan semangat pelayanan terbaik, kami telah melayani puluhan ribu pelanggan selama lebih dari tiga dekade.
                    </p>
                    <p class="text-sm leading-relaxed" style="color: #64748b; font-family: 'Plus Jakarta Sans', sans-serif;">
                        Dengan pengalaman panjang dan tim teknisi yang terus berkembang, kami berkomitmen menghadirkan kualitas kerja yang presisi, produk bergaransi resmi, serta layanan yang ramah dan transparan bagi setiap pelanggan.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-2xl p-6 text-center" style="background: #ffffff; border: 1px solid #e2e8f0;">
                        <div class="font-black mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2rem; color: #2563eb;">
                            1992
                        </div>
                        <div class="text-xs" style="color: #64748b; font-family: 'Plus Jakarta Sans', sans-serif;">
                            Tahun Berdiri
                        </div>
                    </div>
                    <div class="rounded-2xl p-6 text-center" style="background: #ffffff; border: 1px solid #e2e8f0;">
                        <div class="font-black mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2rem; color: #2563eb;">
                            {{ \App\Models\Setting::get('years_experience', '30+') }}
                        </div>
                        <div class="text-xs" style="color: #64748b; font-family: 'Plus Jakarta Sans', sans-serif;">
                            Tahun Pengalaman
                        </div>
                    </div>
                    <div class="rounded-2xl p-6 text-center" style="background: #ffffff; border: 1px solid #e2e8f0;">
                        <div class="font-black mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2rem; color: #2563eb;">
                            10.000+
                        </div>
                        <div class="text-xs" style="color: #64748b; font-family: 'Plus Jakarta Sans', sans-serif;">
                            Pelanggan Dilayani
                        </div>
                    </div>
                    <div class="rounded-2xl p-6 text-center" style="background: #ffffff; border: 1px solid #e2e8f0;">
                        <div class="font-black mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2rem; color: #2563eb;">
                            100%
                        </div>
                        <div class="text-xs" style="color: #64748b; font-family: 'Plus Jakarta Sans', sans-serif;">
                            Garansi Pekerjaan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- VISI (matching TentangKami.tsx exactly) -->
        <div class="py-16" style="background: #ffffff; border-top: 1px solid #e2e8f0;">
            <div class="max-w-6xl mx-auto px-6">
                <div>
                    <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3" style="color: #2563eb; font-family: 'Plus Jakarta Sans', sans-serif;">
                        Visi Perusahaan
                    </div>
                    <h2 class="uppercase mb-8" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 800; lineHeight: 1.05; color: #0f172a;">
                        Visi Kami
                    </h2>
                </div>

                <!-- Visi statement -->
                <div class="rounded-3xl p-8 md:p-12 mb-10" style="background: linear-gradient(135deg, #1e3a5f 0%, #1e40af 100%);">
                    <p class="leading-relaxed text-center" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1rem, 2.5vw, 1.25rem); color: #e2e8f0; max-width: 720px; margin: 0 auto;">
                        Menjadi perusahaan kaca otomotif <span style="color: #fbbf24; font-weight: 700;">terdepan</span>, <span style="color: #fbbf24; font-weight: 700;">terbesar</span>, dan <span style="color: #fbbf24; font-weight: 700;">terpercaya</span> di Jawa Tengah melalui <em style="color: #93c5fd;">inovasi teknologi</em> dan <em style="color: #93c5fd;">standar pelayanan unggul</em>, dengan komitmen pada <em style="color: #93c5fd;">kualitas layanan</em> dan <em style="color: #93c5fd;">kesejahteraan karyawan</em>.
                    </p>
                </div>

                <!-- Visi pillars -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div class="rounded-2xl p-6" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4" style="background: #eff6ff; color: #2563eb;">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"></circle><path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"></path></svg>
                        </div>
                        <div class="font-bold mb-1 uppercase text-xs tracking-wide" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #0f172a;">
                            Kualitas Terbaik
                        </div>
                        <div class="text-xs leading-relaxed" style="color: #64748b; font-family: 'Plus Jakarta Sans', sans-serif;">
                            Produk dan material untuk keamanan Anda
                        </div>
                    </div>

                    <div class="rounded-2xl p-6" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4" style="background: #eff6ff; color: #2563eb;">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>
                        </div>
                        <div class="font-bold mb-1 uppercase text-xs tracking-wide" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #0f172a;">
                            Inovasi Teknologi
                        </div>
                        <div class="text-xs leading-relaxed" style="color: #64748b; font-family: 'Plus Jakarta Sans', sans-serif;">
                            Berinovasi mengikuti teknologi terkini
                        </div>
                    </div>

                    <div class="rounded-2xl p-6" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4" style="background: #eff6ff; color: #2563eb;">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                        <div class="font-bold mb-1 uppercase text-xs tracking-wide" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #0f172a;">
                            Pelayanan Unggul
                        </div>
                        <div class="text-xs leading-relaxed" style="color: #64748b; font-family: 'Plus Jakarta Sans', sans-serif;">
                            Layanan cepat, ramah, dan profesional
                        </div>
                    </div>

                    <div class="rounded-2xl p-6" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4" style="background: #eff6ff; color: #2563eb;">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                        <div class="font-bold mb-1 uppercase text-xs tracking-wide" style="font-family: 'Plus Jakarta Sans', sans-serif; color: #0f172a;">
                            Terpercaya Selalu
                        </div>
                        <div class="text-xs leading-relaxed" style="color: #64748b; font-family: 'Plus Jakarta Sans', sans-serif;">
                            Pilihan tepat dengan hasil terbaik & bergaransi
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MISI (matching TentangKami.tsx exactly) -->
        <div class="max-w-6xl mx-auto px-6 py-16">
            <div>
                <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3" style="color: #2563eb; font-family: 'Plus Jakarta Sans', sans-serif;">
                    Misi Perusahaan
                </div>
                <h2 class="uppercase mb-10" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 800; lineHeight: 1.05; color: #0f172a;">
                    Misi Kami
                </h2>
            </div>

            @php
                $misiList = [
                    ['no' => '1', 'text' => 'Menjamin kesejahteraan, keselamatan, dan pengembangan karyawan sebagai fondasi utama keberlanjutan perusahaan.'],
                    ['no' => '2', 'text' => 'Mengembangkan kompetensi teknisi dan tim pelayanan melalui pelatihan rutin, sertifikasi profesional, dan standar kerja yang jelas.'],
                    ['no' => '3', 'text' => 'Menyediakan produk kaca otomotif berkualitas tinggi dan bersertifikasi dengan standar keamanan yang teruji sesuai kebutuhan pelanggan.'],
                    ['no' => '4', 'text' => 'Memastikan setiap proses layanan berjalan cepat, presisi, dan aman melalui penerapan SOP, disiplin keselamatan, serta pemanfaatan teknologi yang relevan.'],
                    ['no' => '5', 'text' => 'Membangun jaringan layanan yang luas dan mudah dijangkau di Purwokerto, Jawa Tengah, hingga wilayah strategis nasional.'],
                    ['no' => '6', 'text' => 'Menciptakan pengalaman pelanggan terbaik melalui pelayanan yang ramah, responsif, edukatif, informatif, dan solutif, termasuk penguatan after-sales dan CRM.'],
                    ['no' => '7', 'text' => 'Mengembangkan kemitraan strategis dan menjalankan praktik bisnis berkelanjutan yang bertanggung jawab terhadap lingkungan.'],
                ];
                $col1 = array_slice($misiList, 0, 4);
                $col2 = array_slice($misiList, 4);
            @endphp

            <div class="grid md:grid-cols-2 gap-4 items-start">
                <div class="flex flex-col gap-4">
                    @foreach($col1 as $m)
                        <div class="flex gap-5 rounded-2xl p-6" style="background: #ffffff; border: 1px solid #e2e8f0;">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 font-black text-base" style="background: #1e40af; color: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $m['no'] }}
                            </div>
                            <p class="text-sm leading-relaxed" style="color: #475569; font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $m['text'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
                <div class="flex flex-col gap-4">
                    @foreach($col2 as $m)
                        <div class="flex gap-5 rounded-2xl p-6" style="background: #ffffff; border: 1px solid #e2e8f0;">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 font-black text-base" style="background: #1e40af; color: #ffffff; font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $m['no'] }}
                            </div>
                            <p class="text-sm leading-relaxed" style="color: #475569; font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $m['text'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- CTA (matching TentangKami.tsx exactly) -->
        <div class="max-w-6xl mx-auto px-6 py-16 text-center">
            <h2 class="uppercase mb-3" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.5rem, 3vw, 2.2rem); font-weight: 800; color: #0f172a;">
                Siap Percayakan Kaca Mobil Anda?
            </h2>
            <p class="text-sm mb-8" style="color: #64748b; font-family: 'Plus Jakarta Sans', sans-serif;">
                Hubungi kami sekarang untuk konsultasi gratis.
            </p>
            <a href="https://wa.me/6281390288875?text={{ urlencode('Halo Pelangi Glass, saya ingin konsultasi mengenai kaca mobil / kaca film.') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2.5 px-8 py-3.5 rounded-full text-sm font-semibold text-white transition-all hover:opacity-90 shadow-md hover:scale-105 active:scale-95 no-underline" style="background: #1e40af; font-family: 'Plus Jakarta Sans', sans-serif;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                <span>Hubungi Kami</span>
            </a>
        </div>
    </div>

@endsection
