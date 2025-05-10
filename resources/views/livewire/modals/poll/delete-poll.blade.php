{{-- Modální okno pro odstranění ankety --}}
<div>
    <x-ui.modal.header>
        {{ __('ui/modals.delete_poll.title') }}
    </x-ui.modal.header>
    <div class="modal-body">
        <p>{{ __('ui/modals.delete_poll.text.question') }}</p>
        <p>{{ __('ui/modals.delete_poll.text.warning') }}</p>
        @if (session()->has('error'))
            <span class="text-danger">
                {{ session('error') }}
            </span>
        @endif
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" wire:click="$dispatch('hideModal')">{{ __('ui/modals.close_poll.buttons.cancel') }}</button>
        <button type="button" class="btn btn-danger" wire:click="deletePoll">{{ __('ui/modals.invitations.table.actions.delete') }}</button>
    </div>
</div>
