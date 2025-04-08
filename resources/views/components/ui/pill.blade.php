@props([
    'color' => 'primary'
])

<span class="badge rounded-pill small text-bg-{{ $color }} border-1 shadow-sm" {{ $attributes }}>
    {{ $slot  }}
</span>
