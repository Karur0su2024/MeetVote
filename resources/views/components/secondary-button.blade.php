@props([
    'wireClick' => null,
])

<button type="button"
    @if ($wireClick)
        wire:click="{{ $wireClick }}"
    @endif
    class="btn btn-outline-secondary flex-fill">
    {{ $slot }}
</button>
