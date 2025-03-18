<?php

namespace App\Livewire\Poll;

use App\Livewire\Forms\PollForm;
use App\Models\Poll;
use App\Services\PollService;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use App\ToAlpine\Form\TimeOptionsToAlpine;
use App\ToAlpine\Form\QuestionsToAlpine;

class Form extends Component
{
    use TimeOptionsToAlpine;

    use QuestionsToAlpine;

    public PollForm $form;

    public ?Poll $poll;

    // Služby
    protected PollService $pollService;

    public function boot(PollService $pollService) {
        $this->pollService = $pollService;
    }

    // Konstruktor
    public function mount(?Poll $poll)
    {
        // Načtení dat ankety
        $this->poll = $poll;
        $this->form->loadForm($this->pollService->getPollData($poll));
    }

    public function submit()
    {
        $poll = $this->form->submit($this->pollService);

        if ($poll) {
            session()->put('poll_'.$poll->public_id.'_adminKey', $poll->admin_key);
            return redirect()->route('polls.show', $poll);
        }

    }







    // Renderování komponenty
    public function render()
    {
        return view('livewire.poll.form');
    }
}
