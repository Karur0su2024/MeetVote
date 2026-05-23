@php
    /**
    * @see  resources/views/pages/polls/show.blade.php
    */
@endphp

<div class="mb-2 flex flex-col gap-4" x-data="{ showEventDetails: true }">
    <div class="card bg-base-100 shadow-sm">
        <div class="p-2 flex gap-2">
            <x-mary-dropdown>
                <x-slot:trigger class="btn btn-sm btn-primary btn-outline">
                    {{ __('Settings') }}
                </x-slot:trigger>

                <x-mary-menu-item href="{{ route('polls.edit', $poll) }}"
                                  title="{{ __('pages/poll-show.settings.dropdown.edit_poll') }}"/>

                <x-mary-menu-item class="opacity-25"
                                  {{--wire:click="openModal('modals.poll.invitations', '{{ $poll->id }}')"--}}
                                  {{--:disabled="!$poll->isActive()"--}}
                                  title="{{ __('pages/poll-show.settings.dropdown.invitations') }}"/>
                <x-mary-menu-item
                    title="{{ $poll->isActive() ? __('pages/poll-show.settings.dropdown.close_poll') : __('pages/poll-show.settings.dropdown.reopen_poll') }}"
                    @click="$wire.dispatch('openClosePollModal')"
                />

                <x-mary-menu-separator/>
                <x-mary-menu-item class="text-red-500"
                                  title="{{ __('pages/poll-show.settings.dropdown.delete_poll') }}"
                                  @click="$wire.dispatch('openPollDeleteModal')"/>
            </x-mary-dropdown>


            @can('isAdmin', $poll)
                <x-mary-button class="btn-outline btn-sm"
                               label="{{ __('pages/poll-show.settings.dropdown.share_poll') }}"
                               @click="$wire.dispatch('openShareModal')"/>
            @endcan
        </div>
    </div>

    <x-mary-card>
        <x-slot:title>
            {{ $poll->title }}
        </x-slot:title>
        <x-slot:subtitle>
            @if ($poll->description == null || $poll->description == '')
                {{ __('pages/poll-show.info.text.no_description') }}
            @else
                {{ $poll->description }}
            @endif

        </x-slot:subtitle>


        <div class="flex flex-wrap gap-1 mt-1">
            {{-- Badge s počtem hlasů --}}
            <x-mary-badge class="badge-primary badge-soft badge-sm"
                          value="{{ $poll->timezone }} ({{  date('P') }})"/>

            {{-- Badges s parametry nastavení ankety --}}
            @foreach($poll->settings as $attributeName => $attribute)
                @if($attribute)
                    <x-mary-badge class="badge-primary badge-soft badge-sm"
                                  value="{{  __('pages/poll-show.info.badges.attributes.' . $attributeName) }}"/>
                @endif
            @endforeach
        </div>


    </x-mary-card>


    <x-mary-card shadow>
        <x-slot:title>
            Authors:
        </x-slot:title>
        <x-ui.username :username="$poll->author_name"/>
    </x-mary-card>


    @if($event)
        <livewire:page-poll-show-poll-section-event-details :event="$event" :poll="$poll"/>
    @endif

    @if($poll->isActive())
        <x-pages.poll-show.info.user-vote-card :user-vote="$userVote"/>
    @endif




    <livewire:modals.poll.close :poll="$poll" />

    <livewire:modals.poll.share :poll="$poll" />

    <livewire:modals.poll.delete :poll="$poll" />

</div>

