@props([
    'size' => 'md',
    'type' => 'button',
    'color' => 'primary',
    'disabled' => false,
    'tooltip' => null,
    ])


<button type="{{  $type  }}"
        class="btn btn-{{ $color }}

               btn-{{ $size }}
               {{ $disabled ? 'disabled' : '' }}
               {{ $attributes->get('class') }}"
        {{ $attributes }}
        @if($tooltip)
            data-bs-toggle="tooltip" data-bs-placement="top"
            data-bs-custom-class="custom-tooltip"
            data-bs-title="{{ $tooltip }}"
        @endif>
    {{ $slot }}
</button>
