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
                        <x-ui.button wire:click="openModal('modals.poll.share', '{{ $poll->id }}')"
                                     color="outline-secondary"
                                     size="sm">

                            {{ __('pages/poll-show.settings.dropdown.share_poll') }}
                        </x-ui.button>
                        <x-ui.dropdown.wrapper id="poll-options-dropdown" size="md" wrapper="div" color="outline-primary">
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
                <x-ui.badge>
                    Timezone:
                    {{ $poll->timezone }} ({{  date('P') }})
                </x-ui.badge>

                @foreach($poll->settings as $attributeName => $attribute)
                    @if($attribute)
                        <x-ui.badge>
                            {{  __('pages/poll-show.info.badges.attributes.' . $attributeName) }}
                        </x-ui.badge>
                    @endif
                @endforeach
            </x-slot:footer>
        </x-ui.card>


        <x-pages.poll-show.info.user-vote-card :user-vote="$userVote" />




    {{--Pravá strana – informace o události--}}
    @if($event)
        <div>
            <x-pages.poll-show.info.event-details :event="$event" :syncGoogleCalendar="$syncGoogleCalendar" :poll="$poll" />
        </div>
    @endif

</div>

