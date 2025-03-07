<?php

namespace App\Livewire\Modals\Poll;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Poll;

class ChooseFinalOptions extends Component
{
    public $poll;
    public $timeOptions = [];
    public $questions = [];
    public $selectedTimeOption;
    public $selectedQuestionOptions = [];

    public function mount($publicIndex)
    {
        $this->poll = Poll::where('public_id', $publicIndex)->first();

        foreach($this->poll->timeOptions as $timeOption) {
            $points = 0;
            foreach($timeOption->votes as $vote) {
                $points += $vote->preference;
            }

            $start = $timeOption->start ? Carbon::parse($timeOption->start)->format('H:i') : null;
            $end = $timeOption->start ? Carbon::parse($timeOption->start)->addMinutes($timeOption->minutes)->format('H:i') : null;
            $text = $timeOption->text ?? null;


            $this->timeOptions[] = [
                'id' => $timeOption->id,
                'date' => $timeOption->date,
                'start' => $start,
                'end' => $end,
                'text' => $text,
                'votes' => $points
            ];
        }

        foreach($this->poll->questions as $question) {
            $options = [];
            foreach($question->options as $option) {
                $options[] = [
                    'text' => $option->text,
                    'votes' => $option->votes->count()
                ];


                usort($options, function($a, $b) {
                    return $b['votes'] <=> $a['votes'];
                });
            }

            $this->questions[] = [
                'text' => $question->text,
                'options' => $options
            ];
        }

        // Seřazení časových možností podle počtu hlasů
        usort($this->timeOptions, function($a, $b) {
            return $b['votes'] <=> $a['votes'];
        });


        $this->selectedTimeOption = 0;

        foreach($this->questions as $questionIndex => $question) {
            $this->selectedQuestionOptions[$questionIndex] = "0";
        }

        //dd($this->selectedQuestionOptions);


    }

    public function chooseFinalResults(){
        //dd($this->selectedTimeOption);
        $timeOption = $this->timeOptions[$this->selectedTimeOption];

        $text = "Poll description: " . $this->poll->description . "\n";

        $text .= $timeOption['text'] . "\n";

        foreach($this->questions as $questionIndex => $question) {
            $text .= $question['text'] . ': ';
            $text .= $question['options'][$this->selectedQuestionOptions[$questionIndex]]['text'] . "\n";
            $text .= "\n";
        }

        $event = [
            'poll_id' => $this->poll->id,
            'title' => $this->poll->title,
            'date' => $timeOption['date'],
            'all_day' => false,
            'start' =>  $timeOption['start'],
            'end' => $timeOption['end'],
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
