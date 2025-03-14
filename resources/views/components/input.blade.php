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
        @if($alpine ?? null) x-model="{{ $alpine }}" @endif
        @if($model ?? null) wire:model="{{ $model }}" @endif
        class="form-control {{ $class ?? '' }}"
        placeholder="{{ $placeholder ?? '' }}">

    {{-- Zobrazení chybové hlášky --}}

    @if($model ?? null)

        @error($model)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    @endif

</div>
