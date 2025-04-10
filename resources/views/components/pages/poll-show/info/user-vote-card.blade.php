<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="m-0">
                Your vote
            </h3>
            @can('delete', $userVote)
                <x-ui.button
                    color="outline-danger"
                    wire:click="deleteVote({{ $userVote->id }})">
                    <x-ui.icon name="trash"/>
                    {{ __('ui/modals.results.buttons.delete_vote') }}
                </x-ui.button>
            @endcan
        </div>





        <div>
            @if($userVote)
                <x-pages.poll-show.poll.results.vote-content :vote="$userVote"/>
            @else
                <p class="text-muted mt-2">
                    You have not voted yet.
                </p>
            @endif
        </div>
    </div>
</div>
