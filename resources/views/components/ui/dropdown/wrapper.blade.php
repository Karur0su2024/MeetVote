@props([
    'id' => 'dropdown',
    'size' => 'sm',
    'wrapper' => 'li',
])

<{{ $wrapper }} class="dropdown {{ $class ?? '' }}">
    {{-- Dropdown button --}}
    <a class="btn btn-{{ $size }} btn-outline-secondary" href="#" id="{{ $id }}" role="button"
        data-bs-toggle="dropdown" aria-expanded="false">
        {{ $header ?? '' }}
    </a>
    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-light" aria-labelledby="{{ $id }}">
        {{ $dropdownItems ?? '' }}
    </ul>
</{{ $wrapper }}>
