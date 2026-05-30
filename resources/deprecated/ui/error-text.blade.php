@props(['error', 'margin' => 'mb-3'])

@error($error)
    <span class="tw:text-error {{ $margin }}">{{ $message }}</span>
@enderror
