@props(['id', 'model', 'mandatory' => false, 'placeholder' => ''])

<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $slot }} <span
            class="text-danger">{{ $mandatory ? '*' : '' }} </span></label>
    <textarea wire:model="{{ $model }}" id="{{ $id }}" class="form-control" rows="5"></textarea>
    @error($model)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
