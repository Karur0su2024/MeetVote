<div class="modal-header">
    <h3 class="modal-title">
        {{ $slot }}
    </h3>
    <button type="button" class="btn-close text-white" wire:click="$dispatch('hideModal')"
            aria-label="Close"></button>
</div>
