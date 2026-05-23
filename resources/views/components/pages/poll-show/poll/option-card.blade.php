{{--

TODO: Zobrazit odpovědi pro jednotlivé možnosti

--}}
@props([
    'results' => [], // TODO: Načíst pole se všemi preferencemi (Yes, No, Maybe), místo Score
    'score' => 0,
])




<div {{ $attributes->class(['tw:card']) }} {{ $attributes }}>
    <div class="tw:p-4 tw:rounded-lg tw:text-base-content tw:bg-base-100/80 tw:shadow-sm">
        <div class="tw:flex tw:justify-between">
            <div>
                <p class="tw:text-lg tw:font-semibold tw:mb-1">{{ $text ?? '' }}</p>
                <p class="">{{ $subtext ?? '' }}</p>
            </div>
            <div>
                {{ $right ?? '' }}
            </div>
        </div>
        <div class="tw:mt-3">
            {{ $bottom ?? '' }}
        </div>
    </div>
</div>
