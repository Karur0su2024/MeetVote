@props([
    'color' => 'primary',
    'size' => 'md',
    'disabled' => false,
])


<button class="btn
               btn-primary
               btn-{{ $size }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->get('class') }}"
            {{ $attributes }}>
    {{ $slot }}
</button>

