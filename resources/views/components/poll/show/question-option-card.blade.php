@props(['questionIndex', 'option', 'preferences'])

{{-- Karta časové možnosti --}}

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            {{-- Obsah možnosti --}}
            <div>
                {{-- Čas/text možnosti --}}
                <p class="mb-0 text-muted">
                    {{ $option['text'] }}
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
                <button class="btn btn-outline-secondary" wire:click='changeQuestionPreference({{ $questionIndex }}, {{ $option['id'] }})'>
                    <img class="p-2 me-2" src="{{ asset('icons/' . $preferences[$option['chosen_preference']]['text'] . '.svg') }}" alt="{{ $voteName }}">
                    
                </button>
            </div>

        </div>
    </div>
</div>