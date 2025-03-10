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

    // Služby
    protected ?VoteService $voteService;

    public function __construct()
    {
        $this->voteService = app(VoteService::class);
    }

    public function mount(Poll $poll)
    {
        // Tohle nechat
        $this->poll = $poll;

        $this->form->loadData($this->voteService->getPollData($poll));
    }

    public function submit()
    {
        if($this->form->submit($this->voteService, $this->poll->id)) {
            $this->dispatch('updateVotes');
            // Sem přidat odeslání notifikace
        }
    }

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

    // Změna preference
    public function changePreference($questionIndex, $optionIndex, $value)
    {
        if ($questionIndex == null) {
            $this->changeTimeOptionPreference($optionIndex, $value);
        } else {
            $this->changeQuestionOptionPreference($questionIndex, $optionIndex, $value);
        }
    }

    // Změna preference pro časovou volbu
    private function changeTimeOptionPreference($timeOptionIndex, $value)
    {
        $this->form->timeOptions[$timeOptionIndex]['picked_preference'] = $value;
    }

    // Změna preference pro otázku
    private function changeQuestionOptionPreference($questionIndex, $optionIndex, $value)
    {
        $this->form->questions[$questionIndex]['options'][$optionIndex]['picked_preference'] = $value;
    }

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

    #[On('updateTimeOptions')]
    public function updateTimeOptions()
    {
        $this->form->loadData($this->voteService->getPollData($this->poll));
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

    public function render()
    {
        return view('livewire.poll.voting');
    }
}
