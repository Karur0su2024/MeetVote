@props([
    'margin' => 'mb-3', // Třída pro margin
    'id' => $attributes->get('id') ?? '',
])



<label class="label tw-text-sm mb-2">
    <input type="checkbox"
           checked="checked"
           class="tw-toggle tw-toggle-sm tw-me-1 tw-toggle-primary"
        {{ $attributes }}/>
    {{ $slot }}
    @if ($tooltip ?? null)
        <small class="ms-1">
            <x-ui.tooltip :tooltip="$tooltip"/>
        </small>
    @endif
</label>
