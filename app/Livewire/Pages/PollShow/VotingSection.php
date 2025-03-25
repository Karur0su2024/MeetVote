<?php

namespace App\Livewire\Pages\PollShow;

use App\Events\VoteSubmitted;
use App\Exceptions\VoteException;
use App\Livewire\Forms\VotingForm;
use App\Models\Poll;
use App\Models\Vote;
use App\Services\VoteService;
use App\Traits\Traits\CanOpenModals;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;

class VotingSection extends Component
{

    use CanOpenModals;
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

    public $loaded = false;

    /**
     * @param VoteService $voteService
     * @return void
     */
    public function boot(VoteService $voteService): void
    {
        $this->voteService = $voteService;
    }

    /**
     * @param int $pollInex
     * @return void
     */
    public function mount(int $pollIndex): void
    {
        $this->poll = Poll::with(['timeOptions', 'questions', 'questions.options'])->findOrFail($pollIndex, ['id', 'status', 'public_id', 'add_time_options']);

        $this->reloadSection();
    }

    /**
     * Metoda pro zpracování odeslaných dat z formuláře.
     * @param $voteData
     * @return void|null
     */
    #[On('submitVote')]
    public function submitVote(): void
    {
        if(!Gate::allows('canVote', $this->poll)) {
            $this->addError('error', 'You are not allowed to vote on this poll.');
            return;
        }

        $validatedData = $this->form->validate();
        $validatedData['poll_id'] = $this->poll->id;

        $selected = false;

        foreach ($this->form->timeOptions as $timeOption) {
            if ($timeOption['picked_preference'] !== -0) {
                $selected = true;
                break;
            }
        }

        foreach ($this->form->questions as $question) {
            foreach ($question['options'] as $option) {
                if ($option['picked_preference'] !== 0) {
                    $selected = true;
                    break;
                }
            }
        }

        if(!$selected) {
            $this->addError('error', 'You must select at least one option.');
            return;
        }


        $vote = $this->saveVote($validatedData);

        if ($vote) {
            $this->form->loadData($this->voteService->getPollData($this->poll->id));
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
        $this->form->loadData($this->voteService->getPollData($this->poll->id, $voteIndex));
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

    private function reloadSection(): void
    {
        $this->loaded = false;
        $this->form->loadData($this->voteService->getPollData($this->poll->id));
        $this->loaded = true;
    }

    /**
     *
     */
    public function render()
    {
        return view('livewire.pages.poll-show.voting-section');
    }

}
