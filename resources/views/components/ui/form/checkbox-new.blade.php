@props([
    'margin' => 'mb-3', // Třída pro margin
    'id' => $attributes->get('id') ?? '',
])


<label class="label">
    <input type="checkbox" class="checkbox checkbox-primary" {{ $attributes }} />
    {{ $slot }}
    @if ($tooltip ?? null)
        <x-ui.tooltip-new>
            {{ $tooltip }}
        </x-ui.tooltip-new>
    @endif
</label>
