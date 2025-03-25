@props(['error', 'margin' => 'mb-3'])

@error($error)
    <span class="text-danger {{ $margin }}">{{ $message }}</span>
@enderror
