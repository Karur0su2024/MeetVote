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
    <input type="{{ $type ?? 'text' }}"
        id="{{ $id }}"
        wire:model="{{ $model ?? '' }}"
        class="form-control {{ $class ?? '' }} @error($model) is-invalid @enderror"
        placeholder="{{ $placeholder ?? '' }}">

    {{-- Zobrazení chybové hlášky --}}
    @error($model)
        <span class="text-danger">{{ $message }}</span>
    @enderror

</div>
