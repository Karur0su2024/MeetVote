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


    <textarea {{ $attributes }}
              class="form-control {{ $dataClass ?? '' }} "
              rows="5">

    </textarea>

    @if($error ?? null)
        @error($error)
        <span class="text-danger mt-2">
            {{ $message }}
        </span>
        @enderror
    @endif

</div>
