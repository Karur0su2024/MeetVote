{{--

TODO: Zobrazit odpovědi pro jednotlivé možnosti

--}}
@props([
    'results' => [], // TODO: Načíst pole se všemi preferencemi (Yes, No, Maybe), místo Score
])




<div {{ $attributes->class(['card']) }}>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                {{ $content }}
            </div>
                {{ $score }}
        </div>
    </div>
</div>
