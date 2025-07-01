@props([
    'color' => 'primary',
    'size' => 'md',
    'disabled' => false,
])


<button class="tw-btn
               tw-btn-primary
               tw-btn-{{ $size }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->get('class') }}"
            {{ $attributes }}>
    {{ $slot }}
</button>

