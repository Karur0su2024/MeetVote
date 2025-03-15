<div class="alert alert-{{ $type ?? 'primary' }} shadow-sm d-flex fade show {{ $dismissible ?? false ? 'alert-dismissible' : '' }}" role="alert">
    {{ $slot }}
    @if ($dismissible ?? false)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
