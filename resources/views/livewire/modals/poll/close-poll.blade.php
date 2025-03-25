<div class="modal-content">
    <x-ui.modal.header>
        @if($poll->isActive())
            {{ __('ui/modals.close_poll.title.close') }}
        @else
            {{ __('ui/modals.close_poll.title.reopen') }}
        @endif
    </x-ui.modal.header>
    <div class="modal-body text-start mb-0">
        @if (session()->has('error'))
            <span class="text-danger">
                {{ session('error') }}
            </span>
        @else
            @if ($poll->isActive())
                @if (count($poll->votes) === 0)
                    <x-ui.alert type="danger">
                        <x-ui.icon name="exclamation-triangle-fill"/>
                        {{ __('ui/modals.close_poll.alerts.no_votes') }}
                    </x-ui.alert>
                @else
                    <p>{{ __('ui/modals.close_poll.text.poll_count', ['count_poll_votes' => count($poll->votes)]) }}</p>
                    <p>{{ __('ui/modals.close_poll.text.is_user_sure') }}</p>
                @endif
            @else
                <p>{{ __('ui/modals.close_poll.text.reopen') }}</p>
                <x-ui.alert type="warning">
                    <x-ui.icon name="exclamation-triangle-fill"/>
                    {{ __('ui/modals.close_poll.alerts.reopen_warning') }}
                </x-ui.alert>
            @endif
        @endif
    </div>
    <x-ui.modal.footer>
        <x-ui.button color="secondary"
                     wire:click="$dispatch('hideModal')">
            {{ __('ui/modals.close_poll.buttons.cancel') }}
        </x-ui.button>
        <x-ui.button color="danger"
                     :disabled="count($poll->votes) === 0"
                     wire:click="closePoll()">
            @if($poll->isActive())
                {{ __('ui/modals.close_poll.buttons.close') }}
            @else
                {{ __('ui/modals.close_poll.buttons.reopen') }}
            @endif
        </x-ui.button>
    </x-ui.modal.footer>
</div>
