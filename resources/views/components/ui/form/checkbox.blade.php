@props([
    'margin' => 'mb-3', // Třída pro margin
    'id' => $attributes->get('id') ?? '',
])


<div class="d-flex">
    <div class="form-check form-switch {{ $margin }}">
        <input
            type="checkbox"
            {{ $attributes }}
            id="{{ $id }}"
            class="form-check-input">

        <label
            class="form-check-label ms-1"
            for="{{ $id }}">
            {{ $slot }}
        </label>
    </div>
    @if ($tooltip ?? null)
        <small class="ms-2">
            <x-ui.tooltip :tooltip="$tooltip"/>
        </small>
    @endif
</div>
