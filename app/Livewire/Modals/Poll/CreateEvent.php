<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Poll;
use App\Services\EventService;
use App\Services\Google\GoogleService;
use App\Traits\CanOpenModals;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;

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
            'event.all_day' => 'boolean',
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

    public function mount($pollIndex, $eventData = null)
    {
        $this->poll = Poll::find($pollIndex, ['*']);


        if ($this->event) {
            if ($this->poll->event()->exists()) {
                $this->update = true;
                $this->event = $this->eventService->buildEvent($event->toArray());
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
        if (Gate::allows('createEvent', $this->poll)) {
            return $this->redirect(route('polls.show', $this->poll))->with('error', __('ui.modals.create_event.messages.error.no_permissions'));
        }

        try {
            $validatedData = $this->validate();
            $event = $this->eventService->createEvent($this->poll, $validatedData['event']);
            $users = $this->poll->votes()->with('user')->get()->pluck('user')->unique()->filter();

            $this->googleService->syncWithGoogleCalendar($users, $event);

            return redirect()->route('polls.show', $this->poll)->with('success', 'Test');
        } catch (\Exception $e) {
            //Doplnit logování chyby
        }

    }

    public function deleteEvent(){
        $this->poll->event()->delete();
        return redirect()->route('polls.show', $this->poll)->with('success', __('ui/modals.create_event.messages.success.event_deleted'));
    }

    public function render()
    {
        return view('livewire.modals.poll.create-event');
    }
}
