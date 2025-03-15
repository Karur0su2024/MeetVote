<div class="mb-3">

    {{-- Popisek pole --}}
    <label for="{{ $id ?? '' }}" class="form-label">
        {{ $slot }}
        <span class="text-danger">{{ $required ?? false ? '*' : '' }} </span>

        {{-- Tooltip pro popis pole --}}
        @if ($tooltip ?? null)
            <small class="ms-2">
                <i class="bi bi-question-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="{{ $tooltip }}"></i>
            </small>
        @endif
    </label>

    {{-- Input pole --}}
    <input type="{{ $type ?? 'text' }}" {{ $attributes }}
        class="form-control {{ $dataClass ?? '' }}">
</div>
