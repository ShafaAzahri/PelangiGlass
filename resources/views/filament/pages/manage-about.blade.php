<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="mt-6 flex items-center justify-start gap-3">
            <x-filament::button type="submit" size="lg">
                Simpan Perubahan Konten
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
