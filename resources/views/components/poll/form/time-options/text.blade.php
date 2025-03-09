@props(['dateIndex', 'optionIndex', 'exists' => false])

<div class="p-2 mb-2 bg-{{ $exists ? 'light' : '' }} rounded border">
    <div class="d-flex align-items-center gap-2 }}">
        <!-- Pole pro zadání textové možnosti -->
        <input type="text" wire:model="form.dates.{{ $dateIndex }}.{{ $optionIndex }}.content.text"
            class="form-control" placeholder="Option {{ $optionIndex + 1 }}">

        <!-- Tlačítko pro odstranění textové možnosti -->
        <button type="button" wire:click="removeTimeOption('{{ $dateIndex }}', '{{ $optionIndex }}')"
            class="btn btn-danger">
            <i class="bi bi-trash"></i>
        </button>
    </div>

    <!-- Chybová hláška pro textové pole -->
    @error("form.dates.{$dateIndex}.{$optionIndex}.content.text")
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
