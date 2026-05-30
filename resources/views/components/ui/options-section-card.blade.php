@props([
    'title' => '',
    'titleRight' => '',
    'content' => ''
])

<x-ui.card>
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
</x-ui.card>
