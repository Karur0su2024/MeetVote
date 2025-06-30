@php
    /**
    * @see  resources/views/pages/polls/show.blade.php
    */
@endphp

<div class="g-4 mb-4" x-data="{ showEventDetails: true }">
    <x-ui.tw-card>
        <x-slot:title>
            {{ $poll->title }}
        </x-slot:title>

        <x-ui.username :username="$poll->author_name" />
        <p class="tw-break-normal tw-text-sm tw-text-gray-600">
            @if ($poll->description == null || $poll->description == '')
                {{ __('pages/poll-show.info.text.no_description') }}
            @else
                {{ $poll->description }}
            @endif
        </p>

        <div class="d-flex gap-2">
            @can('isAdmin', $poll)
                <x-ui.tw-button wire:click="openModal('modals.poll.share', '{{ $poll->id }}')"
                             color="outline-secondary"
                             size="sm">

                    {{ __('pages/poll-show.settings.dropdown.share_poll') }}
                </x-ui.tw-button>
                {{-- Nabídka pro správu ankety --}}
                <x-ui.dropdown.wrapper id="poll-options-dropdown" size="sm" wrapper="div" color="primary">
                    <x-slot:header>
                        <x-ui.icon class="gear me-1"/>
                        {{ __('pages/poll-show.settings.dropdown.options') }}
                    </x-slot:header>
                    <x-slot:dropdown-items>
                        <x-ui.dropdown.item href="{{ route('polls.edit', $poll) }}"
                                            :disabled="!$poll->isActive()">
                            <x-ui.icon class="pencil-square me-1"/>
                            {{ __('pages/poll-show.settings.dropdown.edit_poll') }}
                        </x-ui.dropdown.item>
                        @auth
                            <x-ui.dropdown.item wire:click="openModal('modals.poll.invitations', '{{ $poll->id }}')"
                                                :disabled="!$poll->isActive()">
                                <x-ui.icon class="person-plus me-1"/>
                                {{ __('pages/poll-show.settings.dropdown.invitations') }}
                            </x-ui.dropdown.item>
                        @endauth
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

            @endcan
        </div>

        <div class="tw-flex tw-flex-wrap tw-gap-1 mt-3">
            {{-- Badge s počtem hlasů --}}
            <x-ui.tw-badge>
                {{ $poll->timezone }} ({{  date('P') }})
            </x-ui.tw-badge>

            {{-- Badges s parametry nastavení ankety --}}
            @foreach($poll->settings as $attributeName => $attribute)
                @if($attribute)
                    <x-ui.tw-badge class="my-1">
                        {{  __('pages/poll-show.info.badges.attributes.' . $attributeName) }}
                    </x-ui.tw-badge>
                @endif
            @endforeach
        </div>



    </x-ui.tw-card>

    <x-pages.poll-show.info.user-vote-card :user-vote="$userVote" />






    {{--Pravá strana – informace o události--}}
    @if($event)
        <div>
            <x-pages.poll-show.info.event-details :event="$event" :syncGoogleCalendar="$syncGoogleCalendar" :poll="$poll" />
        </div>
    @endif

</div>

