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
                <x-ui.tooltip :tooltip="$tooltip" />
            </small>
        @endif
    </div>


    {{-- Input pole --}}
    <div class="input-group">
    <input
        type="{{ $type ?? 'text' }}"
        {{ $attributes }}
        class="form-control {{ $dataClass ?? '' }} @error($error ?? null) is-invalid @enderror"
        aria-label="{{ $slot }}"
        aria-required="{{ $attributes->has('required') ? 'true' : 'false' }}"
    />
        {{ $inputGroup ?? null }}
    </div>


    @error($error ?? null)
        {{-- Chybová hláška --}}
        <x-ui.red-text>
            {{ $message }}
        </x-ui.red-text>
    @enderror
</div>
