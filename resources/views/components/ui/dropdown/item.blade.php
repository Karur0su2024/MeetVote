@props([
    'color' => '',
    'disabled' => false,
])

<li class="py-1">
    <a class="
        dropdown-item pointer-cursor
        {{ $color ? 'text-' . $color : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->get('class') }}"
        {{ $attributes }}>
        {{ $slot }}
    </a>
</li>
