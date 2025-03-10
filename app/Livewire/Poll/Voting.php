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

    public $existingVote;

    public function __construct()
    {
        $this->voteService = app(VoteService::class);
    }

    public function mount(Poll $poll, VoteService $voteService)
    {
        // Tohle nechat
        $this->poll = $poll;

        $this->form->loadData($this->voteService->getPollData($poll));
    }

    public function submit()
    {
        try {
            $this->form->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Zde můžete zpracovat chybu validace
            dd($e->validator->errors());

            return;
        }
        $validatedData = $this->form->validate();

        $validatedData['poll_id'] = $this->poll->id;

        $this->voteService->saveVote($validatedData);

        $this->form->loadData($this->voteService->getPollData($this->poll));

        // Metoda pro odeslání formuláře

        $this->dispatch('updateVotes');
    }

    // Načtení hlasu
    #[On('loadVote')]
    public function loadVote($voteIndex)
    {
        $this->form->loadData($this->voteService->getPollData($this->poll, $voteIndex));
        $this->form->existingVote = $voteIndex;
    }

    public function changePreference($questionIndex, $optionIndex, $value)
    {

        // dd($questionIndex, $optionIndex, $value);

        if ($questionIndex == null) {
            $this->changeTimeOptionPreference($optionIndex, $value);
        } else {
            $this->changeQuestionOptionPreference($questionIndex, $optionIndex, $value);
        }
    }

    private function changeTimeOptionPreference($timeOptionIndex, $value)
    {
        $this->form->timeOptions[$timeOptionIndex]['picked_preference'] = $value;
    }

    private function changeQuestionOptionPreference($questionIndex, $optionIndex, $value)
    {
        $this->form->questions[$questionIndex]['options'][$optionIndex]['picked_preference'] = $value;
    }

    public function openResultsModal()
    {
        $this->dispatch('showModal', [
            'alias' => 'modals.poll.results',
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
