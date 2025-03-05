@props(['option', 'preferences'])

@php
    use Carbon\Carbon;
    // Den možnosti
    $day = Carbon::parse($option['date'])->isoFormat('dddd') . ", " . Carbon::parse($option['date'])->format('F d, Y');



    if($option['start'] != null){
        $start = Carbon::parse($option['start'])->format('H:i');
        $end = Carbon::parse($option['start'])->addMinutes($option['minutes'])->format('H:i');
        // Časová možnost
        $optionText = '(' . $start . ' - ' . $end . ')';
    } else {
        $optionText = $option['text'];
    }


@endphp

{{-- Karta časové možnosti --}}

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            {{-- Obsah možnosti --}}
            <div>
                {{-- Datum možnosti --}}
                <p class="mb-0 fw-bold">
                    {{ $day }}
                </p>
                {{-- Čas/text možnosti --}}
                <p class="mb-0 text-muted">
                    {{ $optionText }}
                    <i class="bi bi-exclamation-circle-fill"></i>
                </p>
            </div>

            {{-- Zobrazení hlasů --}}
            <div>
                @foreach ($option['votes'] as $voteName => $vote)
                    <div class="d-flex mb-2">
                        <img class="me-2" src="{{ asset('icons/' . $voteName . '.svg') }}" alt="{{ $voteName }}"><p class="mb-0">  {{ $vote }}</p>
                    </div>

                @endforeach
            </div>

            {{-- Výběr preference časové možnosti --}}

            <div>
                <button class="btn btn-outline-secondary" wire:click='changePreference({{ $option['id'] }})'>
                    <img class="p-2 me-2" src="{{ asset('icons/' . $preferences[$option['chosen_preference']]['text'] . '.svg') }}" alt="{{ $voteName }}">
                    
                </button>
            </div>

        </div>
    </div>
</div>