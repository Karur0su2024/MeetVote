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
                <x-mary-menu-item href="#"
                                  class="opacity-25"
                                  {{--wire:click="openModal('modals.poll.invitations', '{{ $poll->id }}')"--}}
                                  {{--:disabled="!$poll->isActive()"--}}
                                  title="{{ __('pages/poll-show.settings.dropdown.invitations') }}"/>
                <x-mary-menu-item
                    title="{{ $poll->isActive() ? __('pages/poll-show.settings.dropdown.close_poll') : __('pages/poll-show.settings.dropdown.reopen_poll') }}"
                    href="#"
                    @click="$wire.myModal1 = true"
                    {{--                    wire:click="openModal('modals.poll.close-poll', '{{ $poll->id }}')"--}}
                />
                <x-mary-menu-separator/>
                <x-mary-menu-item class="text-red-500"
                                  title="{{ __('pages/poll-show.settings.dropdown.delete_poll') }}"
                                  @click="$wire.myModal2 = true"/>
            </x-mary-dropdown>


            @can('isAdmin', $poll)
                <x-mary-button class="btn-outline btn-sm"
                               label="{{ __('pages/poll-show.settings.dropdown.share_poll') }}"
                               wire:click="openModal('modals.poll.share', '{{ $poll->id }}')"/>
                {{-- Nabídka pro správu ankety --}}
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

    <x-mary-modal wire:model="myModal1"
                  title="{{ $poll->isActive() ? __('ui/modals.close_poll.title.close') : __('ui/modals.close_poll.title.reopen') }}"
                  class="backdrop-blur z-10">
        @if (session()->has('error'))
            <span class="text-error">
                {{ session('error') }}
            </span>
        @else
            @if ($poll->isActive())
                @if (count($poll->votes) === 0)
                    <x-mary-alert title="{{ __('ui/modals.close_poll.alerts.no_votes') }}"
                                  class="alert-error"
                                  icon="o-exclamation-triangle"/>
                @else
                    <x-mary-alert class="alert-warning"
                                  title="{{ __('ui/modals.close_poll.text.poll_count', ['count_poll_votes' => count($poll->votes)]) . ' ' . __('ui/modals.close_poll.text.is_user_sure') }}"
                                  icon="o-exclamation-triangle"/>

                @endif
            @else
                <x-mary-alert class="alert-warning"
                              title="{{ __('ui/modals.close_poll.text.reopen') }}"
                              icon="o-exclamation-triangle"/>

                @if($hasEvent)
                    <x-mary-alert class="alert-warning"
                                  title="{{ __('ui/modals.close_poll.alerts.event_will_be_deleted') }}"
                                  icon="o-exclamation-triangle"/>
                @endif
                <x-mary-datetime label="{{ __('ui/modals.close_poll.labels.new_deadline') }}"
                              wire:model="newDeadline"
                />

            @endif
        @endif
        <x-slot:actions>
            <x-mary-button label="{{ __('ui/modals.close_poll.buttons.cancel') }}"
                           class="btn-neutral"
                           @click="$wire.myModal1 = false"
            />
            <x-mary-button
                label="{{ $poll->isActive() ? __('ui/modals.close_poll.buttons.close') : __('ui/modals.close_poll.buttons.reopen') }}"
                class="btn-error {{ count($poll->votes) === 0 ? 'btn-disabled' : '' }}"
                wire:click="closePoll()"
            />
        </x-slot:actions>
    </x-mary-modal>

    <x-mary-modal wire:model="myModal2"
                  title="{{ __('ui/modals.delete_poll.title') }}"
                  class="backdrop-blur z-10">
        <x-mary-alert title="{{ __('ui/modals.delete_poll.text.question') . ' ' . __('ui/modals.delete_poll.text.warning') }}"
                      class="alert-error"
                      icon="o-exclamation-triangle"/>

        @if (session()->has('error'))
            <span class="text-danger">
                {{ session('error') }}
            </span>
        @endif
        <x-slot:actions>
            <x-mary-button label="{{ __('ui/modals.close_poll.buttons.cancel') }}"
                           class="btn-neutral"
                           @click="$wire.myModal2 = false"
            />
            <x-mary-button
                label="{{ __('ui/modals.invitations.table.actions.delete') }}"
                class="btn-error"
                wire:click="deletePoll()"
            />
        </x-slot:actions>
    </x-mary-modal>
</div>

