@props([
    'color' => 'primary'
])

<span class="badge rounded-pill text-bg-{{ $color }} border-1 shadow-sm" {{ $attributes }}>
    {{ $slot  }}
</span>
