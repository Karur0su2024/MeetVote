@props(['vote'])
@php
    $preferenceValues = [
        '-1' => 'no',
        '0' => 'none',
        '1' => 'maybe',
        '2' => 'yes',
    ];

@endphp

<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#accordion-collapse-vote-{{ $vote['id'] }}"
                aria-expanded="true"
                aria-controls="accordion-collapse-vote-{{ $vote['id'] }}">
            <div class="d-flex w-100">
                <div class="d-flex flex-column">
                    <div class="fw-bold fs-5">{{ $vote['voter_name'] ?? 'anonymous' }}
                        @if (Auth::id() === $vote['user_id'])
                            <i class="bi bi-person-fill ms-1"></i>
                        @endif
                    </div>
                    <div class="text-muted small">
                        {{ Carbon\Carbon::parse($vote['updated_at'])->diffForHumans() }}
                    </div>
                </div>
            </div>
        </button>
    </h2>
    <div id="accordion-collapse-vote-{{ $vote['id'] }}" class="accordion-collapse collapse">
        <div class="accordion-body p-0">
            @if ($vote['permission'])
                <div class="d-flex justify-content-center gap-2 p-2 my-2">
                    <x-ui.button color="outline-danger"
                                 class="w-100"
                                 wire:click="deleteVote({{ $vote['id'] }})">
                        <x-ui.icon name="trash"/>
                        {{ __('ui/modals.results.buttons.delete_vote') }}
                    </x-ui.button>
                    @if($vote['edit_votes'])
                        <x-ui.button color="outline-warning"
                                     class="w-100"
                                     wire:click="loadVote({{ $vote['id'] }})">
                            <x-ui.icon name="pencil"/>
                            {{ __('ui/modals.results.buttons.load_vote') }}
                        </x-ui.button>
                    @endif
                </div>
            @endif
            <div>
                @foreach ($vote['time_options'] as $timeOptionVote)
                    @if ($timeOptionVote['picked_preference'] !== 0)
                        <x-ui.modal.results.vote-item :pref="$preferenceValues[$timeOptionVote['picked_preference']]">
                            {{ $timeOptionVote['date_formatted'] }}
                        </x-ui.modal.results.vote-item>
                    @endif
                @endforeach
                @foreach ($vote['questions'] as $question)
                    @foreach ($question['options'] as $option)
                        @if ($option['picked_preference'] !== 0)
                            <x-ui.modal.results.vote-item :pref="$preferenceValues[$option['picked_preference']]">
                                {{ $question['text']}} -
                                {{ $option['text'] }}
                            </x-ui.modal.results.vote-item>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>
