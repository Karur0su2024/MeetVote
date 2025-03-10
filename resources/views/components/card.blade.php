@props(['bodyPadding' => 4])

<div class="card shadow-sm rounded-3 border-0 mb-5">
    <div class="card-header bg-secondary text-white py-3 text-start">

        <h2 class="mb-0">{{ $header ?? '' }}</h2>
    </div>
    <div class="card-body text-start p-{{ $bodyPadding }} bg-gradient">
        {{ $slot }}
    </div>
</div>
