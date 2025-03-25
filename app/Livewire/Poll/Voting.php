<?php

namespace App\Livewire\Poll;

use App\Events\VoteSubmitted;
use App\Exceptions\VoteException;
use App\Livewire\Forms\VotingForm;
use App\Models\Poll;
use App\Models\Vote;
use App\Services\VoteService;
use Illuminate\Support\Facades\Gate;
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
     * @param int $pollId
     * @return void
     */
    public function mount(int $pollId): void
    {
        $this->poll = Poll::findOrFail($pollId, ['id', 'status', 'public_id', 'add_time_options']);
        $this->form->loadData($this->voteService->getPollData($this->poll->id));
    }

    /**
     * Metoda pro zpracování odeslaných dat z formuláře.
     * @param $voteData
     * @return void|null
     */
    #[On('submitVote')]
    public function submitVote($voteData): void
    {
        if(!Gate::allows('canVote', $this->poll)) {
            $this->dispatch('validation-failed', errors: [
                'form' => 'You do not have permission to vote.',
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
            $this->form->loadData($this->voteService->getPollData($this->poll->id));
            $this->dispatch('vote-submitted');
        } else {
            $this->dispatch('validation-failed', errors: $this->getErrors());
        }
    }


    /**
     * Metoda pro uložení hlasu do databáze.
     * @param $validatedData
     * @return Vote|null
     * @throws \Throwable
     */
    private function saveVote($validatedData): ?Vote
    {
        try {
            if (!$this->voteService->atLeastOnePickedPreference($validatedData)) {
                throw new VoteException('No option selected.');
            }
            $vote = $this->voteService->saveVote($validatedData);

            if (isset($validatedData['existingVote'])) {
                session()->flash('success', 'Vote has been updated successfully.');
            } else {
                session()->flash('success', 'Vote has been created successfully.');
                event(new VoteSubmitted($vote));
            }
            $this->form->loadData($this->voteService->getPollData($this->poll->id));
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
