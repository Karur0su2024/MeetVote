@php
    /**
    * @see  resources/views/pages/polls/show.blade.php
    */
@endphp

<div class="g-4 mb-4" x-data="{ showEventDetails: true }">
    {{-- Levá strana – základní informace o anketě --}}

    <div class="card shadow-sm bg-base-100 p-4 mb-3">
        <div class="flex flex-row">
            <h2 class="text-3xl flex-1 mb-1">
                {{ $poll->title }}
            </h2>
        </div>
        <div class="flex flex-row text-sm gap-1 my-2">
            <div class="avatar avatar-placeholder">
                <div class="bg-neutral text-neutral-content w-6 rounded-full me-1">
                    <span class="text-sm">{{ $poll->author_name[0] }}</span>
                </div>
            </div>
            {{ $poll->author_name }}
        </div>
        <p>
            @if ($poll->description == null || $poll->description == '')
                {{ __('pages/poll-show.info.text.no_description') }}
            @else
                {{ $poll->description }}
            @endif
        </p>
        <div class="flex-row mt-2">
            <x-ui.badge-new tooltip="test">
                {{ $poll->timezone }} ({{  date('P') }})
            </x-ui.badge-new>
            @foreach($poll->settings as $attributeName => $attribute)
                @if($attribute)
                    <x-ui.badge-new>
                        {{  __('pages/poll-show.info.badges.attributes.' . $attributeName) }}
                    </x-ui.badge-new>
                @endif
            @endforeach
        </div>

        @can('isAdmin', $poll)
            <div class="flex flex-row gap-3 mt-3">
                <button wire:click="openModal('modals.poll.share', '{{ $poll->id }}')"
                        class="btn btn-sm">
                    {{ __('pages/poll-show.settings.dropdown.share_poll') }}
                </button>
                <div class="dropdown dropdown-end">
                    <button class="btn btn-sm">{{ __('pages/poll-show.settings.dropdown.options') }}</button>
                    <ul class="menu dropdown-content w-52 rounded-box bg-base-100 shadow">
                        <li>
                            <a href="{{ route('polls.edit', $poll) }}">
                                <i class="bi bi-pencil-square me-1"></i>
                                {{ __('pages/poll-show.settings.dropdown.edit_poll') }}
                            </a>
                        </li>
                        @auth
                            <li>
                                <button wire:click="openModal('modals.poll.invitations', '{{ $poll->id }}')"
                                        :disabled="!$poll->isActive()">
                                    <i class="bi bi-person-plus me-1"></i>
                                    {{ __('pages/poll-show.settings.dropdown.invitations') }}
                                </button>
                            </li>
                        @endauth
                        <li>
                            <button  wire:click="openModal('modals.poll.close-poll', '{{ $poll->id }}')">
                                @if ($poll->isActive())
                                    <i class="bi bi-lock me-1"></i>
                                    {{ __('pages/poll-show.settings.dropdown.close_poll') }}
                                @else
                                    <i class="bi bi-unlock me-1"></i>
                                    {{ __('pages/poll-show.settings.dropdown.reopen_poll') }}
                                @endif
                            </button>
                        </li>
                        <div class="divider my-1"></div>
                        <li class="text-error">
                            <button wire:click="openModal('modals.poll.delete-poll', '{{ $poll->id }}')">
                                <i class="bi bi-trash me-1"></i>
                                {{ __('pages/poll-show.settings.dropdown.delete_poll') }}
                            </button>
                        </li>

                    </ul>
                </div>
            </div>

        @endcan


    </div>



        <x-pages.poll-show.info.user-vote-card-new :user-vote="$userVote" />




    {{--Pravá strana – informace o události--}}
    @if($event)
        <div>
            <x-pages.poll-show.info.event-details :event="$event" :syncGoogleCalendar="$syncGoogleCalendar" :poll="$poll" />
        </div>
    @endif

</div>

