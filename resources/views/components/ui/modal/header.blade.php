<div class="modal-header">
    <h5 class="modal-title">
        {{ $slot }}
</h5>
    <button type="button" class="btn-close text-white" wire:click="$dispatch('hideModal')"
            aria-label="Close"></button>
</div>
