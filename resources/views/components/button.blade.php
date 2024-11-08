@props(['type' => 'button',
    'style' => 'primary',
    'size' => 'md',
    'class' => '',
    'wireclick' => null
    ])

<button type="{{ $type ?? 'button' }}" 
    class="btn btn-{{ $style}} btn-{{ $size }} {{ $class }}"
    @if($wireclick) wire:click="{{ $wireclick }}" 
    @endif
    >
    {{ $slot }}
</button>
