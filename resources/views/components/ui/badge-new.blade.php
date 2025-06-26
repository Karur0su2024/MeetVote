@props([
    'color' => 'primary',
    'tooltip' => null,
])

<span class="badge badge-sm badge-{{ $color }} {{ $attributes->get('class') }}" {{ $attributes }}
    @if($tooltip)
    data-tip="{{ $tooltip }}"
    @endif
    >
    {{ $slot }}
</span>
