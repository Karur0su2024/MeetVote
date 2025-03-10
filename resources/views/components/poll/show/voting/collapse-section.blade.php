<div class="border">
    <div class="w-100 px-3 py-2 bg-light text-dark" data-bs-toggle="collapse" href="#{{ $id }}" role="button"
        aria-expanded="true" aria-controls="{{ $id }}">
        <h3>{{ $header }}</h3>
    </div>
    <div class="collapse show" id="{{ $id }}">
        {{ $slot }}
    </div>
</div>
