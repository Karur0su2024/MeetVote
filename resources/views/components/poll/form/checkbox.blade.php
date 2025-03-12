@props(['model', 'id', 'tooltip' => null])

<div class="form-check form-switch mb-3">
    <input type="checkbox" wire:model="{{ $model }}" id="{{ $id }}" class="form-check-input">
    <label class="form-check-label" for="{{ $id }}">{{ $slot }}


        @if ($tooltip)
            <small class="ms-2">
                <i class="bi bi-question-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="{{ $tooltip }}"></i>
            </small>
        @endif
    </label>
    @error($model)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
