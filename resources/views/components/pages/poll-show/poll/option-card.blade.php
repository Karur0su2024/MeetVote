{{--

TODO: Zobrazit odpovědi pro jednotlivé možnosti

--}}
@props([
    'results' => [], // TODO: Načíst pole se všemi preferencemi (Yes, No, Maybe), místo Score
    'score' => 0,
])




<div {{ $attributes->class(['tw:card']) }} {{ $attributes }}>
    <div class="tw:p-4 tw:rounded-lg tw:text-base-content tw:bg-base-100/25">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <p class="tw:text-lg fw-bold mb-1">{{ $text ?? '' }}</p>
                <p class="">{{ $subtext ?? '' }}</p>
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
