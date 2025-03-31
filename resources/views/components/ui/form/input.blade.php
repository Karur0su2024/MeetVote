@props([
    'type' => 'text', // Typ inputu
    'tooltip' => null, // Slout pro popis pole (nepovinné)
    'dataClass' => null, // Další třídy pro input (přejmenovat na inputClass)
    'inputGroup' => null, // Slot pro input group (nepovinné)
    'xError' => null, // Chybová hláška pro inputy používající Alpine.js (jinak řešeno automaticky u Livewire)
]);

@php
    $inputClass = $dataClass;
@endphp


<div class="mb-3">
    {{-- Popisek pole --}}
    <div class="d-flex">
        <label for="{{ $id ?? '' }}"
               class="form-label">
            {{ $slot }}

            <x-ui.red-text>
                {{ $attributes->has('required') ? '*' : '' }}
            </x-ui.red-text>
        </label>
        {{-- Tooltip pro popis pole --}}
        @if ($tooltip ?? null)
            <small class="ms-2">
                <x-ui.tooltip :tooltip="$tooltip"/>
            </small>
        @endif
    </div>


    {{-- Input pole --}}
    <div class="input-group">
        <input
            type="{{ $type ?? 'text' }}"
            {{ $attributes }}
            class="form-control {{ $attributes->get['class'] ?? '' }}
                {{ $dataClass ?? '' }}
                    @error($attributes->get('wire:model') ?? '') is-invalid @enderror
                    @error($xError ?? '') is-invalid @enderror"
            aria-label="{{ $slot }}"
            aria-required="{{ $attributes->has('required') ? 'true' : 'false' }}"
        />
        {{ $inputGroup ?? null }}
    </div>


    @if($attributes->get('wire:model'))
        <x-ui.form.error-text margin="ms-0" :error="$attributes->get('wire:model')"/>
    @endif

    @if($xError ?? '')
        <x-ui.form.error-text margin="ms-0" :error="$xError"/>
    @endif


    {{-- Chybová hláška --}}
</div>
