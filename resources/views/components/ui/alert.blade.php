@props([
    'icon' => null,
    'type' => 'primary',
    'dismissible' => false,
])

<div class="alert alert-{{ $type }} shadow-sm d-flex fade show {{ $dismissible ? 'alert-dismissible' : '' }} {{ $attributes->get('class') }}"
     role="alert"
     {{ $attributes }}>
    @if ($icon)
        <i class="bi {{ $icon }} me-2"></i>
    @endif
    {{ $slot }}
    @if ($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
