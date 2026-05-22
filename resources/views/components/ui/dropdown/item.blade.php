@props([
    'color' => '',
    'disabled' => false,
])

<li class="tw-py-1">
    <a  class="
        {{ $color ? 'text-' . $color : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->get('class') }}"
        {{ $attributes }}>
        {{ $slot }}
    </a>
</li>
