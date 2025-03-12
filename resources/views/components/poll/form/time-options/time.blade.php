@props(['dateIndex', 'optionIndex', 'exists' => false])

<div class="p-2 mb-2 bg-{{ $exists ? 'light' : '' }} rounded border">
    <!-- Zobrazení časového intervalu -->
    <div class="d-flex flex-wrap flex-md-nowrap align-items-between gap-2">
        {{-- Pole pro zadání začátku časového intervalu  --}}
        <input type="time" wire:model="form.dates.{{ $dateIndex }}.{{ $optionIndex }}.content.start"
            class="form-control w-100 w-md-auto">

        {{-- Pole pro zadání konce časového intervalu --}}
        <input type="time" wire:model="form.dates.{{ $dateIndex }}.{{ $optionIndex }}.content.end"
            class="form-control w-100 w-md-auto">

        {{-- Tlačítko pro odstranění časové možnosti --}}
        <button type="button" wire:click="removeTimeOption('{{ $dateIndex }}', '{{ $optionIndex }}')"
            class="btn btn-danger mx-auto">

            <i class="bi bi-trash"></i><span class="d-md-none ms-1">Delete</span>
        </button>
    </div>

    {{-- Chybové hlášky pro začátek a konec časového intervalu --}}
    @error("form.dates.{{ $dateIndex }}.{{ $optionIndex }}.content.*")
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
