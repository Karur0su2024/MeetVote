{{--

TODO: Zobrazit odpovědi pro jednotlivé možnosti

--}}
@props([
    'results' => [], // TODO: Načíst pole se všemi preferencemi (Yes, No, Maybe), místo Score
    'score' => 0,
])




<div {{ $attributes->class(['card']) }} {{ $attributes }}>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <p class="fs-6 fw-bold mb-1">{{ $text ?? '' }}</p>
                <p class="card-text text-muted">{{ $subtext ?? '' }}</p>
            </div>
            <div>
                {{ $right ?? '' }}
            </div>
        </div>
        <div class="mt-3">
            {{ $bottom ?? '' }}
        </div>
    </div>
</div>
