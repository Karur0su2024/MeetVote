@props([
    'title' => '',
    'titleRight' => '',
    'content' => ''
])

<div class="tw-card tw-bg-base-400 mt-3 shadow-sm poll-section-card shadow-sm">
    <div class="tw-card-body">
        <div class="tw-flex tw-flex-row">
            <h2 class="card-title tw-grow mb-1 tw-text-2xl text-break tw-font-semibold">{{ $title }}</h2>
            <div class="flex-none">
                {{ $titleRight }}
            </div>

        </div>
        <div class="tw-grid">
            {{ $content }}
        </div>
    </div>
</div>
