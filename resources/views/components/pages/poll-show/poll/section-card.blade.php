@props([
    'title' => '',
    'titleRight' => '',
    'content' => ''
])

<div class="card mt-3 shadow-sm poll-section-card shadow-sm">

    <div class="card-body">
        <div class="d-flex justify-content-between mb-3 align-items-center">
            <h5 class="justify-content-between mb-0">{{ $title }}</h5>
            <div>
                {{ $titleRight }}
            </div>
        </div>

        <div class="row g-3">
            {{ $content }}
        </div>
    </div>
</div>
