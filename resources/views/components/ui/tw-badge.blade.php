@props([
    'color' => 'primary'
])

<span class="tw-badge tw-badge-{{ $color }} tw-badge-sm" {{ $attributes }}>
    {{ $slot  }}
</span>
