<?php

namespace App\Livewire\Pages\PollShow\PollSection;

use App\Exceptions\VoteException;
use App\Livewire\Forms\VotingForm;
use App\Models\Poll;
use App\Models\Vote;
use App\Services\Google\GoogleService;
use App\Services\Vote\VoteCreateService;
use App\Services\Vote\VoteQueryService;
use App\Services\Vote\VoteValidationService;
use App\Traits\CanOpenModals;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Nette\Schema\ValidationException;

class Voting extends Component
{

    use CanOpenModals;

    public Poll $poll;

    public VotingForm $form;

    public $loaded = false;

    public function mount($pollIndex, VoteQueryService $voteQueryService): void
    {
        $this->poll = Poll::findOrFail($pollIndex);
        $this->loadVoteSection($voteQueryService);
    }

    private function loadVoteSection(VoteQueryService $voteQueryService): void
    {
        $this->loaded = false;
        $this->form->loadData($voteQueryService->getPollData($this->poll->id));
        $this->loaded = true;
    }

    public function submitVote(
        VoteCreateService $voteCreateService,
    ): void
    {
        if(Gate::denies('canVote', $this->poll)) {
            $this->addError('error', 'You are not allowed to vote on this poll.');
            return;
        }

        try {
            $voteCreateService->saveVote($this->form->validate());
        } catch (\Exception $e) {
            Log::error('Error saving vote: ' . $e->getMessage());
            $this->addError('error', 'An error occurred while saving the vote.');
        }
    }

    #[On('refreshPoll')]
    public function refreshPoll(VoteQueryService $voteQueryService): void
    {
        $this->loadVoteSection($voteQueryService);
        $this->dispatch('show-voting-section');
    }


    public function checkAvailability(GoogleService $googleService): void
    {
        $user = Auth::user();

        if(Gate::denies('sync', $user)){
            return;
        }

        date_default_timezone_set($this->poll->timezone);
        foreach ($this->form->timeOptions as $optionIndex => $option) {
            if($option['invalid'] ?? false) {
                continue;
            }

            $this->form->timeOptions[$optionIndex]['availability'] = $googleService->checkAvailability($user, $option);
        }
    }


    public function render()
    {
        return view('livewire.pages.poll-show.poll-section.voting');
    }
}
