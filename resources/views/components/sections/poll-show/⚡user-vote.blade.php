<?php

use Livewire\Component;
use App\Models\Poll;
use App\Services\PollResultsService;
use App\Traits\CanOpenModals;
use App\Traits\HasVoteControls;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Models\Vote;
use Mary\Traits\Toast;


new class extends Component {
    public $userVote;
    use Toast;

    public function boot(PollResultsService $pollResultsService): void
    {
        $this->pollResultsService = $pollResultsService;
    }

    public function mount($pollIndex, PollResultsService $pollResultsService): void
    {
        $this->poll = Poll::findOrFail($pollIndex);
        $this->userVote = $pollResultsService->getUserVote($this->poll);
    }

    public function deleteVote($voteId){
        $vote = Vote::find($voteId);
        $poll = $vote->poll;
        $vote->delete();
        $this->success(
            title: 'Your vote was deleted',
            redirectTo: route('polls.show', ['poll' => $poll]),
            position: 'toast-end toast-bottom'
        );
    }

};
?>

<x-ui.card>
    <div class="flex items-center justify-between">
        <x-ui.text.title-w-icon>
            <x-slot:icon>
                <x-mary-icon name="o-check-circle" class="text-xl"/>
            </x-slot:icon>
            <x-slot:title>
                {{ __('pages/poll-show.your_vote.title') }}
            </x-slot:title>
            <x-slot:subtitle>
                @if($userVote)
                    {{ Carbon\Carbon::parse($userVote->created_at)->format('d.m.Y') }}
                @endif
            </x-slot:subtitle>
        </x-ui.text.title-w-icon>
        @can('delete', $userVote)
            <x-mary-button class="btn-error btn-sm float-end btn-outline"
                           wire:click="deleteVote({{ $userVote->id }})"
                           label="{{ __('pages/poll-show.your_vote.buttons.delete') }}"
                           spinner />
        @endcan
    </div>


    @if($userVote && ($userVote->questionOptions->count() > 0 || $userVote->timeOptions->count() > 0))
        <x-sections.poll-show.results.vote-content :vote="$userVote"/>
        @cannot('edit', $userVote)

            <div class="mt-2">
                <p class="text-md font-light color-gray-500">
                    {{ __('pages/poll-show.your_vote.text.login_to_change_vote') }}
                </p>
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                    {{ __('pages/poll-show.your_vote.buttons.login') }}
                </a>
            </div>
        @endcannot
    @else
        <p class="text-sm font-light text-gray-500">
            {{ __('pages/poll-show.your_vote.no_vote') }}
        </p>
    @endif
</x-ui.card>
