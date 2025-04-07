<div class="card">
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
                <p class="text-muted">
                    You have not voted yet.
                </p>

                <x-ui.button color="primary"
                             size="sm"
                             wire:click="dispatch('show-voting-section')">
                    Add new vote
                </x-ui.button>
            @endif
        </div>
    </div>
</div>
