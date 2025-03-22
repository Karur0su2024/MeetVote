<div>
    <div class="modal-header">
        <h5 class="modal-title">Results</h5>
        <button type="button" class="btn-close text-white" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @if (count($votes) === 0)
            <div class="alert alert-secondary" role="alert">
                No votes yet
            </div>
        @else
            <div class="accordion" id="accordionPanelsStayOpenExample">


                @foreach ($votes as $vote)
                    <x-poll.show.vote-card :vote="$vote" />
                @endforeach
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            </div>
        @endif
    </div>
</div>
