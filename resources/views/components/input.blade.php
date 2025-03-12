@props([
    'id',
    'label',
    'model',
    'type' => 'text',
    'mandatory' => false,
    'required' => false,
    'placeholder' => '',
    'tooltip' => null,
])

<div class="mb-3">
    <label for="{{ $id }}" class="form-label">
        {{ $slot }}
        <span class="text-danger">{{ $required ? '*' : '' }} </span>
        @if ($tooltip)
            <small class="ms-2">
                <i class="bi bi-question-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="{{ $tooltip }}"></i>
            </small>
        @endif
    </label>
    <input type="{{ $type }}" id="{{ $id }}" wire:model="{{ $model }}" class="form-control">
    @error($model)
        <span class="text-danger">{{ $message }}</span>
    @enderror

</div>
