@props([
    'text' => 'Halo Pelangi Glass, saya ingin konsultasi.',
    'label' => 'Hubungi Kami',
    'phone' => null,
    'variant' => 'primary', // primary | outline | red | pill | float
    'icon' => true,
])

@php
    $href = \App\Models\Setting::whatsappUrl($text, $phone);

    $baseClasses = 'inline-flex items-center justify-center gap-2 rounded-xl font-semibold transition-all no-underline';

    $variantClasses = match($variant) {
        'primary' => 'bg-blue-700 hover:bg-blue-800 text-white shadow-xs hover:scale-[1.02] active:scale-95 py-2.5 px-4 text-xs',
        'outline' => 'border-2 border-blue-600 text-blue-600 hover:bg-blue-50 active:scale-95 py-2 px-4 text-xs',
        'red' => 'bg-red-600 hover:bg-red-700 text-white shadow-sm hover:shadow-md active:scale-95 py-2 px-4 text-xs',
        'pill' => 'px-6 py-3 rounded-full text-sm font-semibold text-white bg-blue-700 hover:bg-blue-800 shadow-md hover:scale-105 active:scale-95',
        'float' => 'fixed bottom-6 right-6 z-50 px-5 py-3 rounded-full shadow-xl hover:scale-105 active:scale-95 text-white font-semibold text-sm hover:bg-blue-700 bg-blue-600',
        default => 'bg-blue-700 hover:bg-blue-800 text-white py-2.5 px-4 text-xs',
    };
@endphp

<a href="{{ $href }}"
   target="_blank"
   rel="noopener noreferrer"
   {{ $attributes->merge(['class' => "$baseClasses $variantClasses"]) }}
   style="font-family: 'Plus Jakarta Sans', sans-serif;">
    @if($icon)
        <x-icons.whatsapp class="w-4 h-4 shrink-0" />
    @endif
    <span>{{ $slot->isEmpty() ? $label : $slot }}</span>
</a>
