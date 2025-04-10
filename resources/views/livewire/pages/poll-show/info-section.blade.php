@php
    /**
    * @see  resources/views/pages/polls/show.blade.php
    */
@endphp

<div class="g-4 mb-4" x-data="{ showEventDetails: true }">

    {{-- Levá strana – základní informace o anketě --}}
        <x-ui.card header-hidden
                   footer-flex>
            <x-slot:body-header>
                <h2>{{ $poll->title }}</h2>
                <div class="d-flex gap-2">
                    @can('isAdmin', $poll)
                        <x-ui.dropdown.wrapper id="poll-options-dropdown" size="md" wrapper="div">
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
                    @endcan
                </div>
            </x-slot:body-header>

            <x-slot:body>
                <div class="d-flex align-items-center text-muted mb-2">
                    {{-- Doplnit avatar uživatele --}}
                    <x-ui.icon name="person-fill" /><strong>{{ $poll->author_name }}</strong>
                </div>
                <p class="text-muted">
                    @if ($poll->description == null || $poll->description == '')
                        {{ __('pages/poll-show.info.text.no_description') }}
                    @else
                        {{ $poll->description }}
                    @endif
                </p>
            </x-slot:body>


            <x-slot:footer class="flex-wrap">
                @if ($poll->comments)
                    <x-ui.badge>
                        {{ __('pages/poll-show.info.badges.comments') }}
                    </x-ui.badge>
                @endif
                @if ($poll->anonymous_votes)
                    <x-ui.badge>
                        {{ __('pages/poll-show.info.badges.anonymous_voting') }}
                    </x-ui.badge>
                @endif
                @if ($poll->password)
                    <x-ui.badge>
                        {{ __('pages/poll-show.info.badges.password_protected') }}
                    </x-ui.badge>
                @endif
                @if ($poll->invite_only)
                    <x-ui.badge>
                        {{ __('pages/poll-show.info.badges.invite_only') }}
                    </x-ui.badge>
                @endif
                @if ($poll->edit_votes)
                    <x-ui.badge>
                        {{ __('pages/poll-show.info.badges.edit_votes') }}
                    </x-ui.badge>
                @endif
                @if ($poll->add_time_options)
                    <x-ui.badge>
                        {{ __('pages/poll-show.info.badges.add_time_options') }}
                    </x-ui.badge>
                @endif
            </x-slot:footer>
        </x-ui.card>

    @auth
        <x-pages.poll-show.info.user-vote-card :user-vote="$userVote" />
    @endauth



    {{--Pravá strana – informace o události--}}
    @if($event)
        <div>
            <x-pages.poll-show.info.event-details :event="$event" :syncGoogleCalendar="$syncGoogleCalendar" :poll="$poll" />
        </div>
    @endif

</div>

