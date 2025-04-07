@props([
    'title' => '',
    'titleRight' => '',
    'content' => ''
])

<div class="card mt-3 shadow-sm">

    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5 class="justify-content-between">{{ $title }}</h5>
            <div>
                {{ $titleRight }}
            </div>
        </div>

        <div class="row g-3">
            {{ $content }}
        </div>
    </div>
</div>
