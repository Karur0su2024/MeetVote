@props([
    'dateIndex', // Index aktuálního data
    'timeIndex', // Index časové možnosti
])

<div>

    <div class="d-flex align-items-center gap-2 mb-2">


        <!-- Pole pro zadání začátku časového intervalu -->
        <input type="time" wire:model="dates.{{ $dateIndex }}.options.{{ $timeIndex }}.start"
            class="form-control">

        <!-- Pole pro zadání konce časového intervalu -->
        <input type="time" wire:model="dates.{{ $dateIndex }}.options.{{ $timeIndex }}.end" class="form-control">

        <!-- Tlačítko pro odstranění časové možnosti -->
        <button type="button" wire:click="removeDateOption('{{ $dateIndex }}', '{{ $timeIndex }}')"
            class="btn btn-danger">
            X
        </button>
    </div>

    <!-- Chybové hlášky pro začátek a konec časového intervalu -->
    <!-- Nefunguje a potřebuje opravit -->
    @error("dates.{{ $dateIndex }}.options.{{ $timeIndex }}.start")
        <span class="text-danger">{{ $message }}</span>
    @enderror

    @error("dates.{{ $dateIndex }}.options.{{ $timeIndex }}.end")
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
