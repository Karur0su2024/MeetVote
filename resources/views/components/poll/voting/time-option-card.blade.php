@props(['poll'])
@php
    $prefValues = [
        '2' =>  'yes',
        '1' =>  'maybe',
        '0' =>  'none',
        '-1' => 'no',
    ];
@endphp

<div
        {{ $attributes->class(['card card-sharp voting-card border-start-0 border-end-0 p-3 transition-all']) }}
        :class="'voting-card-' + timeOption.picked_preference">
    <div class="card-body voting-card-body">
        <div class="d-flex justify-content-between align-items-center">

            {{-- Obsah možnosti --}}
            <div class="me-2 w-25">
                <h6 class="mb-1 fw-bold"
                    x-text="timeOption.date_formatted"></h6>
                <p class="mb-0 text-muted"
                   x-text="timeOption.full_content"></p>
            </div>

            {{-- Skóre možnosti --}}
            <div class="d-flex flex-column align-items-center px-2 py-1 me-2 w-50">
                @if (!$poll->hide_results)
                    <span x-text="timeOption.score"
                          class="fw-bold badge shadow-sm bg-light text-dark fs-6"></span>
                @endif
            </div>

            {{-- Výběr preference --}}
            <div>
                <button
                        @click="setPreference('timeOption', null, optionIndex, getNextPreference('timeOption', timeOption.picked_preference))"
                        class="btn btn-outline-vote d-flex align-items-center"
                        :class="'btn-outline-vote-' + timeOption.picked_preference"
                        type="button">
                    <img class="p-1"
                         :src="'{{ asset('icons/') }}/' + timeOption.picked_preference + '.svg'"
                         :alt="timeOption.picked_preference"/>
                </button>
            </div>
        </div>
    </div>
</div>
