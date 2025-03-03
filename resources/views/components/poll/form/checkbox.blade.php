<div class="form-check form-switch mb-3">
    <input type="checkbox" wire:model="{{ $model }}" id="{{ $id }}" class="form-check-input">
    <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
    @error($model) <span class="text-danger">{{ $message }}</span> @enderror
</div>