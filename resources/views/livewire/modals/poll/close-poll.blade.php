{{-- Modální okno pro uzavření/znovuotevření ankety --}}
<div class="modal-content">
    <x-ui.modal.header>
        @if($poll->isActive())
            {{ __('ui/modals.close_poll.title.close') }}
        @else
            {{ __('ui/modals.close_poll.title.reopen') }}
        @endif
    </x-ui.modal.header>
    <div class="modal-body tw:text-start tw:mb-0">
        @if (session()->has('error'))
            <span class="tw:text-error">
                {{ session('error') }}
            </span>
        @else
            @if ($poll->isActive())
                @if (count($poll->votes) === 0)
                    <x-ui.alert type="error">
                        <x-ui.icon name="exclamation-triangle-fill"/>
                        {{ __('ui/modals.close_poll.alerts.no_votes') }}
                    </x-ui.alert>
                @else
                    <p>{{ __('ui/modals.close_poll.text.poll_count', ['count_poll_votes' => count($poll->votes)]) }}</p>
                    <p>{{ __('ui/modals.close_poll.text.is_user_sure') }}</p>
                @endif
            @else
                <p>{{ __('ui/modals.close_poll.text.reopen') }}</p>
                @if($hasEvent)
                    <x-ui.alert type="warning">
                        <x-ui.icon name="exclamation-triangle-fill"/>
                        {{ __('ui/modals.close_poll.alerts.event_will_be_deleted') }}
                    </x-ui.alert>
                @endif

                <div class="tw:text-base-content">
                    <x-ui.form.tw-input
                        id="deadline"
                        wire:model="newDeadline"
                        type="date">
                        {{ __('ui/modals.close_poll.labels.new_deadline') }}
                    </x-ui.form.tw-input>
                </div>

            @endif
        @endif
    </div>
    <x-ui.modal.footer>
        <button class="tw:btn tw:btn-neutral"
                wire:click="$dispatch('hideModal')">
            {{ __('ui/modals.close_poll.buttons.cancel') }}
        </button>
        <button class="tw:btn tw:btn-warning {{ count($poll->votes) === 0 ? 'tw:btn-disabled' : '' }}"
                wire:click="closePoll()">
            @if($poll->isActive())
                {{ __('ui/modals.close_poll.buttons.close') }}
            @else
                {{ __('ui/modals.close_poll.buttons.reopen') }}
            @endif
        </button>
    </x-ui.modal.footer>
</div>
