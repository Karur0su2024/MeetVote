@props(['collapseId' => ''])

<div class="border">
    <div class="w-100 px-3 py-2" data-bs-toggle="collapse" href="#{{ $collapseId }}" role="button"
        aria-expanded="true" aria-controls="{{ $collapseId }}">
        <h3>{{ $header }}</h3>
    </div>
    <div class="collapse show" id="{{ $collapseId }}">
        {{ $slot }}
    </div>
</div>
