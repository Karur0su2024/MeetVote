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


    public $timeOptions = [];

    public $questions = [];

    public $selectedTimeOption;

    public $selectedQuestionOptions = [];

    public $selected = [];

    protected PollResultsService $pollResultsService;
    protected EventService $eventService;

    public function boot(PollResultsService $pollResultsService, EventService $eventService)
    {
        $this->pollResultsService = $pollResultsService;
        $this->eventService = $eventService;
    }

    public function mount($pollIndex)
    {
        $this->poll = Poll::find($pollIndex, ['*']);

        $this->poll->load([
            'timeOptions',
            'questions',
            'questions.options',
        ]);

        $this->results = $this->pollResultsService->getPollResultsData($this->poll);

    }

    public function insertToEventModal()
    {

        $event = $this->eventService->buildEventFromValidatedData($this->poll, $this->results);

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
