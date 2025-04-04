<?php

namespace App\Livewire\Pages\PollShow;

use App\Events\VoteSubmitted;
use App\Exceptions\VoteException;
use App\Livewire\Forms\VotingForm;
use App\Models\Poll;
use App\Models\Vote;
use App\Services\Vote\VoteCreateService;
use App\Services\Vote\VoteQueryService;
use App\Services\Vote\VoteService;
use App\Services\Vote\VoteValidationService;
use App\Traits\CanOpenModals;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;

class VotingSection extends Component
{

    use CanOpenModals;

    public Poll $poll;

    public VotingForm $form;

    protected VoteService $voteService;

    public $loaded = false;


    /**
     * @param int $pollInex
     * @return void
     */
    public function mount(int $pollIndex, VoteQueryService $voteQueryService): void
    {
        $this->poll = Poll::with(['timeOptions', 'questions', 'questions.options'])->findOrFail($pollIndex, ['id', 'status', 'public_id', 'add_time_options', '.anonymous_votes']);
        $this->reloadVoteSection($voteQueryService);
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

    /**
     * Metoda pro uložení hlasu do databáze.
     * @param $validatedData
     * @return Vote|null
     * @throws \Throwable
     */
    private function saveVote(
        $validatedData,
        VoteCreateService $voteCreateService,
        VoteQueryService $voteQueryService): ?Vote
    {
        try {
            $vote = $voteCreateService->saveVote($validatedData);

            if (isset($validatedData['existingVote'])) {
                session()->flash('success', 'Vote has been updated successfully.');
            } else {
                session()->flash('success', 'Vote has been created successfully.');
                //event(new VoteSubmitted($vote));
            }
            $this->reloadVoteSection($voteQueryService);
            return $vote;
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
    }


    private function reloadVoteSection(VoteQueryService $voteQueryService, $voteIndex = null): void
    {
        $this->loaded = false;
        $this->form->loadData($voteQueryService->getPollData($this->poll, $voteIndex));
        $this->loaded = true;
    }

    public function status()
    {
        dd($this->form);
    }

    /**
     *
     */
    public function render()
    {
        return view('livewire.pages.poll-show.voting-section');
    }

}
