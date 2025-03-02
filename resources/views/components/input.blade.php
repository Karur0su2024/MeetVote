<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }} *</label>
    <input type="{{ $type }}" id="{{ $id }}" wire:model="{{ $model }}" class="form-control">
    @error($model)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
