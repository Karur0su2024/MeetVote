@props(['for'])

@error($for)
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
@enderror
