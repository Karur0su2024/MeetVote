<?php

use Livewire\Component;
use App\Models\Vote;

new class extends Component
{
    //use HasVoteControls;

    public $vote;
    public $poll;
    public $showModal = false;

    public $listeners = [
        'openUserVoteModal' => 'openModal'
    ];

    public function openModal($voteId){
        $this->vote = Vote::find($voteId)->firstOrFail();
        $this->showModal = true;
        $this->poll = $this->vote->poll;
    }

};
?>


{{-- Modální okno s konkrétní odpovedí --}}
{{--<div>
    <x-ui.modal.header>
        {{ __('ui/modals.results.title') }}
    </x-ui.modal.header>
    <div class="modal-body">
        <div class="fw-bold fs-5">{{ ($vote->poll->settings['anonymous_votes'] ?? false) ? 'Anonymous' : (Auth::user()->name ?? $vote->voter_name) }}
            @if (Auth::id() === $vote->user_id )
                <i class="bi bi-person-fill ms-1"></i>
            @endif

        </div>
        <div class="badge badge-outline badge-sm badge-primary">
            {{ Carbon\Carbon::parse($vote->updated_at)->diffForHumans() }}
        </div>
        @if(session()->has('poll.' . $vote->poll->id .'.vote'))
            @cannot('edit', $vote)

                <div class="mt-2">
                    <p class="mb-1">
                        You can change your vote only if you are logged in.
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn">
                        {{ __('pages/poll-show.your_vote.buttons.login') }}
                    </a>
                </div>
            @endcannot
        @endif

        <div class="mt-1">
            {{ $vote->message ?? '' }}
        </div>


        @can('delete', $vote)
            <div class="mt-3">
                <x-ui.tw-button color="error" wire:click="deleteVote({{$vote->id}})">
                    <x-ui.icon name="trash" /> Delete
                </x-ui.tw-button>
            </div>
        @endcan


    </div>
</div>--}}

<x-mary-modal wire:model="showModal"
              class="backdrop-blur z-10">
    @if($this->vote !== null)
        <x-slot:title>
            {{ $poll->isActive() ? __('ui/modals.close_poll.title.close') : __('ui/modals.close_poll.title.reopen') }}
        </x-slot:title>

        <x-pages.poll-show.poll.results.vote-content :vote="$vote"/>


        <x-slot:actions>
            <x-mary-button label="{{ __('ui/modals.close_poll.buttons.cancel') }}"
                           class="btn-neutral"
                           @click="$wire.showModal = false"
            />
            <x-mary-button
                label="{{ $poll->isActive() ? __('ui/modals.close_poll.buttons.close') : __('ui/modals.close_poll.buttons.reopen') }}"
                class="btn-error {{ count($poll->votes) === 0 ? 'btn-disabled' : '' }}"
                wire:click="closePoll()"
            />
        </x-slot:actions>
    @endif
</x-mary-modal>
