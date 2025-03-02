@props([
    'index',        // Index aktuálního data
    'timeIndex',    // Index časové možnosti v rámci data
])

<div class="d-flex align-items-center gap-2 mb-2">

    {{-- Pole pro zadání začátku časového intervalu --}}
    <input type="time" wire:model="dates.{{ $index }}.options.{{ $timeIndex }}.start" class="form-control">
    
    {{-- Pole pro zadání konce časového intervalu --}}
    <input type="time" wire:model="dates.{{ $index }}.options.{{ $timeIndex }}.end" class="form-control">
    
    {{-- Tlačítko pro odstranění časové možnosti --}}
    <button type="button" wire:click="removeTimeOption('{{ $index }}', '{{ $timeIndex }}')" class="btn btn-danger">
        X
    </button>

    {{-- Chybové hlášky pro začátek a konec časového intervalu --}}
    @error("dates.{$index}.options.{$timeIndex}.start")
        <span class="text-danger">{{ $message }}</span>
    @enderror
    @error("dates.{$index}.options.{{ $timeIndex }}.end")
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
