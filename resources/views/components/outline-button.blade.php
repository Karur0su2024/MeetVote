@props([
    'wireClick' => null,
    'type' => 'secondary',
    'class' => '',
])

<button type="button" @if ($wireClick) wire:click="{{ $wireClick }}" @endif
    class="btn btn-outline-{{ $type }} flex-fill {{ $class }}">
    {{ $slot }}
</button>
