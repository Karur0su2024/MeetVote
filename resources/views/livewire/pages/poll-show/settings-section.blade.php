<x-ui.panel>
    <x-slot:right>
        <x-ui.dropdown.wrapper id="poll-options-dropdown" size="md" wrapper="div">
            <x-slot:header>
                <x-ui.icon class="gear me-1"/>
                {{ __('pages/poll-show.settings.dropdown.options') }}
            </x-slot:header>
            <x-slot:dropdown-items>
                <x-ui.dropdown.item href="{{ route('polls.edit', $poll) }}">
                    <x-ui.icon class="pencil-square me-1"/>
                    {{ __('pages/poll-show.settings.dropdown.edit_poll') }}
                </x-ui.dropdown.item>
                <x-ui.dropdown.item wire:click="openModal('modals.poll.invitations', '{{ $poll->id }}')"
                                    :disabled="!$poll->isActive()">
                    <x-ui.icon class="person-plus me-1"/>
                    {{ __('pages/poll-show.settings.dropdown.invitations') }}
                </x-ui.dropdown.item>
                <x-ui.dropdown.item wire:click="openModal('modals.poll.share', '{{ $poll->id }}')">
                    <x-ui.icon class="share me-1"/>
                    {{ __('pages/poll-show.settings.dropdown.share_poll') }}
                </x-ui.dropdown.item>
                <x-ui.dropdown.item wire:click="openModal('modals.poll.close-poll', '{{ $poll->id }}')">
                    @if ($poll->isActive())
                        <x-ui.icon class="lock me-1"/>
                        {{ __('pages/poll-show.settings.dropdown.close_poll') }}
                    @else
                        <x-ui.icon class="unlock me-1"/>
                        {{ __('pages/poll-show.settings.dropdown.reopen_poll') }}
                    @endif
                </x-ui.dropdown.item>
                <x-ui.dropdown.divider />
                <x-ui.dropdown.item wire:click="openModal('modals.poll.delete-poll', '{{ $poll->id }}')"
                                    color="danger">
                    <x-ui.icon class="trash me-1"/>
                    {{ __('pages/poll-show.settings.dropdown.delete_poll') }}
                </x-ui.dropdown.item>
            </x-slot:dropdown-items>
        </x-ui.dropdown.wrapper>
    </x-slot:right>
</x-ui.panel>
