<div>
    <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Delete poll</h5>
        <button type="button" class="btn-close text-white" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <p>Are you sure you want to delete this poll?</p>
        <button class="btn btn-danger" wire:click="deletePoll">Delete</button>
    </div>
</div>
