<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="m-0">
                {{ __('pages/poll-show.your_vote.title') }}
            </h3>
            @can('delete', $userVote)
                <x-ui.button
                    color="outline-danger"
                    wire:click="deleteVote({{ $userVote->id }})">
                    <x-ui.icon name="trash"/>
                    {{ __('pages/poll-show.your_vote.buttons.delete') }}
                </x-ui.button>
            @endcan
        </div>





        <div>
            @if($userVote && !($userVote->questionOptions->count() > 0) && $userVote->timeOptions->count() > 0)
                <x-pages.poll-show.poll.results.vote-content :vote="$userVote"/>
            @else
                <p class="text-muted mt-2">
                    {{ __('pages/poll-show.your_vote.no_vote') }}
                </p>
            @endif
        </div>
    </div>
</div>
