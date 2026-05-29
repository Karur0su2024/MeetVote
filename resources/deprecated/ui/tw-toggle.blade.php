@props([
    'id' => $attributes->get('id') ?? '',
])



<label class="label text-sm mb-2 align-items-center"
       for="{{ $id }}">
    <input type="checkbox"
           checked="checked"
           class="toggle toggle-sm me-1 toggle-primary"
        {{ $attributes }}/>
    {{ $slot }}
    @if ($tooltip ?? null)
        <small class="ms-1">
            <x-ui.tooltip :tooltip="$tooltip"/>
        </small>
    @endif
</label>
