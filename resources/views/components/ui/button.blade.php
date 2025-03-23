@props([
    'size' => 'md',
    'type' => 'button',
    'color' => 'primary',
    'disabled' => false,
    ])


<button type="{{  $type  }}"
        class="btn btn-{{ $color }}
               btn-{{ $size }}
               {{ $disabled ? 'disabled' : '' }}
               {{ $attributes->get('class') }}"
        {{ $attributes }}>
    {{ $slot }}
</button>
