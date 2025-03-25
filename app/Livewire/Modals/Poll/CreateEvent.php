<?php

namespace App\Livewire\Modals\Poll;

use App\Models\Event as EventModel;
use App\Models\Poll;
use App\Services\GoogleService;
use App\Traits\Traits\CanOpenModals;
use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Services\EventService;

class CreateEvent extends Component
{
    public $poll;
    use CanOpenModals;

    protected EventService $eventService;
    protected GoogleService $googleService;

    public bool $update = false;

    public $event = [
        'poll_id' => '',
        'title' => '',
        'all_day' => false,
        'start_time' => '',
        'end_time' => '',
        'description' => '',
    ];

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


    public function boot(EventService $eventService)
    {
        $this->eventService = $eventService;
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
        if (Gate::allows('createEvent', $this->poll)) {
            return $this->redirect(route('polls.show', $this->poll))->with('error', __('ui.modals.create_event.messages.error.no_permissions'));
        }

        try {
            $validatedData = $this->validate();
            $response = $this->eventService->createEvent($this->poll, $validatedData['event']);

            $this->googleService->googleCalendarService->synchronizeGoogleCalendar($this->poll->votes()->with('user')->get()->pluck('user')->unique()->filter(), $this->poll->event);

            return redirect()->route('polls.show', $this->poll)->with('success', $response);
        } catch (\Exception $e) {
            dd($e->getMessage());
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
