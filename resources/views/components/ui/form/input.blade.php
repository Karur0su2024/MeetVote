<div class="mb-3">
    {{-- Popisek pole --}}
    <label for="{{ $id ?? '' }}"
           class="form-label">
        {{ $slot }}

        <x-ui.red-text>
            {{ $attributes->has('required') ? '*' : '' }}
        </x-ui.red-text>

        {{-- Tooltip pro popis pole --}}
        @if ($tooltip ?? null)
            <small class="ms-2">
                <x-ui.tooltip :tooltip="$tooltip" />
            </small>
        @endif
    </label>

    {{-- Input pole --}}
    <input
        type="{{ $type ?? 'text' }}"
        {{ $attributes }}
        class="form-control {{ $dataClass ?? '' }} @error($error ?? null) is-invalid @enderror"
        aria-label="{{ $slot }}"
        aria-required="{{ $attributes->has('required') ? 'true' : 'false' }}"
    />

    @error($error ?? null)
        {{-- Chybová hláška --}}
        <x-ui.red-text>
            {{ $message }}
        </x-ui.red-text>
    @enderror
</div>
