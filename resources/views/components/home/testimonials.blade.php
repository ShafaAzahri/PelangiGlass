@props([
    'testimonials' => null,
])

@php
    $defaultTestimonials = [
        [
            'name' => 'Budi Santoso',
            'role' => 'Pengusaha',
            'car' => 'Toyota Innova Zenix',
            'rating' => 5,
            'text' => 'Sudah lebih dari 10 tahun langganan di Pelangi Glass untuk semua mobil operasional kantor. Hasil pemasangan kaca depan sangat rapi, tidak ada bocor saat hujan deras, dan harganya sangat fair serta transparan.',
            'color' => '#2563eb'
        ],
        [
            'name' => 'dr. Rina Wijayanti',
            'role' => 'Dokter Umum',
            'car' => 'Honda CR-V Turbo',
            'rating' => 5,
            'text' => 'Pasang kaca film V-Kool di sini pelayanannya luar biasa ramah dan teliti. Ruang tunggu ber-AC sangat nyaman. Setelah pasang, kabin mobil jauh lebih adem walau parkir di terik siang.',
            'color' => '#059669'
        ],
        [
            'name' => 'Hendro Prasetyo',
            'role' => 'Karyawan Swasta',
            'car' => 'Mitsubishi Pajero Sport',
            'rating' => 5,
            'text' => 'Kaca depan kena kerikil di tol dan langsung retak panjang. Teknisi Pelangi Glass sangat cekatan, dalam waktu 2 jam kaca sudah diganti baru dengan presisi OEM pabrik. Sangat direkomendasikan!',
            'color' => '#d97706'
        ],
        [
            'name' => 'Siti Nurhaliza',
            'role' => 'Ibu Rumah Tangga',
            'car' => 'Toyota Raize',
            'rating' => 5,
            'text' => 'Awalnya bingung pilih persentase kegelapan kaca film yang aman untuk malam hari. Konsultasinya sangat membantu dan tidak memaksakan produk termahal. Hasilnya pas banget sesuai kebutuhan!',
            'color' => '#7c3aed'
        ],
        [
            'name' => 'Bambang Kusuma',
            'role' => 'Arsitek',
            'car' => 'Mazda CX-5',
            'rating' => 5,
            'text' => 'Sangat detail dalam proses pengerjaan. Sealant dipasang rapi tanpa blepotan sama sekali. Sensor hujan dan kamera ADAS di kaca depan juga berfungsi normal tanpa kendala kalibrasi.',
            'color' => '#dc2626'
        ],
        [
            'name' => 'Agus Setiawan',
            'role' => 'Kolektor Mobil Klasik',
            'car' => 'Toyota Land Cruiser VX80',
            'rating' => 5,
            'text' => 'Mencari kaca mobil langka untuk seri jadul di Purwokerto awalnya ragu, tapi di Pelangi Glass bisa dipesan dan dipasang dengan presisi tinggi. Reputasi sejak 1992 memang terbukti nyata!',
            'color' => '#0891b2'
        ],
        [
            'name' => 'Fajar Nugroho',
            'role' => 'Pengemudi Online',
            'car' => 'Daihatsu Sigra',
            'rating' => 5,
            'text' => 'Kaca samping kiri pecah malam hari. Pagi-pagi langsung kontak WA, stok ready dan siang hari mobil sudah bisa narik lagi. Pelayanannya cepat dan respon adminnya sangat solutif.',
            'color' => '#ea580c'
        ],
        [
            'name' => 'Wahyu Tri Prabowo',
            'role' => 'Manajer Logistik',
            'car' => 'Toyota Hilux D-Cab',
            'rating' => 5,
            'text' => 'Armada operasional kami rutin servis kaca di sini. Kualitas kaca berstandar SNI/OEM asli dan lem polyurethane yang dipakai berkualitas grade otomotif terbaik. Sangat terjamin keamanannya.',
            'color' => '#4f46e5'
        ],
    ];
    $testimonialsList = (isset($testimonials) && $testimonials->count() > 0)
        ? $testimonials->map(fn($t) => [
            'name' => $t->customer_name,
            'role' => $t->service_rendered ?? 'Pelanggan',
            'car' => $t->car_model ?? 'Mobil',
            'rating' => $t->rating,
            'text' => $t->review_text,
            'color' => $t->avatar_color ?? '#2563eb',
        ])->toArray()
        : $defaultTestimonials;
@endphp

<section class="py-24 overflow-hidden" style="background: #0f172a;" x-data="{
    isPaused: false,
    speed: 0.65,
    pos: 0,
    resumeTimer: null,
    rafId: null,
    isDown: false,
    startX: 0,
    startScroll: 0,
    init() {
        const track = this.$refs.testitrack;
        if (!track) return;
        this.pos = track.scrollLeft;

        const step = () => {
            if (!this.isPaused && !this.isDown && track) {
                this.pos += this.speed;
                const half = track.scrollWidth / 2;
                if (half > 0 && this.pos >= half) {
                    this.pos -= half;
                    track.scrollLeft = this.pos;
                } else {
                    track.scrollLeft = this.pos;
                }
            }
            this.rafId = requestAnimationFrame(step);
        };
        this.rafId = requestAnimationFrame(step);
    },
    onScroll() {
        if ((this.isPaused || this.isDown) && this.$refs.testitrack) {
            this.pos = this.$refs.testitrack.scrollLeft;
        }
    },
    scroll(dir) {
        this.isPaused = true;
        const amount = dir * 420;
        if (this.$refs.testitrack) {
            this.$refs.testitrack.scrollBy({ left: amount, behavior: 'smooth' });
            setTimeout(() => {
                if (this.$refs.testitrack) {
                    this.pos = this.$refs.testitrack.scrollLeft;
                    const half = this.$refs.testitrack.scrollWidth / 2;
                    if (half > 0) {
                        if (this.pos >= half) this.pos -= half;
                        if (this.pos < 0) this.pos += half;
                        this.$refs.testitrack.scrollLeft = this.pos;
                    }
                }
            }, 400);
        }
        clearTimeout(this.resumeTimer);
        this.resumeTimer = setTimeout(() => {
            this.isPaused = false;
        }, 2500);
    },
    onMouseDown(e) {
        this.isDown = true;
        this.isPaused = true;
        this.startX = e.pageX - this.$refs.testitrack.offsetLeft;
        this.startScroll = this.$refs.testitrack.scrollLeft;
    },
    onMouseMove(e) {
        if (!this.isDown) return;
        e.preventDefault();
        const x = e.pageX - this.$refs.testitrack.offsetLeft;
        const walk = (x - this.startX) * 1.5;
        this.$refs.testitrack.scrollLeft = this.startScroll - walk;
        this.pos = this.$refs.testitrack.scrollLeft;
    },
    onMouseUp() {
        if (this.isDown) {
            this.isDown = false;
            clearTimeout(this.resumeTimer);
            this.resumeTimer = setTimeout(() => {
                this.isPaused = false;
            }, 1500);
        }
    }
}">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex items-end justify-between mb-12 flex-wrap gap-4">
            <div>
                <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3" style="color: #3b82f6;">
                    Testimoni Pelanggan
                </div>
                <h2 class="text-white uppercase" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 800; line-height: 1.05;">
                    Kata Mereka<br />Yang Sudah Percaya
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <span class="hidden sm:inline-block text-xs text-slate-400">
                    Geser untuk melihat testimoni lainnya
                </span>
                <div class="flex gap-2">
                    <button aria-label="Sebelumnya" @click="scroll(-1)" class="w-11 h-11 rounded-full flex items-center justify-center transition-all cursor-pointer text-slate-300 hover:text-white border border-white/15 bg-white/5 hover:bg-white/10" onmouseenter="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.color='#fff';" onmouseleave="this.style.borderColor='rgba(255,255,255,0.12)'; this.style.color='#94a3b8';">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                    </button>
                    <button aria-label="Berikutnya" @click="scroll(1)" class="w-11 h-11 rounded-full flex items-center justify-center transition-all hover:opacity-90 cursor-pointer bg-blue-600 text-white shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div 
        x-ref="testitrack" 
        class="flex gap-5 px-6 pb-4 cursor-grab active:cursor-grabbing select-none no-scrollbar" 
        style="overflow-x: auto; scroll-behavior: auto;"
        @mouseenter="isPaused = true"
        @mouseleave="if (!isDown) isPaused = false"
        @touchstart="isPaused = true"
        @touchend="clearTimeout(resumeTimer); resumeTimer = setTimeout(() => isPaused = false, 1500)"
        @mousedown="onMouseDown($event)"
        @mousemove="onMouseMove($event)"
        @mouseup="onMouseUp()"
        @mouseleave.self="onMouseUp()"
        @scroll="onScroll()"
    >
        @foreach(array_merge($testimonialsList, $testimonialsList) as $t)
            <div data-card class="shrink-0 rounded-2xl p-7 sm:p-8 flex flex-col justify-between" style="width: min(400px, 84vw); background: #1e293b; border: 1px solid rgba(255,255,255,0.08);">
                <div>
                    <!-- Header card: Stars & Quote -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-1">
                            @for($i = 0; $i < $t['rating']; $i++)
                                <svg class="w-4 h-4 fill-amber-400 text-amber-400" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            @endfor
                        </div>
                        <svg class="w-6 h-6 text-blue-500/40" fill="currentColor" viewBox="0 0 24 24"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2H4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2h4c0 4-2 6-5 6v2zm13 0c3 0 7-1 7-8V5c0-1.25-.75-2-2-2h-4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2h4c0 4-2 6-5 6v2z"/></svg>
                    </div>

                    <!-- Vehicle badge -->
                    <div class="inline-block text-[11px] font-medium px-2.5 py-0.5 rounded-md mb-4 bg-slate-800 text-slate-300 border border-slate-700/60">
                        {{ $t['car'] }}
                    </div>

                    <!-- Testimonial text -->
                    <blockquote class="text-sm sm:text-base leading-relaxed mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 300; color: #cbd5e1;">
                        "{{ $t['text'] }}"
                    </blockquote>
                </div>

                <!-- Author info -->
                <div class="flex items-center gap-3 pt-4 border-t border-slate-700/50">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white shrink-0 shadow-inner text-sm" style="background: {{ $t['color'] }}; font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ substr($t['name'], 0, 1) }}
                    </div>
                    <div>
                        <div class="font-semibold text-white text-sm" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ $t['name'] }}
                        </div>
                        <div class="text-xs text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ $t['role'] }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
