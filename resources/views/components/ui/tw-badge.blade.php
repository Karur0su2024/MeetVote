@props([
    'color' => 'primary'
])

<span class="tw-badge tw-badge-primary tw-badge-sm" {{ $attributes }}>
    {{ $slot  }}
</span>
