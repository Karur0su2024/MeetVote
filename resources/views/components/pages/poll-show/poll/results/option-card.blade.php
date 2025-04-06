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
                {{ $content }}
            </div>
            <span class="badge bg-primary fs-5">
                {{ $score ?? 0 }}
            </span>
        </div>
    </div>
</div>
