@props(['error'])

@error($error)
    <span class="text-danger ms-3">{{ $message }}</span>
@enderror
