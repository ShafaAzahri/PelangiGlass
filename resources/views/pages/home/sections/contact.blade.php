<section id="kontak" class="py-24 bg-slate-100 dark:bg-slate-950 transition-colors">
    <div class="max-w-6xl mx-auto px-6">
        <!-- Top grid: info + form -->
        <div class="grid md:grid-cols-2 gap-12 items-start mb-10">
            <!-- Info -->
            <div>
                <div class="text-xs font-semibold tracking-[0.2em] uppercase mb-3 text-blue-600 dark:text-blue-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Kontak
                </div>
                <h2 class="uppercase mb-6 text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 800; line-height: 1.05;">
                    Siap Melayani<br />Anda Hari Ini
                </h2>
                <p class="text-sm leading-relaxed mb-8 text-slate-600 dark:text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Hubungi kami untuk Konsultasi Gratis. Tim kami siap membantu Senin hingga Jumat.
                </p>

                <div class="space-y-5">
                    <div class="flex items-start gap-4">
                        <div class="mt-0.5 shrink-0 w-9 h-9 rounded-full flex items-center justify-center bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <div class="text-xs uppercase tracking-widest mb-0.5 text-slate-400 dark:text-slate-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">Alamat</div>
                            <div class="text-sm text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $siteSettings['address'] ?? \App\Models\Setting::get('address', 'Purwokerto, Banyumas, Jawa Tengah') }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="mt-0.5 shrink-0 w-9 h-9 rounded-full flex items-center justify-center bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400">
                            <i data-lucide="phone" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <div class="text-xs uppercase tracking-widest mb-0.5 text-slate-400 dark:text-slate-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">Telepon / WA</div>
                            <div class="text-sm text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                <a href="https://wa.me/{{ \App\Models\Setting::cleanWhatsapp() }}" target="_blank" rel="noopener noreferrer" class="hover:text-blue-600 dark:hover:text-blue-400 transition no-underline text-inherit">
                                    {{ $siteSettings['phone_display'] ?? \App\Models\Setting::get('phone_display', '0813-9028-8875') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="mt-0.5 shrink-0 w-9 h-9 rounded-full flex items-center justify-center bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <div class="text-xs uppercase tracking-widest mb-0.5 text-slate-400 dark:text-slate-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">Jam Buka</div>
                            <div class="text-sm text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $siteSettings['operational_hours'] ?? \App\Models\Setting::get('operational_hours', 'Senin – Jumat, 08.30 – 16.30 WIB') }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="mt-0.5 shrink-0 w-9 h-9 rounded-full flex items-center justify-center bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.5" cy="6.5" r="0.5" fill="currentColor"></circle></svg>
                        </div>
                        <div>
                            <div class="text-xs uppercase tracking-widest mb-0.5 text-slate-400 dark:text-slate-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">Instagram</div>
                            <div class="text-sm text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                <a href="{{ $siteSettings['instagram'] ?? \App\Models\Setting::get('instagram', 'https://www.instagram.com/pelangiglassofficial') }}" target="_blank" rel="noopener noreferrer" class="hover:text-blue-600 dark:hover:text-blue-400 transition no-underline text-inherit">
                                    @pelangiglassofficial
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="rounded-2xl p-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xl">
                <h3 class="font-bold mb-1 text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.1rem;">
                    Kirim Pesan
                </h3>
                <p class="text-xs mb-6 text-slate-400 dark:text-slate-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Isi formulir di bawah ini. Pesan Anda akan langsung masuk ke sistem admin kami.
                </p>

                @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200">
                        <div class="flex items-center gap-2 font-bold text-sm mb-1">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                            <span>Pesan Berhasil Terkirim!</span>
                        </div>
                        <p class="text-xs text-emerald-700 leading-relaxed mb-3">
                            {{ session('success') }}
                        </p>
                        @if(session('wa_url'))
                            <a href="{{ session('wa_url') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold no-underline transition shadow-xs">
                                <span>Atau Langsung Chat via WhatsApp</span>
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                        @endif
                    </div>
                @endif

                <form action="{{ route('inquiries.store') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <input type="text" name="website_hp_field" class="hidden" tabindex="-1" autocomplete="off">

                    <div>
                        <label class="block text-xs font-medium mb-1.5 text-slate-700 dark:text-slate-300" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            Nama Lengkap
                        </label>
                        <input type="text" name="name" required placeholder="Contoh: Budi Santoso" value="{{ old('name') }}" class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition-all border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:border-blue-600 dark:focus:border-blue-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        @error('name')
                            <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1.5 text-slate-700 dark:text-slate-300" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            Email
                        </label>
                        <input type="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition-all border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:border-blue-600 dark:focus:border-blue-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        @error('email')
                            <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1.5 text-slate-700 dark:text-slate-300" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            No HP / WhatsApp
                        </label>
                        <input type="tel" name="phone_number" required placeholder="08xxxxxxxxxx" value="{{ old('phone_number') }}" class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition-all border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:border-blue-600 dark:focus:border-blue-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        @error('phone_number')
                            <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium mb-1.5 text-slate-700 dark:text-slate-300" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            Pesan
                        </label>
                        <textarea name="message" required placeholder="Ceritakan kondisi kaca mobil Anda atau layanan yang dibutuhkan..." rows="4" class="w-full px-4 py-2.5 rounded-xl text-sm outline-none transition-all resize-none border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:border-blue-600 dark:focus:border-blue-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ old('message') }}</textarea>
                        @error('message')
                            <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90 cursor-pointer border-0 shadow-xs" style="background: #2563eb; font-family: 'Plus Jakarta Sans', sans-serif;">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>

        <!-- Map full width -->
        <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800">
            <iframe title="Lokasi Pelangi Glass Purwokerto" src="{{ $siteSettings['google_maps_embed'] ?? \App\Models\Setting::get('google_maps_embed', 'https://maps.google.com/maps?q=pelangi+glass+purwokerto&t=&z=15&ie=UTF8&iwloc=&output=embed') }}" width="100%" height="300" style="border: 0; display: block;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <div class="px-5 py-4 flex items-center justify-between bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800">
                <div>
                    <div class="text-xs uppercase tracking-widest mb-0.5 text-slate-400 dark:text-slate-500" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Lokasi
                    </div>
                    <div class="text-sm text-slate-900 dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ $siteSettings['address'] ?? \App\Models\Setting::get('address', 'Purwokerto, Banyumas, Jawa Tengah') }}
                    </div>
                </div>
                <a href="https://maps.google.com/?q=pelangi+glass+purwokerto" target="_blank" rel="noopener noreferrer" class="flex items-center gap-1.5 text-xs font-medium transition-all hover:opacity-70 shrink-0 ml-4 no-underline" style="color: #2563eb; font-family: 'Plus Jakarta Sans', sans-serif;">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                    Buka di Maps
                </a>
            </div>
        </div>
    </div>
</section>
