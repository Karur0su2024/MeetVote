<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Event as EventModel;
use App\Models\Poll;
use Livewire\Attributes\On;
use Livewire\Component;

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

    protected $rules = [
        'event.title' => 'required',
        'event.date' => 'required|date|after_or_equal:today',
        'event.all_day' => 'boolean',
        'event.start' => 'required|date_format:H:i',
        'event.end' => 'required|date_format:H:i|after:event.start',
        'event.description' => 'nullable',
    ];

    public function mount($event = null)
    {

        if ($event) {
            $this->event = $event;
        }

    }

    #[On('loadEvent')]
    public function loadEvent($event)
    {
        $this->event = $event;
    }

    // Metoda pro vytvoření nové události
    public function createEvent()
    {

        $validatedData = $this->validate();

        if ($this->poll->event) {
            $this->poll->event->delete();
        }

        $event = EventModel::create([
            'poll_id' => $validatedData['event']['poll_id'],
            'title' => $validatedData['event']['title'],
            'date' => $validatedData['event']['date'],
            'all_day' => $validatedData['event']['all_day'],
            'start' => $validatedData['event']['start'],
            'end' => $validatedData['event']['end'],
            'title' => $validatedData['event']['title'],
            'description' => $validatedData['event']['description'],
        ]);

        $this->poll->event()->save($event);

        // return redirect()->route('polls.show', $this->poll);
    }

    public function render()
    {
        return view('livewire.modals.poll.create-event');
    }
}
