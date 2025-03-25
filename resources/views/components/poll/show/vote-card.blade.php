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
                data-bs-target="#accordion-collapse-vote-{{ $vote->id }}"
                aria-expanded="true"
                aria-controls="accordion-collapse-vote-{{ $vote->id }}">
            <div class="d-flex w-100">
                <div class="d-flex flex-column">
                    <div class="fw-bold fs-5">{{ $vote->voter_name ?? 'anonymous' }}
                        @if (Auth::id() === $vote->user_id )
                            <i class="bi bi-person-fill ms-1"></i>
                        @endif
                    </div>
                    <div class="text-muted small">
                        {{ Carbon\Carbon::parse($vote->updated_at)->diffForHumans() }}
                    </div>
                </div>
            </div>
        </button>
    </h2>
    <div id="accordion-collapse-vote-{{ $vote->id }}" class="accordion-collapse collapse">
        <div class="accordion-body p-0">
            <div class="d-flex justify-content-between gap-2 p-2 my-2">
                @can('delete', $vote)
                    <x-ui.button color="outline-danger"
                                 wire:click="deleteVote({{ $vote->id }})">
                        <x-ui.icon name="trash"/>
                        {{ __('ui/modals.results.buttons.delete_vote') }}
                    </x-ui.button>
                @endcan
                @can('edit', $vote)
                    <x-ui.button color="outline-primary"
                                 wire:click="loadVote({{ $vote->id }})">
                        <x-ui.icon name="pencil"/>
                        {{ __('ui/modals.results.buttons.edit_vote') }}
                    </x-ui.button>
                @endcan
            </div>
            @foreach($vote->timeOptions ?? []  as $option)
                <div class="border-0 overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center p-3 voting-card-{{$option->preference}}">
                        <div class="d-flex flex-column">
                            <div class="fw-bold mb-1">{{ \Carbon\Carbon::parse($option->timeOption->date)->format('d. m. Y') }}</div>
                            <div class="text-muted small">
                                @if($option->timeOption->text)
                                    <span>{{ $option->timeOption->text }}</span>
                                @else
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-clock me-1"></i>
                                        <span>{{ $option->timeOption->start }} - {{ $option->timeOption->end }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <img src="{{ asset('icons/') }}/{{ $option->preference }}.svg"
                                 alt="Preference: {{ $option->preference }}"
                                 width="30" height="30">
                        </div>
                    </div>
                </div>
            @endforeach
            @foreach($vote->questionsOptions ?? [] as $option)
                <div class="border-0 overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center p-3 voting-card-{{$option->preference}}">
                        <div class="d-flex flex-column">
                            <div class="fw-bold mb-1">{{ $option->$questionOption->Question->text }}</div>
                            <div class="text-muted small">
                                {{ $option->$questionOption->text }}
                            </div>
                        </div>

                        <div>
                            <img src="{{ asset('icons/') }}/{{ $option->preference }}.svg"
                                 alt="Preference: {{ $option->preference }}"
                                 width="30" height="30">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
