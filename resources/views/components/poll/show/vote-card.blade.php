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
                    <div class="fw-bold">Voter:</div>
                    <div class="text-muted">
                        {{ $vote['user_name'] ?? 'anonymous' }}
                    </div>
                </div>
        </button>
    </h2>
    <div id="accordion-collapse-vote-{{ $vote['id'] }}" class="accordion-collapse collapse">
        <div class="accordion-body p-0">
            <div class="btn-group py-3 mx-auto" role="group" aria-label="Basic example">
                <button class="btn btn-danger" wire:click='deleteVote({{ $vote['id'] }})' type="button">
                    <i class="bi bi-trash"></i> Delete</button>
                <button class="btn btn-warning" wire:click='loadVote({{ $vote['id'] }})' type="button">
                    <i class="bi bi-pencil"></i> Edit</button>
            </div>
            @foreach ($vote['time_options'] as $timeOptionVote)
                @if ($timeOptionVote['picked_preference'] !== 0)
                    <div
                        class="voting-card-{{ $timeOptionVote['picked_preference'] }} d-flex justify-content-between p-3">
                        <div>{{ $timeOptionVote['date'] }} - {{ $timeOptionVote['content'] }}</div>
                        <div><img class="p-1"
                                src="{{ asset('icons/' . $timeOptionVote['picked_preference'] . '.svg') }}"
                                alt="Preference"></div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
