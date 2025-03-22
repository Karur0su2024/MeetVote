<div class="mb-3">
    {{-- Popisek pole --}}
    <label for="{{ $id ?? '' }}"
           class="form-label">
        {{ $slot }}
        <x-ui.red-text>
            {{ $required ?? false ? '*' : '' }}
        </x-ui.red-text>

        {{-- Tooltip pro popis pole --}}
        @if ($tooltip ?? null)
            <small class="ms-2">
                <i class="bi bi-question-circle-fill"
                   data-bs-toggle="tooltip"
                   data-bs-placement="top"
                   data-bs-title="{{ $tooltip }}">
                </i>
            </small>
        @endif
    </label>

    {{-- Input pole --}}
    <input
        type="{{ $type ?? 'text' }}"
        {{ $attributes }}
        class="form-control {{ $dataClass ?? '' }} @error($error ?? null) is-invalid @enderror"
    />

    @error($error ?? null)
        {{-- Chybová hláška --}}
        <x-ui.red-text>
            {{ $message }}
        </x-ui.red-text>
    @enderror
</div>
