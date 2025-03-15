<div>
    <div class="modal-header">
        <h5 class="modal-title">Close Poll</h5>
        <button type="button" class="btn-close text-white" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errorMessage}}
        </div>
        <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-primary" wire:click="$dispatch('hideModal')">OK</button>
        </div>

    </div>
</div>
