{{--

TODO: Zobrazit odpovědi pro jednotlivé možnosti

--}}
@props([
    'results' => [], // TODO: Načíst pole se všemi preferencemi (Yes, No, Maybe), místo Score
    'score' => 0,
])




<div {{ $attributes->class(['card']) }} {{ $attributes }}>
    <div class="p-4 rounded-lg text-base-content bg-base-100/80 shadow-sm">
        <div class="flex justify-between">
            <div>
                <p class="text-lg font-semibold mb-1">{{ $text ?? '' }}</p>
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
