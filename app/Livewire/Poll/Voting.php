<?php

namespace App\Livewire\Poll;

use App\Events\VoteSubmitted;
use App\Exceptions\VoteException;
use App\Livewire\Forms\VotingForm;
use App\Models\Poll;
use App\Models\Vote;
use App\Services\VoteService;
use Livewire\Attributes\On;
use Livewire\Component;

class Voting extends Component
{
    /**
     * @var Poll
     */
    public Poll $poll;

    // Formulář pro hlasování
    /**
     * @var VotingForm
     */
    public VotingForm $form;

    /**
     * @var VoteService
     */
    protected VoteService $voteService;

    /**
     * @param VoteService $voteService
     * @return void
     */
    public function boot(VoteService $voteService): void
    {
        $this->voteService = $voteService;
    }

    /**
     * @param Poll $poll
     * @return void
     */
    public function mount(Poll $poll): void
    {
        $this->poll = $poll;
        $this->form->loadData($this->voteService->getPollData($poll));
    }

    /**
     * Metoda pro zpracování odeslaných dat z formuláře.
     * @param $voteData
     * @return void|null
     */
    #[On('submitVote')]
    public function submitVote($voteData): void
    {
        $this->form->handleSubmittedData($voteData);

        // V případě, že je anketa uzavřena, je stránka aktualizována
        if ($this->poll->status !== 'active') {
            $this->dispatch('validation-failed', errors: [
                'form' => 'Poll is not active.',
            ]);
            return;
        }

        try {
            $validatedData = $this->form->validate();
            $validatedData['poll_id'] = $this->poll->id;
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
            return;
        }

        $vote = $this->saveVote($validatedData);

        if ($vote) {
            $this->form->loadData($this->voteService->getPollData($this->poll));
            $this->dispatch('vote-submitted');
        } else {
            $this->dispatch('validation-failed', errors: $this->getErrors());
        }
    }


    /**
     * Metoda pro uložení hlasu do databáze.
     * @param $validatedData
     * @param VoteService $voteService
     * @return Vote|null
     * @throws \Throwable
     */
    private function saveVote($validatedData): ?Vote
    {
        try {
            if (!$this->voteService->atLeastOnePickedPreference($validatedData)) {
                throw new VoteException('No option selected.');
            }
            $vote = this->saveVote($validatedData);

            if (isset($validatedData['existingVote'])) {
                session()->flash('success', 'Vote has been updated successfully.');
            } else {
                session()->flash('success', 'Vote has been created successfully.');
                event(new VoteSubmitted($vote));
            }

            $this->form->loadData($this->voteService->getPollData($this->poll));
            return $vote;
        } catch (VoteException $e) {
            session()->flash('error', $e->getMessage());
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while saving the vote.');
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
    public function refreshPoll($voteIndex = null): void
    {
        $this->form->loadData($this->voteService->getPollData($this->poll, $voteIndex));
        $this->dispatch('refresh-poll', formData: $this->form);
    }


    /**
     * @return void
     */
    #[On('updateTimeOptions')]
    public function updateTimeOptions(): void
    {
        $this->form->loadData($this->voteService->getPollData($this->poll));
    }


    /**
     *
     */
    public function render()
    {
        return view('livewire.poll.voting');
    }

}
