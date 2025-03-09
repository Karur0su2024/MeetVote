@props([
    'wireClick' => null,
    'type' => 'secondary',
])

<button type="button" @if ($wireClick) wire:click="{{ $wireClick }}" @endif
    class="btn btn-outline-{{ $type }} flex-fill">
    {{ $slot }}
</button>
