<?php

namespace App\Livewire\Poll;

use App\Livewire\Forms\VotingForm;
use App\Models\Poll;
use App\Services\VoteService;
use Livewire\Attributes\On;
use Livewire\Component;

class Voting extends Component
{
    public Poll $poll;

    // Formulář pro hlasování
    public VotingForm $form;

    protected ?VoteService $voteService;

    public function boot(VoteService $voteService)
    {
        $this->voteService = $voteService;
    }


    public function mount(Poll $poll)
    {
        $this->poll = $poll;
        $this->form->loadData($this->voteService->getPollData($poll));
    }


    #[On('submitVote')]
    public function submitVote($voteData)
    {
        $this->form->handleSubmittedData($voteData);

        dd($this->form);

        if ($this->poll->status != 'active') {
            session()->flash('error', 'Hlasování není aktivní.');
            return redirect()->route('polls.show', ['poll' => $this->poll->public_id]);
        }

        if ($this->form->submit($this->voteService, $this->poll->id)) {
            $this->dispatch('updateVotes');
        }
    }


    #[On('refreshPoll')]
    public function refreshPoll() {}

    // Načtení hlasu
    #[On('loadVote')]
    public function loadVote($voteIndex)
    {
        $this->form->loadData($this->voteService->getPollData($this->poll, $voteIndex));
        $this->form->existingVote = $voteIndex;
    }

    #[On('removeVote')]
    public function removeVote()
    {
        $this->form->loadData($this->voteService->getPollData($this->poll));
        $this->form->existingVote = null;
    }


    #[On('updateTimeOptions')]
    public function updateTimeOptions()
    {
        $this->form->loadData($this->voteService->getPollData($this->poll));
    }



    public function render()
    {
        return view('livewire.poll.voting');
    }


    // Modální okna

    // Zobrazení modálního okna s výsledky
    public function openResultsModal()
    {
        $this->dispatch('showModal', [
            'alias' => 'modals.poll.results',
            'params' => [
                'publicIndex' => $this->poll->public_id,
            ],
        ]);
    }

    public function openAddNewTimeOptionModal()
    {
        $this->dispatch('showModal', [
            'alias' => 'modals.poll.add-new-time-option',
            'params' => [
                'publicIndex' => $this->poll->public_id,
            ],

        ]);
    }
}
