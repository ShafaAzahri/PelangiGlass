<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    testimonials: {
        type: Array,
        default: () => [],
    },
});

const defaultTestimonials = [
    {
        name: 'Budi Santoso',
        role: 'Pengusaha',
        car: 'Toyota Innova Zenix',
        rating: 5,
        text: 'Sudah lebih dari 10 tahun langganan di Pelangi Glass untuk semua mobil operasional kantor. Hasil pemasangan kaca depan sangat rapi, tidak ada bocor saat hujan deras, dan harganya sangat fair serta transparan.',
        color: '#2563eb',
    },
    {
        name: 'dr. Rina Wijayanti',
        role: 'Dokter Umum',
        car: 'Honda CR-V Turbo',
        rating: 5,
        text: 'Pasang kaca film V-Kool di sini pelayanannya luar biasa ramah dan teliti. Ruang tunggu ber-AC sangat nyaman. Setelah pasang, kabin mobil jauh lebih adem walau parkir di terik siang.',
        color: '#059669',
    },
    {
        name: 'Hendro Prasetyo',
        role: 'Karyawan Swasta',
        car: 'Mitsubishi Pajero Sport',
        rating: 5,
        text: 'Kaca depan kena kerikil di tol dan langsung retak panjang. Teknisi Pelangi Glass sangat cekatan, dalam waktu 2 jam kaca sudah diganti baru dengan presisi OEM pabrik. Sangat direkomendasikan!',
        color: '#d97706',
    },
    {
        name: 'Siti Nurhaliza',
        role: 'Ibu Rumah Tangga',
        car: 'Toyota Raize',
        rating: 5,
        text: 'Awalnya bingung pilih persentase kegelapan kaca film yang aman untuk malam hari. Konsultasinya sangat membantu dan tidak memaksakan produk termahal. Hasilnya pas banget sesuai kebutuhan!',
        color: '#7c3aed',
    },
    {
        name: 'Bambang Kusuma',
        role: 'Arsitek',
        car: 'Mazda CX-5',
        rating: 5,
        text: 'Sangat detail dalam proses pengerjaan. Sealant dipasang rapi tanpa blepotan sama sekali. Sensor hujan dan kamera ADAS di kaca depan juga berfungsi normal tanpa kendala kalibrasi.',
        color: '#dc2626',
    },
    {
        name: 'Agus Setiawan',
        role: 'Kolektor Mobil Klasik',
        car: 'Toyota Land Cruiser VX80',
        rating: 5,
        text: 'Mencari kaca mobil langka untuk seri jadul di Purwokerto awalnya ragu, tapi di Pelangi Glass bisa dipesan dan dipasang dengan presisi tinggi. Reputasi sejak 1992 memang terbukti nyata!',
        color: '#0891b2',
    },
];

const list = computed(() => {
    if (props.testimonials && props.testimonials.length > 0) {
        return props.testimonials.map((t) => ({
            name: t.customer_name,
            role: t.service_rendered || 'Pelanggan',
            car: t.car_model || 'Mobil',
            rating: t.rating || 5,
            text: t.review_text,
            color: t.avatar_color || '#2563eb',
        }));
    }
    return defaultTestimonials;
});

const doubledList = computed(() => [...list.value, ...list.value]);

const testitrackRef = ref(null);
const isPaused = ref(false);
const isDown = ref(false);
const startX = ref(0);
const startScroll = ref(0);
let resumeTimer = null;
let rafId = null;
let pos = 0;
const speed = 0.65;

const scroll = (direction) => {
    isPaused.value = true;
    const amount = direction * 420;
    if (testitrackRef.value) {
        testitrackRef.value.scrollBy({ left: amount, behavior: 'smooth' });
    }
    clearTimeout(resumeTimer);
    resumeTimer = setTimeout(() => {
        isPaused.value = false;
    }, 2500);
};

const onMouseDown = (e) => {
    isDown.value = true;
    isPaused.value = true;
    startX.value = e.pageX - (testitrackRef.value?.offsetLeft || 0);
    startScroll.value = testitrackRef.value?.scrollLeft || 0;
};

const onMouseMove = (e) => {
    if (!isDown.value || !testitrackRef.value) return;
    e.preventDefault();
    const x = e.pageX - (testitrackRef.value.offsetLeft || 0);
    const walk = (x - startX.value) * 1.5;
    testitrackRef.value.scrollLeft = startScroll.value - walk;
    pos = testitrackRef.value.scrollLeft;
};

const onMouseUp = () => {
    if (isDown.value) {
        isDown.value = false;
        clearTimeout(resumeTimer);
        resumeTimer = setTimeout(() => {
            isPaused.value = false;
        }, 1500);
    }
};

const handleMouseLeave = () => {
    if (!isDown.value) {
        isPaused.value = false;
    }
};

onMounted(() => {
    const track = testitrackRef.value;
    if (!track) return;

    const step = () => {
        if (!isPaused.value && !isDown.value && track) {
            pos += speed;
            const half = track.scrollWidth / 2;
            if (half > 0 && pos >= half) {
                pos -= half;
                track.scrollLeft = pos;
            } else {
                track.scrollLeft = pos;
            }
        }
        rafId = requestAnimationFrame(step);
    };
    rafId = requestAnimationFrame(step);
});

onUnmounted(() => {
    cancelAnimationFrame(rafId);
    clearTimeout(resumeTimer);
});
</script>

<template>
    <section class="py-24 overflow-hidden bg-slate-900">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex items-end justify-between mb-12 flex-wrap gap-4">
                <div>
                    <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3 text-blue-500">
                        Testimoni Pelanggan
                    </div>
                    <h2 class="text-white uppercase text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight tracking-tight">
                        Kata Mereka<br />Yang Sudah Percaya
                    </h2>
                </div>
                <div class="flex items-center gap-3">
                    <span class="hidden sm:inline-block text-xs text-slate-400">
                        Geser untuk melihat testimoni lainnya
                    </span>
                    <div class="flex gap-2">
                        <button
                            @click="scroll(-1)"
                            type="button"
                            aria-label="Sebelumnya"
                            class="w-11 h-11 rounded-full flex items-center justify-center transition-all cursor-pointer text-slate-300 hover:text-white border border-white/15 bg-white/5 hover:bg-white/10"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                        </button>
                        <button
                            @click="scroll(1)"
                            type="button"
                            aria-label="Berikutnya"
                            class="w-11 h-11 rounded-full flex items-center justify-center transition-all hover:opacity-90 cursor-pointer bg-blue-600 text-white shadow-md"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            ref="testitrackRef"
            class="flex gap-5 px-6 pb-4 cursor-grab active:cursor-grabbing select-none no-scrollbar overflow-x-auto"
            @mouseenter="isPaused = true"
            @mouseleave="handleMouseLeave"
            @mousedown="onMouseDown"
            @mousemove="onMouseMove"
            @mouseup="onMouseUp"
        >
            <div
                v-for="(t, idx) in doubledList"
                :key="idx"
                class="shrink-0 rounded-2xl p-7 sm:p-8 flex flex-col justify-between w-[min(400px,84vw)] bg-slate-800/90 border border-white/10"
            >
                <div>
                    <!-- Stars & Quote Icon -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-1">
                            <svg
                                v-for="star in t.rating"
                                :key="star"
                                class="w-4 h-4 fill-amber-400 text-amber-400"
                                viewBox="0 0 24 24"
                            >
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 text-blue-500/40" fill="currentColor" viewBox="0 0 24 24"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.75-2-2-2H4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2h4c0 4-2 6-5 6v2zm13 0c3 0 7-1 7-8V5c0-1.25-.75-2-2-2h-4c-1.25 0-2 .75-2 2v6c0 1.25.75 2 2 2h4c0 4-2 6-5 6v2z"/></svg>
                    </div>

                    <!-- Vehicle badge -->
                    <div class="inline-block text-[11px] font-medium px-2.5 py-0.5 rounded-md mb-4 bg-slate-900 text-slate-300 border border-slate-700/60">
                        {{ t.car }}
                    </div>

                    <!-- Testimonial text -->
                    <blockquote class="text-sm sm:text-base leading-relaxed mb-6 font-light text-slate-300">
                        "{{ t.text }}"
                    </blockquote>
                </div>

                <!-- Author info -->
                <div class="flex items-center gap-3 pt-4 border-t border-slate-700/50">
                    <div
                        class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white shrink-0 shadow-inner text-sm"
                        :style="{ backgroundColor: t.color }"
                    >
                        {{ t.name.charAt(0) }}
                    </div>
                    <div>
                        <div class="font-semibold text-white text-sm">
                            {{ t.name }}
                        </div>
                        <div class="text-xs text-slate-400">
                            {{ t.role }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
