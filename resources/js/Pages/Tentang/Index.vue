<script setup>
import { computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import BaseButton from '@/Components/UI/BaseButton.vue';
import { useWhatsApp } from '@/Composables/useWhatsApp';

const page = usePage();
const { buildUrl } = useWhatsApp();

const settings = computed(() => page.props.settings || {});

const storyTitle = computed(() => settings.value.about_story_title || `Lebih dari ${settings.value.years_experience || '30+'} Tahun Melayani Purwokerto`);
const storyP1 = computed(() => settings.value.about_story_p1 || 'Berdiri sejak 1992, Pelangi Glass hadir sebagai solusi kaca otomotif terpercaya di Purwokerto dan Banyumas. Dirintis dengan semangat pelayanan terbaik, kami telah melayani puluhan ribu pelanggan selama lebih dari tiga dekade.');
const storyP2 = computed(() => settings.value.about_story_p2 || 'Dengan pengalaman panjang dan tim teknisi yang terus berkembang, kami berkomitmen menghadirkan kualitas kerja yang presisi, produk bergaransi resmi, serta layanan yang ramah dan transparan bagi setiap pelanggan.');

const statFounded = computed(() => settings.value.about_stat_founded || '1992');
const statExperience = computed(() => settings.value.years_experience || '30+');
const statCustomers = computed(() => settings.value.about_stat_customers || '10.000+');
const statWarranty = computed(() => settings.value.about_stat_warranty || '100%');

const visionTitle = computed(() => settings.value.about_vision_title || 'Visi Kami');
const visionStatement = computed(() => settings.value.about_vision_statement || 'Menjadi perusahaan kaca otomotif terdepan, terbesar, dan terpercaya di Jawa Tengah melalui inovasi teknologi dan standar pelayanan unggul, dengan komitmen pada kualitas layanan dan kesejahteraan karyawan.');

const defaultPillars = [
    { title: 'Kualitas Terbaik', desc: 'Produk dan material untuk keamanan Anda' },
    { title: 'Inovasi Teknologi', desc: 'Berinovasi mengikuti teknologi terkini' },
    { title: 'Pelayanan Unggul', desc: 'Layanan cepat, ramah, dan profesional' },
    { title: 'Terpercaya Selalu', desc: 'Pilihan tepat dengan hasil terbaik & bergaransi' },
];

const pillars = computed(() => {
    try {
        if (settings.value.about_vision_pillars) {
            const parsed = JSON.parse(settings.value.about_vision_pillars);
            if (Array.isArray(parsed)) return parsed;
        }
    } catch (e) {}
    return defaultPillars;
});

const defaultMissions = [
    { text: 'Menjamin kesejahteraan, keselamatan, dan pengembangan karyawan sebagai fondasi utama keberlanjutan perusahaan.' },
    { text: 'Mengembangkan kompetensi teknisi dan tim pelayanan melalui pelatihan rutin, sertifikasi profesional, dan standar kerja yang jelas.' },
    { text: 'Menyediakan produk kaca otomotif berkualitas tinggi dan bersertifikasi dengan standar keamanan yang teruji sesuai kebutuhan pelanggan.' },
    { text: 'Memastikan setiap proses layanan berjalan cepat, presisi, dan aman melalui penerapan SOP, disiplin keselamatan, serta pemanfaatan teknologi yang relevan.' },
    { text: 'Membangun jaringan layanan yang luas dan mudah dijangkau di Purwokerto, Jawa Tengah, hingga wilayah strategis nasional.' },
    { text: 'Menciptakan pengalaman pelanggan terbaik melalui pelayanan yang ramah, responsif, edukatif, informatif, dan solutif, termasuk penguatan after-sales dan CRM.' },
    { text: 'Mengembangkan kemitraan strategis dan menjalankan praktik bisnis berkelanjutan yang bertanggung jawab terhadap lingkungan.' },
];

const missions = computed(() => {
    try {
        if (settings.value.about_missions) {
            const parsed = JSON.parse(settings.value.about_missions);
            if (Array.isArray(parsed)) return parsed;
        }
    } catch (e) {}
    return defaultMissions;
});

const midPoint = computed(() => Math.ceil(missions.value.length / 2));
const col1 = computed(() => missions.value.slice(0, midPoint.value));
const col2 = computed(() => missions.value.slice(midPoint.value));
</script>

<template>
    <AppLayout>
        <Head title="Tentang Pelangi Glass - Spesialis Kaca Mobil Purwokerto Sejak 1992">
            <meta name="description" content="Profil lengkap, sejarah perjalanan 30+ tahun, visi, dan misi Pelangi Glass sebagai spesialis kaca mobil dan kaca film resmi di Purwokerto." />
        </Head>

        <div class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors">
            <!-- 1. Perjalanan Kami / Sejarah -->
            <div class="max-w-6xl mx-auto px-6 py-16">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3 text-blue-600 dark:text-blue-400">
                            Perjalanan Kami
                        </div>
                        <h2 class="uppercase mb-5 text-slate-900 dark:text-slate-100 text-3xl sm:text-4xl font-extrabold leading-tight">
                            {{ storyTitle }}
                        </h2>
                        <p class="text-sm leading-relaxed mb-4 text-slate-600 dark:text-slate-300">
                            {{ storyP1 }}
                        </p>
                        <p class="text-sm leading-relaxed text-slate-600 dark:text-slate-300">
                            {{ storyP2 }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-2xl p-6 text-center bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
                            <div class="font-black mb-1 text-blue-600 dark:text-blue-400 text-3xl">
                                {{ statFounded }}
                            </div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                Tahun Berdiri
                            </div>
                        </div>
                        <div class="rounded-2xl p-6 text-center bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
                            <div class="font-black mb-1 text-blue-600 dark:text-blue-400 text-3xl">
                                {{ statExperience }}
                            </div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                Tahun Pengalaman
                            </div>
                        </div>
                        <div class="rounded-2xl p-6 text-center bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
                            <div class="font-black mb-1 text-blue-600 dark:text-blue-400 text-3xl">
                                {{ statCustomers }}
                            </div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                Pelanggan Dilayani
                            </div>
                        </div>
                        <div class="rounded-2xl p-6 text-center bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
                            <div class="font-black mb-1 text-blue-600 dark:text-blue-400 text-3xl">
                                {{ statWarranty }}
                            </div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                Garansi Pekerjaan
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Visi Perusahaan -->
            <div class="py-16 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 transition-colors">
                <div class="max-w-6xl mx-auto px-6">
                    <div>
                        <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3 text-blue-600 dark:text-blue-400">
                            Visi Perusahaan
                        </div>
                        <h2 class="uppercase mb-8 text-slate-900 dark:text-slate-100 text-3xl sm:text-4xl font-extrabold leading-tight">
                            {{ visionTitle }}
                        </h2>
                    </div>

                    <!-- Vision Statement Card -->
                    <div class="rounded-3xl p-8 md:p-12 mb-10 bg-gradient-to-br from-[#1e3a5f] to-[#1e40af] text-white">
                        <p class="leading-relaxed text-center text-slate-100 text-base sm:text-lg md:text-xl max-w-3xl mx-auto font-medium">
                            "{{ visionStatement }}"
                        </p>
                    </div>

                    <!-- Vision Pillars -->
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        <div
                            v-for="(pillar, idx) in pillars"
                            :key="idx"
                            class="rounded-2xl p-6 bg-slate-50 dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700/60 flex flex-col justify-between"
                        >
                            <div>
                                <span class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-950/80 text-blue-600 dark:text-blue-400 font-bold text-xs flex items-center justify-center mb-4">
                                    0{{ idx + 1 }}
                                </span>
                                <h3 class="font-bold text-slate-900 dark:text-slate-100 text-base mb-2">
                                    {{ pillar.title }}
                                </h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                    {{ pillar.desc }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Misi Perusahaan (matching Image #1 exactly) -->
            <div class="py-20 bg-[#0b1324] text-white border-t border-slate-800 transition-colors">
                <div class="max-w-6xl mx-auto px-6">
                    <div class="mb-10">
                        <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3 text-blue-400">
                            MISI PERUSAHAAN
                        </div>
                        <h2 class="uppercase text-white text-3xl sm:text-4xl md:text-5xl font-black leading-tight tracking-tight">
                            MISI KAMI
                        </h2>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4 items-start">
                        <!-- Col 1 (Items 1 - 4) -->
                        <div class="flex flex-col gap-4">
                            <div
                                v-for="(m, idx) in col1"
                                :key="idx"
                                class="flex items-center gap-5 rounded-2xl p-6 bg-[#151f34] border border-slate-800/90 shadow-xs hover:border-slate-700 transition-all"
                            >
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 font-black text-base bg-blue-600 text-white shadow-xs">
                                    {{ idx + 1 }}
                                </div>
                                <p class="text-sm leading-relaxed text-slate-300 font-normal">
                                    {{ m.text }}
                                </p>
                            </div>
                        </div>

                        <!-- Col 2 (Items 5 - 7) -->
                        <div class="flex flex-col gap-4">
                            <div
                                v-for="(m, idx) in col2"
                                :key="idx"
                                class="flex items-center gap-5 rounded-2xl p-6 bg-[#151f34] border border-slate-800/90 shadow-xs hover:border-slate-700 transition-all"
                            >
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 font-black text-base bg-blue-600 text-white shadow-xs">
                                    {{ midPoint + idx + 1 }}
                                </div>
                                <p class="text-sm leading-relaxed text-slate-300 font-normal">
                                    {{ m.text }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom CTA -->
                    <div class="mt-16 text-center">
                        <BaseButton
                            as="a"
                            :href="buildUrl('Halo Pelangi Glass, saya ingin konsultasi mengenai kaca mobil.')"
                            target="_blank"
                            rel="noopener noreferrer"
                            variant="primary"
                            size="lg"
                        >
                            Konsultasikan Kebutuhan Kaca Mobil Anda
                        </BaseButton>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
