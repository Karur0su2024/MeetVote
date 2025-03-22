@props([
    'size' => 'md',
    'type' => 'button',
    'color' => 'primary',
    ])


<button type="{{  $type  }}"
        class="btn btn-{{ $color }} btn-{{ $size }} {{ $attributes->get('class') }}"
        {{ $attributes }}>
    {{ $slot }}
</button>
