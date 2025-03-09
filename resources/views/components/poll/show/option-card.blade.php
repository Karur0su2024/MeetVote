@props(['option', 'optionIndex'])

@php
    use Carbon\Carbon;

    $date = Carbon::parse($option['date'])->format('F d, Y');

@endphp


{{-- Karta časové možnosti --}}
<div class="card card-sharp rounded-lg p-3">
    <div class="d-flex justify-content-between align-items-center">
        {{-- Obsah možnosti --}}
        <div>
            <p class="mb-0 fw-bold">{{ $date }}</p>
            <p class="mb-0 text-muted d-flex align-items-center">
                {{ $option['content'] }}
                <i class="bi bi-exclamation-circle-fill ms-2 text-warning"></i>
            </p>
        </div>

        {{-- Zobrazení hlasů --}}
        <div class="d-flex flex-column">
            {{ $option['score'] }}
        </div>

        {{-- Výběr preference časové možnosti --}}
        <div>
            <x-poll.show.preference-button :optionIndex="$optionIndex" :pickedPreference="$option['picked_preference']" />
        </div>
    </div>
</div>
