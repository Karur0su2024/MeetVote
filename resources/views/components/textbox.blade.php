<div class="mb-3">

    <label for="{{ $id ?? '' }}" class="form-label">
        {{ $slot }}
        <span class="text-danger">{{ $required ?? false ? '*' : '' }} </span>
        @if ($tooltip ?? null)
            <small class="ms-2">
                <i class="bi bi-question-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="{{ $tooltip }}"></i>
            </small>
        @endif
    </label>


    <textarea
        id="{{ $id ?? '' }}"
        wire:model="{{ $model }}"
        class="form-control {{ $class ?? '' }} @error($model) is-invalid @enderror"
        rows="{{ $rows ?? 5 }}"
    ></textarea>

    @error($model)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
