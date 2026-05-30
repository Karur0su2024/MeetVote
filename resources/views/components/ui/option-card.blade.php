{{--

TODO: Zobrazit odpovědi pro jednotlivé možnosti

--}}
@props([
    'results' => [], // TODO: Načíst pole se všemi preferencemi (Yes, No, Maybe), místo Score
    'score' => 0,
    'bottom' => null
])


<div {{ $attributes->class(['card']) }} {{ $attributes }}>
    <div class="card p-4 border border-gray-200 text-base-content bg-base-200/80 shadow-sm">
        <div class="flex justify-between">
            <div>
                <p class="text-md font-semibold mb-1">{{ $text ?? '' }}</p>
                <p class="text-sm font-light">{{ $subtext ?? '' }}</p>
            </div>
            <div>
                {{ $right ?? '' }}
            </div>
        </div>
        @if(isset($bottom) && $bottom->isNotEmpty())
            <div class="card bg-base-300 shadow-sm border-t border-gray-200 p-1 mt-3">
                {{ $bottom }}
            </div>
        @endif
    </div>
</div>
