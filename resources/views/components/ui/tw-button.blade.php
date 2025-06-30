@props([
    'color' => 'primary',
    'size' => 'md',
    'disabled' => false,
])


<button class="tw-btn
               tw-btn-{{ $color }}
               tw-btn-{{ $size }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->get('class') }}"
            {{ $attributes }}>
    {{ $slot }}
</button>

