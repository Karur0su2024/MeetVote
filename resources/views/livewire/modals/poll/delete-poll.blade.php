<div>
    <x-ui.modal.header>
        Delete pol
    </x-ui.modal.header>
    <div class="modal-body">
        <p>Are you sure you want to delete this poll?</p>
        <p>This action cannot be undone.</p>
        @if (session()->has('error'))
            <span class="text-danger">
                {{ session('error') }}
            </span>
        @endif
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" wire:click="$dispatch('hideModal')">Cancel</button>
        <button type="button" class="btn btn-danger" wire:click="deletePoll">Delete</button>
    </div>
</div>
