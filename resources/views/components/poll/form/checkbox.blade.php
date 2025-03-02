<div class="form-check">
    <input type="checkbox" wire:model="{{ $model }}" id="{{ $id }}" class="form-check-input">
    <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
    @error($model) <span class="text-danger">{{ $message }}</span> @enderror
</div>