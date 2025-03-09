@props(['questionIndex', 'optionIndex', 'option'])

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
            <div class="d-flex flex-column">
                {{ $option['score'] }}
            </div>

            {{-- Výběr preference časové možnosti --}}

            <div>
                <x-poll.show.preference-button :questionIndex="$questionIndex" :optionIndex="$optionIndex" :pickedPreference="$option['picked_preference']" />
            </div>

        </div>
    </div>
</div>
