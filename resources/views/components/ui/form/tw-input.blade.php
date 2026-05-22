@props([
    'label' => null, // Popisek pole
    'type' => 'text', // Typ inputu
    'tooltip' => null, // Slout pro popis pole (nepovinné)
    'xError' => null, // Chybová hláška pro inputy používající Alpine.js (jinak řešeno automaticky u Livewire)
])

<fieldset class="tw-fieldset mb-2" >
    <label class="tw-fieldset-legend pb-1">
        {{ $label ?? '' }}
{{--        <x-ui.red-text>--}}
{{--            {{ $attributes->has('required') ? '*' : '' }}--}}
{{--        </x-ui.red-text>--}}
{{--        @if ($tooltip ?? null)--}}
{{--            <small class="ms-2">--}}
{{--                <x-ui.tooltip :tooltip="$tooltip"/>--}}
{{--            </small>--}}
{{--        @endif--}}
    </label>
    <input type="{{ $type }}"
           class="tw-input w-100"
           {{ $attributes->get('class') ?? '' }}
           aria-label="{{ $label ?? '' }}"
           aria-required="{{ $attributes->has('required') ? 'true' : 'false' }}"
           {{ $attributes }}
    />

    @if($attributes->get('wire:model'))
        <x-ui.form.error-text margin="ms-0" :error="$attributes->get('wire:model')"/>
    @endif

    @if($xError ?? '')
        <x-ui.form.error-text margin="ms-0" :error="$xError"/>
    @endif

</fieldset>
