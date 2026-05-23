@php
    /**
    * @see  resources/views/pages/polls/show.blade.php
    */
@endphp

<div class="mb-2 flex flex-col gap-4" x-data="{ showEventDetails: true }">
    <x-ui.tw-card>
        <x-slot:title>
            {{ $poll->title }}
        </x-slot:title>

        <x-ui.username :username="$poll->author_name" />
        <p class="break-normal text-sm text-gray-400 font-light">
            @if ($poll->description == null || $poll->description == '')
                {{ __('pages/poll-show.info.text.no_description') }}
            @else
                {{ $poll->description }}
            @endif
        </p>


        <div class="flex flex-wrap gap-1 mt-1">
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

        <div class="flex gap-2 mt-3">
            @can('isAdmin', $poll)
                <button class="btn btn-sm btn-outline"
                        wire:click="openModal('modals.poll.share', '{{ $poll->id }}')">
                    {{ __('pages/poll-show.settings.dropdown.share_poll') }}

                </button>
                {{-- Nabídka pro správu ankety --}}
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline">
                        <x-ui.icon class="gear me-1"/>
                        {{ __('pages/poll-show.settings.dropdown.options') }}
                    </button>
                    <ul class="menu dropdown-content bg-base-200 shadow-md rounded-box w-32 z-50">
                        <li>
                            <a href="{{ route('polls.edit', $poll) }}">
                                {{ __('pages/poll-show.settings.dropdown.edit_poll') }}
                            </a>
                        </li>
{{--                        <li>--}}
{{--                            <a href="#" wire:click="openModal('modals.poll.invitations', '{{ $poll->id }}')"--}}
{{--                               :disabled="!$poll->isActive()">--}}
{{--                                {{ __('pages/poll-show.settings.dropdown.invitations') }}--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        <li>
                            <a href="#" wire:click="openModal('modals.poll.close-poll', '{{ $poll->id }}')">
                                @if ($poll->isActive())
                                    {{ __('pages/poll-show.settings.dropdown.close_poll') }}
                                @else
                                    {{ __('pages/poll-show.settings.dropdown.reopen_poll') }}
                                @endif
                            </a>
                        </li>
                        <li>
                            <a class="text-red-500" href="#" wire:click="openModal('modals.poll.delete-poll', '{{ $poll->id }}')">
                                {{ __('pages/poll-show.settings.dropdown.delete_poll') }}
                            </a>
                        </li>
                    </ul>
                </div>
            @endcan
        </div>





    </x-ui.tw-card>

    @if($event)
        <livewire:page-poll-show-poll-section-event-details :event="$event" :poll="$poll" />
    @endif

    @if($poll->isActive())
        <x-pages.poll-show.info.user-vote-card :user-vote="$userVote" />
    @endif

</div>

