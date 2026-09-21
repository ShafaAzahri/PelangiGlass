@extends('layouts.app')

@section('content')

    <!-- Banner Header -->
    <section class="bg-slate-950 text-white py-16 sm:py-24 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center max-w-3xl">
            <span class="text-xs font-bold tracking-[0.2em] text-blue-400 uppercase">Tentang Pelangi Glass</span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight mt-2 mb-4">
                Dedikasi dan Keahlian Lebih Dari 30 Tahun
            </h1>
            <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                Menjadi bengkel spesialis kaca mobil dan kaca film nomor satu di Purwokerto yang mengutamakan keselamatan, kepresisian, dan kenyamanan pelanggan.
            </p>
        </div>
    </section>

    <!-- Visi & Pilar Keunggulan -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-xs font-bold tracking-[0.2em] text-blue-600 uppercase">Fondasi Utama</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight mt-1">
                    Visi Perusahaan
                </h2>
                <p class="text-sm text-slate-600 mt-3 leading-relaxed">
                    "Menjadi pusat layanan kaca otomotif terlengkap, terpercaya, dan berstandar internasional di Jawa Tengah yang mengedepankan kualitas produk serta kepuasan pelanggan."
                </p>
            </div>

            <!-- 4 Pilar -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-blue-200 transition">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mb-4">
                        <i data-lucide="award" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-1">Kualitas Terbaik</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Produk kaca bersertifikasi OEM dan kaca film bergaransi resmi untuk keselamatan berkendara.</p>
                </div>

                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-blue-200 transition">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4">
                        <i data-lucide="cpu" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-1">Inovasi Teknologi</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Peralatan injeksi resin modern dan metode lem sealant mutakhir tanpa merusak bodi mobil.</p>
                </div>

                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-blue-200 transition">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center mb-4">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-1">Pelayanan Unggul</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Tim ramah, komunikatif, dan transparan memberikan estimasi pengerjaan yang akurat.</p>
                </div>

                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-blue-200 transition">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center mb-4">
                        <i data-lucide="shield-check" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-1">Terpercaya Selalu</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Pilihan utama pelanggan perorangan, instansi, hingga klaim rekanan asuransi terkemuka.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Misi Perusahaan -->
    <section class="py-20 bg-slate-50 border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-5">
                    <span class="text-xs font-bold tracking-[0.2em] text-blue-600 uppercase">Langkah Nyata</span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight mt-1 mb-4">
                        Misi Pelangi Glass
                    </h2>
                    <p class="text-sm text-slate-600 leading-relaxed mb-6">
                        Setiap pengerjaan di bengkel kami didasari komitmen profesional untuk memastikan kendaraan Anda kembali prima dengan standar keamanan pabrik.
                    </p>
                    <img src="{{ asset('images/beres.png') }}" alt="Value BERES" class="w-full max-w-sm rounded-2xl shadow-md border border-slate-200">
                </div>

                <div class="lg:col-span-7 space-y-4">
                    @foreach([
                        ['no' => '01', 'title' => 'Kesejahteraan & Standar Kerja Tim', 'desc' => 'Menjamin keselamatan dan pengembangan keahlian teknisi secara berkelanjutan sebagai fondasi mutu layanan.'],
                        ['no' => '02', 'title' => 'Pelatihan & Sertifikasi Rutin', 'desc' => 'Mengembangkan kompetensi teknisi melalui training berkala terhadap jenis kendaraan terbaru dan fitur ADAS sensor kaca.'],
                        ['no' => '03', 'title' => 'Penyediaan Produk Berkualitas Tinggi', 'desc' => 'Menyediakan stok kaca OEM terlengkap dan film penolak panas berstandar SNI dan sertifikasi internasional.'],
                        ['no' => '04', 'title' => 'Penerapan SOP Presisi & Aman', 'desc' => 'Memastikan setiap pengerjaan tepat waktu, rapi, dan bebas rembes dengan lem sealant polyurethane kelas atas.']
                    ] as $m)
                        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-start gap-4">
                            <span class="text-xl font-black text-blue-600 shrink-0 font-mono">{{ $m['no'] }}</span>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm sm:text-base mb-1">{{ $m['title'] }}</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">{{ $m['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-blue-600 text-white text-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight">
                Percayakan Kaca Mobil Anda Kepada Spesialisnya
            </h2>
            <p class="text-blue-100 text-sm sm:text-base leading-relaxed max-w-2xl mx-auto">
                Kunjungi workshop kami di Purwokerto atau konsultasikan kondisi kaca mobil Anda via WhatsApp sekarang juga.
            </p>
            <div class="pt-2">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp', '6281390288875')) }}" target="_blank" class="inline-flex items-center gap-2 bg-white text-blue-600 hover:bg-slate-100 font-bold text-sm px-8 py-4 rounded-xl shadow-lg transition">
                    <i data-lucide="message-circle" class="w-5 h-5"></i>
                    Konsultasi via WhatsApp Gratis
                </a>
            </div>
        </div>
    </section>

@endsection
