<?php

namespace App\Livewire\Modals\Poll;

use Livewire\Component;
use App\Models\Poll;
use App\Models\Event as EventModel;
use Livewire\Attributes\On;


class CreateEvent extends Component
{

    public $poll;
    public $event = [
        'poll_id' => '',
        'title' => '',
        'date' => '',
        'all_day' => false,
        'start' => '',
        'end' => '',
        'description' => '',
    ];

    public function mount($event){


        $this->event = $event;
    }

    #[On('loadEvent')]
    public function loadEvent($event){
        $this->event = $event;
    }


    public function createEvent(){

        //$this->dispatch('hideModal');
        
        $validatedData = $this->validate([
            'event.title' => 'required',
            'event.date' => 'required|date|after_or_equal:today',
            'event.all_day' => 'boolean',
            'event.start' => 'required|date_format:H:i',
            'event.end' => 'required|date_format:H:i|after:event.start',
            'event.description' => 'nullable',
        ]);

        //dd($validatedData);

        if($this->poll->event){
            $this->poll->event->delete();
        }

        $event = EventModel::create([
            'poll_id' => $this->poll->id,
            'title' => $this->event['title'],
            'final_datetime' => $this->event['date'],
            'description' => $this->event['description'],
        ]);

        $this->poll->event()->save($event);

        
        
        //return redirect()->route('polls.show', $this->poll);
    }

    public function render()
    {
        return view('livewire.modals.poll.create-event');
    }
}
