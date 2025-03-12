<?php

namespace App\Livewire\Modals\Poll;

use Livewire\Component;
use App\Models\Poll;
use App\Services\EventService;

class ClosePoll extends Component
{

    public $poll;
    protected EventService $eventService;

    public function __construct()
    {
        $this->eventService = app(EventService::class);
    }

    public function mount($publicIndex)
    {
        $this->poll = Poll::find($publicIndex);
    }


    public function render()
    {
        return view('livewire.modals.poll.close-poll');
    }


    public function closePoll()
    {

        if($this->poll->status === 'active') {
            $this->poll->update(['status' => 'closed']);
        }
        else {
            $this->poll->update(['status' => 'active']);
            if($this->poll->event()->exists()) {
                $this->eventService->deleteEvent($this->poll->event);
            }
        }


        return redirect()->route('polls.show', ['poll' => $this->poll->public_id]); // Přesměrování na seznam anket

    }
}
