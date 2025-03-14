<div class="alert alert-{{ $type ?? 'primary' }} shadow-sm d-flex fade show alert-dismissible" role="alert">
    {{ $slot }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
