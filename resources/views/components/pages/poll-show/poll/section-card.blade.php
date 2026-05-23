@props([
    'title' => '',
    'titleRight' => '',
    'content' => ''
])

<div class="tw:card tw:bg-base-300/80 tw:mt-3 tw:shadow-sm poll-section-card tw:text-base-content">
    <div class="tw:card-body">
        <div class="tw:flex tw:flex-row">
            <h4 class="tw:grow tw:mb-1 tw:text-2xl tw:font-semibold tw:flex-nowrap">{{ $title }}</h4>
            <div>
                {{ $titleRight }}
            </div>

        </div>
        <div class="tw:grid tw:grid-flow-row tw:grid-cols-2 tw:gap-3">
            {{-- Content of the section --}}
            {{ $content }}
        </div>
    </div>
</div>
