@props([
    'type' => 'text', 
    'label' => 'Label', 
    'name' => 'name', 
    'id' => 'id', 
    'model' => '',
    'required' => false
    ])

<div class="mb-3">
    <label class="form-label mb-1" for="{{ $id }}"> {{ $label }}</label>
    
    <input class="form-control" type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" wire:model="{{ $model }}"
    {{ $required ? "required" : "" }} >
    @error($model)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>