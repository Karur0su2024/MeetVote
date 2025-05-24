@props([
    'id' => 'dropdown',
    'size' => 'sm',
    'element' => 'div',
    'color' => 'outline-secondary',
])

{{--<{{ $element }} class="dropdown {{ $attributes->get('class') ?? '' }}">--}}
{{--    --}}{{-- Dropdown button --}}
{{--    <a class="btn btn-{{ $size }} btn-{{ $color }}" href="#" id="{{ $id }}" role="button"--}}
{{--        data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--        {{ $header ?? '' }}--}}
{{--    </a>--}}
{{--    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-light" aria-labelledby="{{ $id }}">--}}
{{--        {{ $dropdownItems ?? '' }}--}}
{{--    </ul>--}}
{{--</{{ $element }}>--}}


<div class="dropdown dropdown-end {{ $attributes->get('class') ?? '' }}">
    <button class="btn">{{ $header ?? '' }}</button>
    <ul class="menu dropdown-content bg-lime-50 w-40 rounded-box z-1 p-2 shadow-sm text-base-100">
        {{ $dropdownItems ?? '' }}
    </ul>
</div>
