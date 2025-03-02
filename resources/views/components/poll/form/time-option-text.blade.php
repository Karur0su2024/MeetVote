@props([
    'index',        // Index aktuálního data
    'timeIndex',    // Index časové možnosti v rámci data
])

<div class="d-flex align-items-center gap-2 mb-2">

    {{-- Pole pro zadání textové možnosti --}}
    <input type="text" wire:model="dates.{{ $index }}.options.{{ $timeIndex }}.text" class="form-control">
    
    {{-- Tlačítko pro odstranění textové možnosti --}}
    <button type="button" wire:click="removeTimeOption('{{ $index }}', '{{ $timeIndex }}')" class="btn btn-danger">
        X
    </button>

    {{-- Chybová hláška pro textové pole --}}
    @error("dates.{$index}.options.{$timeIndex}.text")
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
