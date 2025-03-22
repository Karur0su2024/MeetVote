@props([
    'size' => 'md',
    'type' => 'button',
    'color' => 'primary',
    ])


<button type="{{  $type  }}"
        class="btn btn-{{ $color }} btn-{{ $size }} w-50 mx-auto {{ $attributes->get('class') }}"
        {{ $attributes }}>
    {{ $slot }}
</button>
