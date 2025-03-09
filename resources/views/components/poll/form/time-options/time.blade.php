@props([
    'dateIndex', // Index aktuálního data
    'optionIndex', // Index aktuální možnosti
])

<div class="p-2 mb-2 bg-light rounded border">
    <!-- Zobrazení časového intervalu -->
    <div class="d-flex align-items-center gap-2">
        {{-- Pole pro zadání začátku časového intervalu  --}}
        <input type="time" wire:model="form.dates.{{ $dateIndex }}.{{ $optionIndex }}.content.start"
            class="form-control">

        {{-- Pole pro zadání konce časového intervalu --}}
        <input type="time" wire:model="form.dates.{{ $dateIndex }}.{{ $optionIndex }}.content.end"
            class="form-control">

        {{-- Tlačítko pro odstranění časové možnosti --}}
        <button type="button" wire:click="removeTimeOption('{{ $dateIndex }}', '{{ $optionIndex }}')"
            class="btn btn-danger">
            <i class="bi bi-trash"></i>
        </button>
    </div>

    {{-- Chybové hlášky pro začátek a konec časového intervalu --}}
    @error("form.dates.{{ $dateIndex }}.{{ $optionIndex }}.content.start")
        <span class="text-danger">{{ $message }}</span>
    @enderror

    @error("form.dates.{{ $dateIndex }}.{{ $optionIndex }}.content.end")
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
