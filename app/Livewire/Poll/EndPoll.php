<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use Carbon\Carbon;

class EndPoll extends Component
{

    public $poll;
    public $timeOptions = [];
    public $selectedTimeOption;

    public function mount($poll)
    {
        $this->poll = $poll;

        foreach($poll->timeOptions as $timeOption) {
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


        $this->selectedTimeOption = 0;
    }

    public function chooseFinalResults(){
        //dd($this->selectedTimeOption);
        $timeOption = $this->timeOptions[$this->selectedTimeOption];

        $text = "";

        $text .= $timeOption['text'] . "\n";

        $event = [
            'title' => $this->poll->title,
            'date' => $timeOption['date'],
            'all_day' => false,
            'start' =>  $timeOption['start'],
            'end' => $timeOption['end'],
            'description' => $this->poll->description,
        ];

        $this->dispatch('loadEvent', $event);
    }

    public function render()
    {
        return view('livewire.poll.end-poll');
    }
}
