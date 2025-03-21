@props(['for'])

@error($for)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror


@if($errors->has($for))
    <div class="invalid-feedback">
        {{ $errors->first($for) }}
    </div>
@endif
