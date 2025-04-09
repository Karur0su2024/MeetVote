<?php

namespace App\Livewire\Pages\PollShow\PollSection;

use App\Exceptions\VoteException;
use App\Livewire\Forms\VotingForm;
use App\Models\Poll;
use App\Models\Vote;
use App\Services\Google\GoogleService;
use App\Services\PollResultsService;
use App\Services\Vote\VoteCreateService;
use App\Services\Vote\VoteQueryService;
use App\Services\Vote\VoteValidationService;
use App\Traits\CanOpenModals;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;

class Voting extends Component
{

    use CanOpenModals;

    public Poll $poll;

    public VotingForm $form;


    public $results = [];

    public $loaded = false;



    public function mount($poll, VoteQueryService $voteQueryService, PollResultsService $pollResultsService): void
    {
        $this->poll = $poll;
        $this->reloadVoteSection($voteQueryService);
        $this->results = $pollResultsService->getResults($this->poll);

    }

    public function submitVote(
        VoteValidationService $voteValidationService,
        VoteQueryService $voteQueryService,
        VoteCreateService $voteCreateService,
    ): void
    {
        if(Gate::denies('canVote', $this->poll)) {
            $this->addError('error', 'You are not allowed to vote on this poll.');
            return;
        }

        $validatedData = $this->form->validate();
        $validatedData['poll_id'] = $this->poll->id;

        if($voteValidationService->isPickedPreferenceValid($validatedData)) {
            $this->addError('error', 'You must select at least one option.');
            return;
        }

        $vote = $this->saveVote($validatedData, $voteCreateService, $voteQueryService);

        if ($vote) {
            $this->reloadVoteSection($voteQueryService);
        }
    }

    private function saveVote(
        $validatedData,
        VoteCreateService $voteCreateService,
        VoteQueryService $voteQueryService): ?Vote
    {
        try {
            $voteCreateService->saveVote($validatedData);
        } catch (VoteException $e) {
            $this->addError('error', 'An error occurred while saving the vote.');
        } catch (\Exception $e) {
            $this->addError('error', 'An error occurred while saving the vote.');
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getErrors(): array
    {
        return $this->getErrorBag()->toArray();
    }

    /**
     * Metoda pro aktualizaci formuláře.
     * @param $voteIndex
     * @return void
     */
    #[On('refreshPoll')]
    public function refreshPoll(VoteQueryService $voteQueryService, $voteIndex): void
    {
        $this->reloadVoteSection($voteQueryService, $voteIndex);
        $this->dispatch('show-voting-section');
    }


    private function reloadVoteSection(VoteQueryService $voteQueryService, $voteIndex = null): void
    {
        $this->loaded = false;
        $this->form->loadData($voteQueryService->getPollData($this->poll));
        $this->loaded = true;
    }


    public function checkAvailability(GoogleService $googleService): void
    {
        if(Gate::denies('sync', Auth::user())){
            return;
        }
        $user = Auth::user();

        foreach ($this->form->timeOptions as $optionIndex => $option) {
            $startTime = $option['date'] . ' ' . ($option['content']['start'] ?? '');
            $endTime = $option['date'] . ' ' . ($option['content']['end'] ?? '');
            $this->form->timeOptions[$optionIndex]['availability'] = $googleService->checkAvailability($user, $startTime, $endTime);
        }
    }


    public function render()
    {
        return view('livewire.pages.poll-show.poll-section.voting');
    }
}
