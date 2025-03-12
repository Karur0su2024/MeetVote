<div>
    <div class="modal-header bg-warning">
        <h5 class="modal-title">Results</h5>
        <button type="button" class="btn-close text-white" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @if (count($votes) == 0)
            <div class="alert alert-secondary" role="alert">
                No votes yet
            </div>
        @else
            @foreach ($votes as $vote)
                <x-poll.show.vote-card :vote="$vote" />
            @endforeach
        @endif
    </div>
</div>
