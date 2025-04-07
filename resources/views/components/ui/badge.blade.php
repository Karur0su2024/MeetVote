@props([
    'color' => 'secondary'
])

<span class="badge text-bg-{{ $color }} border-1 shadow-sm" {{ $attributes }}>
    {{ $slot  }}
</span>
