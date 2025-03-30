<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Poll;
use App\Models\QuestionOption;
use App\Services\EventService;
use App\Services\PollResultsService;
use App\Services\QuestionService;
use App\Services\TimeOptionService;
use Carbon\Carbon;
use Livewire\Component;

class ChooseFinalOptions extends Component
{
    public $poll;

    public $results = [
        'timeOptions' => [
            'options' => [],
            'selected' => 0,
        ],
        'questions' => [
            'questions' => [
            ],
        ],
    ];

    public function mount($pollIndex, PollResultsService $pollResultsService)
    {
        $this->poll = Poll::find($pollIndex, ['*']);

        $this->poll->load([
            'timeOptions',
            'questions',
            'questions.options',
        ]);

        $this->results = $pollResultsService->getResults($this->poll);

    }

    public function insertToEventModal(EventService $eventService)
    {

        $event = $eventService->buildEventFromValidatedData($this->poll, $this->results);

        $this->dispatch('showModal', [
            'alias' => 'modals.poll.create-event',
            'params' => [
                'eventData' => $event,
                'pollIndex' => $this->poll->id,
            ],

        ]);

    }

    public function render()
    {
        return view('livewire.modals.poll.choose-final-options');
    }
}
