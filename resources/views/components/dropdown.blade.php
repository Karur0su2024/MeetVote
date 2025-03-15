@props(['id' => 'dropdown'])

<li class="dropdown {{ $class ?? '' }}">
    <a class="btn btn-sm btn-outline-secondary" href="#" id="{{ $id }}" role="button"
        data-bs-toggle="dropdown" aria-expanded="false">
        {{ $header ?? '' }}
    </a>
    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-light" aria-labelledby="{{ $id }}">
        {{ $slot }}
    </ul>
</li>
