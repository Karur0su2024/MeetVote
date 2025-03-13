<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">
            {{ $poll->status == 'active' ? 'Close Poll' : 'Reopen Poll' }}
        </h5>
        <button type="button" class="btn-close" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body text-start mb-0">

            @if ($poll->status == 'active')
                @if (count($poll->votes) == 0)
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> This poll has no votes. Poll can be closed
                        only if
                        there is at least one vote.
                    </div>
                @else
                <p> This poll has {{ count($poll->votes) }} votes. Closing the poll will prevent any further voting.</p>
                @endif
                <p>Are you sure you want to close this poll? Once closed, no further votes will be accepted.</p>
            @else
                <p>Do you want to reopen this poll? Users will be able to vote again.</p>
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Warning: If you created event, it will be
                    deleted.
                </div>
            @endif

            @if (session()->has('error'))
                <span class="text-danger">
                    {{ session('error') }}
                </span>
            @endif

        </p>
    </div>
    <div class="modal-footer d-flex justify-content-between">
        <button type="button" class="btn btn-secondary" wire:click="$dispatch('hideModal')">Cancel</button>
        <button type="button" class="btn btn-danger" wire:click="closePoll"
            {{ count($poll->votes) == 0 ? 'disabled' : '' }}>
            {{ $poll->status == 'active' ? 'Close Poll' : 'Reopen Poll' }}
        </button>
    </div>
</div>
