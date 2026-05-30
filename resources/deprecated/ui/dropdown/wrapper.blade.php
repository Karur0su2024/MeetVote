@props([
    'id' => 'dropdown',
    'size' => 'sm',
    'element' => 'div',
    'color' => 'outline-secondary',
    'disabled' => true,
])

<{{ $element }} class="tw-dropdown {{ $attributes->get('class') ?? '' }}">
    {{-- Dropdown button --}}
    <a class="tw-btn tw-btn-{{ $size }} tw-btn-{{ $color }} {{ $disabled === true ? 'tw-disabled' : "" }}" href="#" id="{{ $id }}">
        {{ $header ?? '' }}
    </a>
    <ul class="tw-menu tw-dropdown-content tw-bg-base-300 tw-rounded-box" aria-labelledby="{{ $id }}">
        {{ $dropdownItems ?? '' }}
    </ul>
</{{ $element }}>
