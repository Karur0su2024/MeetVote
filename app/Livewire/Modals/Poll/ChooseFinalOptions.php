<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Poll;
use App\Models\QuestionOption;
use App\Services\QuestionService;
use App\Services\TimeOptionService;
use Carbon\Carbon;
use Livewire\Component;

class ChooseFinalOptions extends Component
{
    public $poll;

    public $timeOptions = [];

    public $questions = [];

    public $selectedTimeOption;

    public $selectedQuestionOptions = [];

    public $selected = [];

    protected TimeOptionService $timeOptionService;
    protected QuestionService $questionService;

    public function boot(TimeOptionService $timeOptionService, QuestionService $questionService)
    {
        $this->timeOptionService = $timeOptionService;
        $this->questionService = $questionService;
    }

    public function mount($pollId)
    {

        try {
            $this->poll = Poll::find($pollId, ['*']);

            $this->timeOptions = $this->timeOptionService->getPollTimeOptions($this->poll);
            foreach ($this->timeOptions as &$timeOption) {
                $timeOption['content']['full'] = implode(' - ', $timeOption['content']);
            }


            $this->selected['time_option'] = 0;

            $this->questions = $this->questionService->getPollQuestions($this->poll);

            $this->selectedTimeOption = 0;

            foreach ($this->questions as $questionIndex => $question) {
                $this->selected['questions'][$questionIndex] = 0;
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while loading poll.');
            return;
        }


    }

    public function chooseFinalResults()
    {

        $timeOption = $this->timeOptions[$this->selected['time_option']];


        $text = 'Poll description: '.$this->poll->description."\n\n";

        $text .= 'Chosen time option: ' . $timeOption['content']['full'] . "\n\n";

        foreach ($this->questions as $questionIndex => $question) {
            $text .= $question['text'].': ';
            $text .= $question['options'][$this->selected['questions'][$questionIndex]]['text']."\n";
            $text .= "\n";
        }

        $event = [
            'poll_id' => $this->poll->public_id,
            'title' => $this->poll->title,
            'all_day' => false,
            'start_time' => $timeOption['date'] . ' ' . ($timeOption['content']['start'] ?? ''),
            'end_time' => $timeOption['date'] . ' ' . ($timeOption['content']['end'] ?? ''),
            'description' => $text,
        ];

        $this->dispatch('showModal', [
            'alias' => 'modals.poll.create-event',
            'params' => [
                'event' => $event,
            ],

        ]);

    }

    public function render()
    {
        return view('livewire.modals.poll.choose-final-options');
    }
}
