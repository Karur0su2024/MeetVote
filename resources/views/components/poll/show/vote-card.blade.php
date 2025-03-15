@props(['vote'])
@php

    $hasPermission =
        request()->get('isPollAdmin', false) || (!is_null($vote['user_id']) && Auth::id() === $vote['user_id']);

    $preferenceValues = [
        '-1' => 'No',
        '0' => 'None',
        '1' => 'Maybe',
        '2' => 'Yes',
    ];

@endphp

<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse"
            data-bs-target="#accordion-collapse-vote-{{ $vote['id'] }}" aria-expanded="true"
            aria-controls="accordion-collapse-vote-{{ $vote['id'] }}">

            <div class="d-flex w-100">
                <div class="d-flex flex-column">
                    <div class="fw-bold fs-5">{{ $vote['voter_name'] ?? 'anonymous' }}</div>
                    <div class="text-muted small">
                        <i
                            class="bi bi-calendar-check me-1"></i>{{ Carbon\Carbon::parse($vote['updated_at'])->format('j. n. Y H:i') }}
                    </div>
                </div>
            </div>
        </button>
    </h2>
    <div id="accordion-collapse-vote-{{ $vote['id'] }}" class="accordion-collapse collapse">
        <div class="accordion-body p-0">
            @if ($hasPermission)
                <div class="d-flex justify-content-center gap-2 py-2 mb-3">
                    <button class="btn btn-outline-danger" wire:click='deleteVote({{ $vote['id'] }})' type="button">
                        <i class="bi bi-trash"></i> Delete</button>
                    <button class="btn btn-outline-warning" wire:click='loadVote({{ $vote['id'] }})' type="button">
                        <i class="bi bi-pencil"></i> Edit</button>
                </div>
            @endif
            <div>
                @foreach ($vote['time_options'] as $timeOptionVote)
                    @if ($timeOptionVote['picked_preference'] !== 0)
                        <div
                            class="voting-card-{{ $timeOptionVote['picked_preference'] }} d-flex justify-content-between p-3">
                            <div>{{ Carbon\Carbon::parse($timeOptionVote['date'])->format('j. n. Y') }} -
                                {{ $timeOptionVote['content'] }}</div>
                            <div><img class="p-1"
                                    src="{{ asset('icons/' . $timeOptionVote['picked_preference'] . '.svg') }}"
                                    alt="{{ $preferenceValues[$timeOptionVote['picked_preference']] }}">
                            </div>
                        </div>
                    @endif
                @endforeach
                @foreach ($vote['questions'] as $question)
                    @foreach ($question['options'] as $option)
                        <div class="voting-card-{{ $option['picked_preference'] }} d-flex justify-content-between p-3">
                            <div>{{ $question['text']}} -
                                {{ $option['text'] }}</div>
                            <div><img class="p-1"
                                    src="{{ asset('icons/' . $timeOptionVote['picked_preference'] . '.svg') }}"
                                    alt="{{ $preferenceValues[$timeOptionVote['picked_preference']] }}">
                            </div>
                        </div>
                    @endforeach

                    @if ($timeOptionVote['picked_preference'] !== 0)
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
