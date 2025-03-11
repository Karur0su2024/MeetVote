<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Event as EventModel;
use App\Models\Poll;
use Illuminate\Container\Attributes\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Services\EventService;

class CreateEvent extends Component
{
    public $poll;

    protected EventService $eventService;

    public bool $update = false;

    public $event = [
        'poll_id' => '',
        'title' => '',
        'all_day' => false,
        'start_time' => '',
        'end_time' => '',
        'description' => '',
    ];

    protected $rules = [
        'event.title' => 'required|string|max:255',
        'event.all_day' => 'boolean',
        'event.start_time' => 'required|date',
        'event.end_time' => 'required|date|after:event.start_time',
        'event.description' => 'nullable|string',
    ];

    public function __construct()
    {
        $this->eventService = app(EventService::class);
    }


    public function mount($event = null)
    {

        if ($event) {
            $this->event = $event;
            $this->poll = Poll::where('public_id', $event['poll_id'])->first();
            if ($this->poll->event()->exists()) {
                $this->update = true;
            }
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

        try {
            $validatedData = $this->validate();

            $this->poll->event()->delete();

            $this->poll->event()->create($validatedData['event']);

            session()->flash('event', 'Událost byla úspěšně vytvořena.');

            $this->eventService->synchronizeGoogleCalendar($this->poll->votes()->with('user')->get()->pluck('user')->unique(), $this->event);

            return redirect()->route('polls.show', $this->poll);
        }
        catch (\Exception $e) {
            dd($e->getMessage());
        }




    }


    public function openResultsModal(){
        $this->dispatch('showModal', [
            'alias' => 'modals.poll.choose-final-options',
            'params' => [
                'publicIndex' => $this->poll->id,
            ],

        ]);
    }


    public function render()
    {
        return view('livewire.modals.poll.create-event');
    }
}
