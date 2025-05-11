<?php

namespace App\Livewire\Modals\Poll;

use App\Events\PollEventCreated;
use App\Events\PollEventDeleted;
use App\Models\Poll;
use App\Services\EventService;
use App\Services\Google\GoogleService;
use App\Traits\CanOpenModals;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;

// Modální okno pro vytvoření události
class CreateEvent extends Component
{
    public $poll;
    use CanOpenModals;

    protected EventService $eventService;
    protected GoogleService $googleService;

    public bool $update = false;

    public $event;

    protected function rules(): array
    {
        return [
            'event.title' => 'required|string|max:255',
            'event.start_time' => 'required|date',
            'event.end_time' => 'required|date|after:event.start_time',
            'event.description' => 'nullable|string',
        ];
    }


    public function boot(EventService $eventService, GoogleService $googleService): void
    {
        $this->googleService = $googleService;
        $this->eventService = $eventService;
    }

    public function mount($pollIndex, array $eventData = null)
    {
        $this->poll = Poll::with('event')->find($pollIndex, ['*']);

        if($eventData){
            $this->event = $eventData;
            return;
        }

        $this->update = true;
        $this->event = $this->eventService->buildEvent($this->poll->event);


    }

    #[On('loadEvent')]
    public function loadEvent($event)
    {
        $this->event = $event;
    }

    // Metoda pro vytvoření nové události
    public function createEvent()
    {
        if (Gate::denies('createEvent', $this->poll)) {
            return redirect(route('polls.show', $this->poll))->with('error', __('ui.modals.create_event.messages.error.no_permissions'));
        }

        try {
            $validatedData = $this->validate();
            $this->eventService->createEvent($this->poll, $validatedData['event']);
            PollEventCreated::dispatch($this->poll);


        } catch (\Exception $e) {
            return;
            //Doplnit logování chyby
        }

        return redirect()->route('polls.show', $this->poll)->with('success', __('pages/poll-show.messages.success.event_created'));
    }

    public function deleteEvent(){
        PollEventDeleted::dispatch($this->poll);
        $this->poll->event()->delete();
        return redirect()->route('polls.show', $this->poll)->with('success', __('ui/modals.create_event.messages.success.event_deleted'));
    }

    public function render()
    {
        return view('livewire.modals.poll.create-event');
    }
}
