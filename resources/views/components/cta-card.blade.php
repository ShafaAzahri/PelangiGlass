@props([
    'message' => 'Produk tidak ada di daftar? Hubungi kami, kami bisa bantu carikan.',
    'buttonLabel' => 'Hubungi Kami',
    'whatsappText' => 'Halo Pelangi Glass, saya ingin konsultasi.',
])

<div {{ $attributes->merge(['class' => 'mt-12 rounded-2xl p-8 text-center bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs']) }}>
    <p class="text-sm mb-4 text-slate-600 dark:text-slate-400" style="font-family: 'Plus Jakarta Sans', sans-serif;">
        {{ $message }}
    </p>
    <x-whatsapp-button :text="$whatsappText" :label="$buttonLabel" variant="pill" />
</div>
