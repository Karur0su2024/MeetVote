@props([
    'color' => 'primary',
    'tooltip' => null,
])

<span class="badge bg-{{ $color }} border-1 shadow-sm {{ $attributes->get('class') }}" {{ $attributes }}
    @if($tooltip)
    data-bs-toggle="tooltip" data-bs-placement="top"
      data-bs-custom-class="custom-tooltip"
      data-bs-title="{{ $tooltip }}"
    @endif
    >
    {{ $slot  }}
</span>
