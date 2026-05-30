@props([
    'icon' => null,
    'type' => 'info',
    'dismissible' => false,
])

<div role="alert" class="alert alert-{{ $type }} alert-soft {{ $attributes->get('class') }}"
    {{ $attributes }}>
    @if ($icon)
        <i class="bi {{ $icon }} me-2"></i>
    @endif
    <span class="flex">
           {{ $slot }}
    </span>

    @if ($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
