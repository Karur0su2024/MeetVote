@props([
    'header',
    '$content'
])

<div class="card mt-3 shadow-sm">

    <div class="card-body">
        <h5 class="mb-3 text-muted">{{ $header }}</h5>
        <div class="row g-3">
            {{ $content }}
        </div>
    </div>
</div>
