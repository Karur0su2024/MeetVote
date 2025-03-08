@props([
    'dateIndex', // Index aktuálního data
    'timeIndex', // Index časové možnosti
])

<div>

    <div class="d-flex align-items-center gap-2 mb-2">

        {{-- Pole pro zadání začátku časového intervalu  --}}
        <input type="time" wire:model="form.dates.{{ $dateIndex }}.{{ $timeIndex }}.content.start"
            class="form-control">

        {{-- Pole pro zadání konce časového intervalu --}}
        <input type="time" wire:model="form.dates.{{ $dateIndex }}.{{ $timeIndex }}.content.end" class="form-control">

        {{-- Tlačítko pro odstranění časové možnosti --}}
        <button type="button" wire:click="removeTimeOption('{{ $dateIndex }}', '{{ $timeIndex }}')"
            class="btn btn-danger">
            X
        </button>
    </div>

    {{-- Chybové hlášky pro začátek a konec časového intervalu --}}
    {{-- Nefunguje a potřebuje opravit --}}
    @error("dates.{{ $dateIndex }}.options.{{ $timeIndex }}.content.start")
        <span class="text-danger">{{ $message }}</span>
    @enderror

    @error("dates.{{ $dateIndex }}.options.{{ $timeIndex }}.content.end")
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
