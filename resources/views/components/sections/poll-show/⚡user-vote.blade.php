<?php

use Livewire\Component;
use App\Models\Poll;
use App\Services\PollResultsService;
use App\Traits\CanOpenModals;
use App\Traits\HasVoteControls;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


new class extends Component {
    public $userVote;

    public function boot(PollResultsService $pollResultsService): void
    {
        $this->pollResultsService = $pollResultsService;
    }

    public function mount($pollIndex, PollResultsService $pollResultsService): void
    {
        $this->poll = Poll::findOrFail($pollIndex);
        $this->userVote = $pollResultsService->getUserVote($this->poll);
    }

};
?>

<x-ui.card>
    <div class="flex items-center justify-between">
        <div class="flex items-start gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary">
                <x-mary-icon name="o-check-circle" class="text-xl"/>
            </div>

            <div>
                <h4 class="text-lg font-semibold">
                    {{ __('pages/poll-show.your_vote.title') }}
                </h4>
                @if($userVote)
                    <p class="text-xs text-base-content/60">
                        {{ Carbon\Carbon::parse($userVote->created_at)->format('d.m.Y') }}
                    </p>
                @endif
            </div>

        </div>
        <div class="flex items-center gap-1">
            @can('delete', $userVote)
                <button class="btn btn-error btn-sm float-end btn-outline"
                        wire:click="deleteVote({{ $userVote->id }})">
                    <i class="bi bi-trash"></i>
                    {{ __('pages/poll-show.your_vote.buttons.delete') }}
                </button>
            @endcan
        </div>
    </div>


    @if($userVote && ($userVote->questionOptions->count() > 0 || $userVote->timeOptions->count() > 0))
        <x-pages.poll-show.poll.results.vote-content :vote="$userVote"/>
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
        <p class="text-md font-light text-gray-500">
            {{ __('pages/poll-show.your_vote.no_vote') }}
        </p>
    @endif
</x-ui.card>
