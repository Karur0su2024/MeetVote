@props([
    'title' => '',
    'titleRight' => '',
    'content' => ''
])

<div class="card bg-base-100 shadow-sm poll-section-card text-base-content">
    <div class="card-body">
        <div class="flex flex-row">
            <h4 class="grow mb-1 text-2xl font-semibold flex-nowrap">{{ $title }}</h4>
            <div>
                {{ $titleRight }}
            </div>

        </div>
        <div class="grid grid-flow-row grid-cols-2 gap-3">
            {{-- Content of the section --}}
            {{ $content }}
        </div>
    </div>
</div>
