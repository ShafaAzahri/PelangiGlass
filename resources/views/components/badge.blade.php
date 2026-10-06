@props([
    'type' => 'Terlaris',
    'variant' => 'corner', // corner | pill
])

@php
    $gradient = match($type) {
        'Terlaris' => 'bg-gradient-to-r from-red-600 to-rose-600 shadow-rose-950/20',
        'Premium' => 'bg-gradient-to-r from-amber-600 via-amber-500 to-yellow-500 shadow-amber-950/20',
        'Baru' => 'bg-gradient-to-r from-blue-600 to-sky-500 shadow-blue-950/20',
        'Bergaransi', 'Hemat' => 'bg-gradient-to-r from-emerald-600 to-teal-500 shadow-emerald-950/20',
        default => 'bg-gradient-to-r from-red-600 to-rose-600 shadow-rose-950/20',
    };
@endphp

@if($variant === 'corner')
    <div {{ $attributes->merge(['class' => 'absolute top-0 left-0 z-10']) }}>
        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10.5px] font-extrabold uppercase tracking-wider text-white shadow-md rounded-br-xl select-none {{ $gradient }}"
              style="font-family: 'Plus Jakarta Sans', sans-serif;">
            @if($type === 'Terlaris')
                <svg class="w-3 h-3 fill-current text-white/95" viewBox="0 0 24 24"><path d="M12 2c.5 3 2 4.5 4 6 2.5 1.8 4 4.5 4 8a8 8 0 1 1-16 0c0-3.5 2-6.5 4.5-8.5C9.5 6 11 4.5 12 2z"/></svg>
            @elseif($type === 'Premium')
                <svg class="w-3 h-3 fill-current text-white/95" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            @elseif($type === 'Baru')
                <svg class="w-3 h-3 text-white/95" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            @else
                <svg class="w-3 h-3 text-white/95" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            @endif
            <span>{{ $slot->isEmpty() ? $type : $slot }}</span>
        </span>
    </div>
@else
    <span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 text-[11px] px-2.5 py-0.5 rounded-full font-bold shadow-sm tracking-wide text-white $gradient"]) }}
          style="font-family: 'Plus Jakarta Sans', sans-serif;">
        <span>{{ $slot->isEmpty() ? $type : $slot }}</span>
    </span>
@endif
