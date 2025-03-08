@props([
    'dateIndex', // Index aktuálního data
    'timeIndex', // Index časové možnosti v rámci data
])

<div>

    <div class="d-flex align-items-center gap-2 mb-2">
        <!-- Pole pro zadání textové možnosti -->
        <input type="text" wire:model="form.dates.{{ $dateIndex }}.{{ $timeIndex }}.content.text" class="form-control" placeholder="Option {{ $timeIndex + 1 }}">

        <!-- Tlačítko pro odstranění textové možnosti -->
        <button type="button" wire:click="removeTimeOption('{{ $dateIndex }}', '{{ $timeIndex }}')"
            class="btn btn-danger">
            X
        </button>
    </div>


    <!-- Chybová hláška pro textové pole -->
    @error("dates.{$dateIndex}.options.{$timeIndex}.text")
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
