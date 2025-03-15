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

        //dd($this->form, $this->poll);
    }

    #[On('submitVote')]
    public function submitVote($voteData)
    {
        $this->form->handleSubmittedData($voteData);

        if ($this->poll->status != 'active') {
            $this->dispatch('validation-failed', errors: [
                'form' => 'Poll is not active.',
            ]);
            return;
            //return redirect()->route('polls.show', ['poll' => $this->poll->public_id]);
        }

        if ($this->form->submit($this->voteService, $this->poll->id)) {
            $this->form->loadData($this->voteService->getPollData($this->poll));
            $this->dispatch('vote-submitted');
        } else {
            $this->dispatch('validation-failed', errors: $this->form->getErrors());
        }
    }


    #[On('refreshPoll')]
    public function refreshPoll($voteIndex = null)
    {
        $this->form->loadData($this->voteService->getPollData($this->poll, $voteIndex));
        $this->dispatch('refresh-poll', formData: $this->form);
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

}
