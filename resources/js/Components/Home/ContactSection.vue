<script setup>
import { ref, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import BaseButton from '@/Components/UI/BaseButton.vue';
import { useWhatsApp } from '@/Composables/useWhatsApp';

const page = usePage();
const { displayPhone, cleanNumber } = useWhatsApp();

const address = computed(() => page.props.contact?.address || 'Purwokerto, Banyumas, Jawa Tengah');
const operationalHours = computed(() => page.props.contact?.operational_hours || 'Senin – Sabtu, 08.30 – 16.30 WIB');
const instagramUrl = computed(() => page.props.contact?.instagram || 'https://www.instagram.com/pelangiglassofficial');
const mapsEmbedUrl = computed(() => page.props.settings?.google_maps_embed || 'https://maps.google.com/maps?q=pelangi+glass+purwokerto&t=&z=15&ie=UTF8&iwloc=&output=embed');

const isSubmitted = ref(false);
const successText = ref('');

const form = useForm({
    name: '',
    email: '',
    phone_number: '',
    message: '',
    website_hp_field: '',
});

const submit = () => {
    form.post('/kontak', {
        preserveScroll: true,
        onSuccess: (page) => {
            isSubmitted.value = true;
            successText.value = page.props.flash?.success || 'Terima kasih! Pesan Anda telah berhasil terkirim ke sistem kami. Tim Pelangi Glass akan segera menghubungi Anda.';
            form.reset('name', 'email', 'phone_number', 'message');
        },
    });
};
</script>

<template>
    <section id="kontak" class="py-24 bg-slate-100 dark:bg-slate-950 transition-colors">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12 items-start mb-10">
                <!-- Info Kolom Kiri -->
                <div>
                    <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3 text-blue-600 dark:text-blue-400">
                        Kontak
                    </div>
                    <h2 class="uppercase mb-6 text-slate-900 dark:text-slate-100 text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight tracking-tight">
                        Siap Melayani<br />Anda Hari Ini
                    </h2>
                    <p class="text-sm leading-relaxed mb-8 text-slate-600 dark:text-slate-400">
                        Hubungi kami untuk Konsultasi Gratis. Tim spesialis kami siap membantu permasalahan kaca kendaraan Anda.
                    </p>

                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="mt-0.5 shrink-0 w-9 h-9 rounded-full flex items-center justify-center bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                            </div>
                            <div>
                                <div class="text-xs uppercase tracking-widest mb-0.5 text-slate-400 dark:text-slate-500">Alamat Workshop</div>
                                <div class="text-sm text-slate-900 dark:text-slate-100">
                                    {{ address }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="mt-0.5 shrink-0 w-9 h-9 rounded-full flex items-center justify-center bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                            </div>
                            <div>
                                <div class="text-xs uppercase tracking-widest mb-0.5 text-slate-400 dark:text-slate-500">Telepon / WhatsApp</div>
                                <div class="text-sm text-slate-900 dark:text-slate-100">
                                    <a :href="`https://wa.me/${cleanNumber}`" target="_blank" rel="noopener noreferrer" class="hover:text-blue-600 dark:hover:text-blue-400 transition no-underline text-inherit font-semibold">
                                        {{ displayPhone }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="mt-0.5 shrink-0 w-9 h-9 rounded-full flex items-center justify-center bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
                            </div>
                            <div>
                                <div class="text-xs uppercase tracking-widest mb-0.5 text-slate-400 dark:text-slate-500">Jam Operasional</div>
                                <div class="text-sm text-slate-900 dark:text-slate-100">
                                    {{ operationalHours }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="mt-0.5 shrink-0 w-9 h-9 rounded-full flex items-center justify-center bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.5" cy="6.5" r="0.5" fill="currentColor"></circle></svg>
                            </div>
                            <div>
                                <div class="text-xs uppercase tracking-widest mb-0.5 text-slate-400 dark:text-slate-500">Instagram</div>
                                <div class="text-sm text-slate-900 dark:text-slate-100">
                                    <a :href="instagramUrl" target="_blank" rel="noopener noreferrer" class="hover:text-blue-600 dark:hover:text-blue-400 transition no-underline text-inherit">
                                        @pelangiglassofficial
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Kirim Pesan -->
                <div class="rounded-2xl p-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xl">
                    <h3 class="font-bold mb-1 text-slate-900 dark:text-slate-100 text-lg">
                        Kirim Pesan & Konsultasi
                    </h3>
                    <p class="text-xs mb-6 text-slate-400 dark:text-slate-500">
                        Isi formulir di bawah ini. Pesan Anda akan langsung masuk ke sistem kami.
                    </p>

                    <!-- Flash Message -->
                    <!-- Flash Success Message -->
                    <div v-if="isSubmitted || page.props.flash?.success" class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-200 border border-emerald-200 dark:border-emerald-800 animate-fade-up">
                        <div class="flex items-center gap-2 font-bold text-sm mb-1">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                            <span>Pesan Berhasil Terkirim!</span>
                        </div>
                        <p class="text-xs text-emerald-700 dark:text-emerald-300 leading-relaxed mb-3">
                            {{ successText || page.props.flash?.success }}
                        </p>
                        <a
                            :href="`https://wa.me/${cleanNumber}?text=Halo%20Pelangi%20Glass%2C%20saya%20sudah%20mengirim%20pesan%20melalui%20website.`"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold no-underline transition shadow-xs"
                        >
                            <span>Atau Langsung Chat via WhatsApp</span>
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    </div>

                    <form @submit.prevent="submit" class="flex flex-col gap-4">
                        <input type="text" v-model="form.website_hp_field" class="hidden" tabindex="-1" autocomplete="off">

                        <div>
                            <label class="block text-xs font-medium mb-1.5 text-slate-700 dark:text-slate-300">
                                Nama Lengkap
                            </label>
                            <input
                                type="text"
                                v-model="form.name"
                                required
                                placeholder="Contoh: Budi Santoso"
                                class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition-all border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:border-blue-600 dark:focus:border-blue-500"
                            >
                            <span v-if="form.errors.name" class="text-xs text-rose-500 mt-1 block">{{ form.errors.name }}</span>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5 text-slate-700 dark:text-slate-300">
                                Email (Opsional)
                            </label>
                            <input
                                type="email"
                                v-model="form.email"
                                placeholder="nama@email.com"
                                class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition-all border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:border-blue-600 dark:focus:border-blue-500"
                            >
                            <span v-if="form.errors.email" class="text-xs text-rose-500 mt-1 block">{{ form.errors.email }}</span>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5 text-slate-700 dark:text-slate-300">
                                No HP / WhatsApp
                            </label>
                            <input
                                type="tel"
                                v-model="form.phone_number"
                                required
                                placeholder="08xxxxxxxxxx"
                                class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition-all border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:border-blue-600 dark:focus:border-blue-500"
                            >
                            <span v-if="form.errors.phone_number" class="text-xs text-rose-500 mt-1 block">{{ form.errors.phone_number }}</span>
                        </div>

                        <div>
                            <label class="block text-xs font-medium mb-1.5 text-slate-700 dark:text-slate-300">
                                Pesan / Kebutuhan Kaca
                            </label>
                            <textarea
                                v-model="form.message"
                                required
                                placeholder="Ceritakan kondisi kaca mobil Anda atau layanan yang dibutuhkan..."
                                rows="4"
                                class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition-all resize-none border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:border-blue-600 dark:focus:border-blue-500"
                            ></textarea>
                            <span v-if="form.errors.message" class="text-xs text-rose-500 mt-1 block">{{ form.errors.message }}</span>
                        </div>

                        <BaseButton
                            type="submit"
                            variant="primary"
                            size="md"
                            :loading="form.processing"
                            class="w-full mt-2"
                        >
                            Kirim Pesan Sekarang
                        </BaseButton>
                    </form>
                </div>
            </div>

            <!-- Google Maps Embed -->
            <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800">
                <iframe
                    title="Lokasi Pelangi Glass Purwokerto"
                    :src="mapsEmbedUrl"
                    width="100%"
                    height="300"
                    style="border: 0; display: block;"
                    allowfullscreen
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
                <div class="px-5 py-4 flex items-center justify-between bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800">
                    <div>
                        <div class="text-xs uppercase tracking-widest mb-0.5 text-slate-400 dark:text-slate-500">
                            Lokasi Workshop
                        </div>
                        <div class="text-sm text-slate-900 dark:text-slate-100 font-medium">
                            {{ address }}
                        </div>
                    </div>
                    <a
                        href="https://maps.google.com/?q=pelangi+glass+purwokerto"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex items-center gap-1.5 text-xs font-semibold text-blue-600 dark:text-blue-400 hover:opacity-80 transition-all shrink-0 ml-4 no-underline"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                        <span>Buka di Google Maps</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>
