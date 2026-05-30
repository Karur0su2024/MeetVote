<?php

use App\Models\Poll;
use App\Services\EventService;
use App\Services\PollResultsService;
use App\Traits\HasVoteControls;
use Livewire\Component;

new class extends Component {
    use HasVoteControls;

    public $poll;

    public $event;

    protected PollResultsService $pollResultsService;

    protected EventService $eventService;

    public $status;

    public $hasEvent;

    public function boot(EventService $eventService): void
    {
        $this->eventService = $eventService;
    }

    public function mount($pollIndex, PollResultsService $pollResultsService): void
    {
        $this->poll = Poll::findOrFail($pollIndex);

        if ($this->poll) {
            $this->event = $this->poll->event()->first();
        }

        $this->hasEvent = $this->poll->event()->exists();

    }
};
?>

<div class="flex flex-col gap-1" x-data="{ showEventDetails: true }">
    @can('hasAdminPermissions', $poll)
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
                            @click="$wire.dispatch('openClosePollModal', { pollId: {{ $poll->id }} })"
                    />

                    <x-mary-menu-separator/>
                    <x-mary-menu-item class="text-red-500"
                                      title="{{ __('pages/poll-show.settings.dropdown.delete_poll') }}"
                                      @click="$wire.dispatch('openPollDeleteModal', { pollId: {{ $poll->id }} })"/>
                </x-mary-dropdown>


                @can('isAdmin', $poll)
                    <x-mary-button class="btn-outline btn-sm"
                                   label="{{ __('pages/poll-show.settings.dropdown.share_poll') }}"
                                   @click="$wire.dispatch('openShareModal', { pollId: {{ $poll->id }} })"/>
                @endcan
            </div>
        </div>

    @endcan

    <x-mary-card class="shadow-sm">
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


    <x-ui.card>
        <x-ui.text.title-w-icon>
            <x-slot:icon>
                <x-mary-icon name="o-users"/>
            </x-slot:icon>
            <x-slot:title>
                Authors
            </x-slot:title>
            <x-slot:subtitle>
                Total: 0
            </x-slot:subtitle>
        </x-ui.text.title-w-icon>
        <ul class="list bg-base-200/50 rounded-box">
            <li class="list-row border border-base-300">
                @auth
                    <div class="avatar avatar-placeholder">
                        <div
                                class="w-6 rounded-full bg-purple-600 text-neutral-content flex items-center justify-center">
                            <span class="text-sm">
                                {{ mb_substr(Auth::user()->name, 0, 1) }}
                            </span>
                        </div>
                    </div>
                @endauth
                <div>
                    <span>
                        {{ Auth::user()->name ?? '' }}
                    </span>
                </div>
                <div>
                    <span class="badge badge-primary badge-sm">admin</span>
                </div>
            </li>
        </ul>

    </x-ui.card>


</div>
