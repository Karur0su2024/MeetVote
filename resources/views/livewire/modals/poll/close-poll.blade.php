<div class="modal-content">
    <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title">
            {{ $poll->status == 'active' ? 'Close Poll' : 'Reopen Poll' }}
        </h5>
        <button type="button" class="btn-close" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body text-start mb-0">
        <p>
            @if ($poll->status == 'active')
                Are you sure you want to close this poll? Once closed, no further votes will be accepted.
            @else
                Do you want to reopen this poll? Users will be able to vote again.
            @endif
        </p>
    </div>
    <div class="modal-footer d-flex justify-content-between">
        <button type="button" class="btn btn-secondary" wire:click="$dispatch('hideModal')">Cancel</button>
        <button type="button" class="btn btn-danger" wire:click="closePoll">
            {{ $poll->status == 'active' ? 'Close Poll' : 'Reopen Poll' }}
        </button>
    </div>
</div>
