@props(['bodyPadding' => 4, 'tooltip' => null])

<div class="card shadow rounded-3 border-0 mb-5">
    <div class="card-header py-3 text-start">
        <div class="d-flex align-items-center justify-content-between">

            <h2 class="mb-0">{{ $header ?? '' }}</h2>

            @if ($tooltip)
                <h2 class="mb-0">
                    <i class="bi bi-question-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="{{ $tooltip }}"></i>
                </h2>
            @endif


        </div>
    </div>
    <div class="card-body text-start p-{{ $bodyPadding }}">
        {{ $slot }}
    </div>
</div>
