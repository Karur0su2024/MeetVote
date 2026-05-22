@props([
    'id' => $attributes->get('id') ?? '',
])



<label class="label tw-text-sm tw-mb-2 tw-align-items-center"
       for="{{ $id }}">
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
