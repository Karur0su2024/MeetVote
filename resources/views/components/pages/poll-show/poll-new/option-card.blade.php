{{--

TODO: Zobrazit odpovědi pro jednotlivé možnosti

--}}
@props([
    'results' => [], // TODO: Načíst pole se všemi preferencemi (Yes, No, Maybe), místo Score
    'score' => 0,
])




<div class="shadow-xs border-dotted border-2 p-2 rounded"
    {{ $attributes->class(['card']) }} {{ $attributes }}>
    <div class="flex flex-row justify-content-between align-items-start">
        <div class="flex-1">
            <p class="text-sm font-semibold mb-1">{{ $text ?? '' }}</p>
            <p class="text-sm font-normal">
                {{ $subtext ?? '' }}
            </p>
        </div>
        <div>
            {{ $right ?? '' }}
        </div>
    </div>
    <div class="mt-3">
        {{ $bottom ?? '' }}
    </div>
</div>
