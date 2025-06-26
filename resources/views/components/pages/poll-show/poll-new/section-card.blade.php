@props([
    'title' => '',
    'titleRight' => '',
    'content' => ''
])

<div class="card bg-base-200 mt-3 shadow-sm poll-section-card shadow-sm p-3">

    <div class="flex flex-row mb-3">
        <h5 class="text-lg font-semibold flex-1" >{{ $title }}</h5>
        <div>
            {{ $titleRight }}
        </div>
    </div>
    <div class="grid grid-cols-12 gap-3 mb-3">
        <div class="col-span-12">
            {{ $slot }}
        </div>
    </div>
</div>
