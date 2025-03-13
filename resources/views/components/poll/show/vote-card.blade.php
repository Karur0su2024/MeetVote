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

<div class="card mb-2">
    <div class=" d-flex justify-content-between align-items-center p-3">
        {{ $vote['voter_name'] }}

        <div>
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse-vote-{{ $vote['id'] }}" aria-expanded="false"
                aria-controls="collapse-vote-{{ $vote['id'] }}"> <i class="bi bi-eye"></i></button>
            <button class="btn btn-danger ms-2" wire:click='deleteVote({{ $vote['id'] }})'>
                <i class="bi bi-trash"></i></button>
            <button class="btn btn-warning ms-2" wire:click='loadVote({{ $vote['id'] }})'>
                <i class="bi bi-pencil"></i></button>
        </div>

        </button>
    </div>


    <div class="collapse" id="collapse-vote-{{ $vote['id'] }}">
        <div>
            @foreach ($vote['time_options'] as $timeOptionVote)
            @if ($timeOptionVote['picked_preference'] !== 0)
            <div class="voting-card-{{ $timeOptionVote['picked_preference'] }} d-flex justify-content-between p-3">
                <div>{{ $timeOptionVote['date'] }} - {{ $timeOptionVote['content'] }}</div>
                <div><img class="p-1"
                        src="{{ asset('icons/' . $preferenceValues[$timeOptionVote['picked_preference']] . '.svg') }}"
                        alt="Preference"></div>
            </div>
            @endif

            @endforeach



        </div>
    </div>

</div>
