@props(['option', 'preferences'])

@php
    use Carbon\Carbon;

    // Zpracování data možnosti
    $date = Carbon::parse($option['date']);
    $day = $date->isoFormat('dddd') . ', ' . $date->format('F d, Y');

    // Zpracování časového intervalu
    $optionText = $option['text'] ?? __('No time specified');
    
    if (!empty($option['start'])) {
        $start = Carbon::parse($option['start'])->format('H:i');
        $end = Carbon::parse($option['start'])->addMinutes($option['minutes'])->format('H:i');
        $optionText = "({$start} - {$end})";
    }

    
@endphp

{{-- Karta časové možnosti --}}
<div class="card card-sharp rounded-lg p-3">
    <div class="d-flex justify-content-between align-items-center">
        {{-- Obsah možnosti --}}
        <div>
            <p class="mb-0 fw-bold">{{ $day }}</p>
            <p class="mb-0 text-muted d-flex align-items-center">
                {{ $optionText }}
                <i class="bi bi-exclamation-circle-fill ms-2 text-warning"></i>
            </p>
        </div>

        {{-- Zobrazení hlasů --}}
        <div class="d-flex flex-column">
            @foreach ($option['votes'] as $voteName => $vote)
                <div class="d-flex align-items-center mb-2">
                    <img class="me-2" src="{{ asset('icons/' . $voteName . '.svg') }}" alt="{{ $voteName }}" width="20" height="20">
                    <p class="mb-0">{{ $vote }}</p>
                </div>
            @endforeach
        </div>

        {{-- Výběr preference časové možnosti --}}
        <div>
            <x-poll.show.preference-button :option="$option" />
        </div>
    </div>
</div>