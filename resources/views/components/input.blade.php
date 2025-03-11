@props(['id', 'label', 'model', 'type' => 'text', 'mandatory' => false, 'required' => false, 'placeholder' => ''])

<div class="mb-3">
    <label for="{{ $id }}" class="form-label">
        {{ $slot }}
        <span class="text-danger">{{ $required ? '*' : '' }} </span></label>
    <input type="{{ $type }}" id="{{ $id }}" wire:model="{{ $model }}" class="form-control">
    @error($model)
        <span class="text-danger">{{ $message }}</span>
    @enderror

</div>
