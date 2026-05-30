<?php

use Livewire\Component;
use App\Events\PollEventCreated;
use App\Events\PollEventDeleted;
use App\Models\Poll;
use App\Services\EventService;
use App\Services\Google\GoogleService;
use App\Traits\CanOpenModals;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;

new class extends Component {
    public $poll;

    use CanOpenModals;

    public $showModal = false;

    protected EventService $eventService;

    public $listeners = [
        'openCreateEventModal' => 'openModal'
    ];

//    protected GoogleService $googleService;

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

//    public function boot(EventService $eventService, GoogleService $googleService): void
//    {
//        $this->googleService = $googleService;
//        $this->eventService = $eventService;
//    }


    public function boot(EventService $eventService): void
    {
        $this->eventService = $eventService;
    }

    public function openModal($payload)
    {
        $pollId = $payload['pollId'] ?? null;
        $eventData = $payload['eventData'] ?? null;

        $this->poll = Poll::with('event')->find($pollId, ['*']);

//        if ($eventData) {
//            $this->event = $eventData;
//
//            return;
//        }


        $this->update = true;
        $this->event = $this->eventService->buildEvent($eventData);

        //dd($this->event);
        $this->showModal = true;


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
            // Doplnit logování chyby
        }

        return redirect()->route('polls.show', $this->poll)->with('success', __('pages/poll-show.messages.success.event_created'));
    }

    public function deleteEvent()
    {
        PollEventDeleted::dispatch($this->poll);
        $this->poll->event()->delete();

        return redirect()->route('polls.show', $this->poll)->with('success', __('ui/modals.create_event.messages.success.event_deleted'));
    }
};
?>

<x-mary-modal wire:model="showModal"
              class="backdrop-blur z-10">
    @if($this->poll !== null)
        <x-slot:title>
            {{ __('ui/modals.create_event.title', ['poll_title' => $poll->title]) }}
        </x-slot:title>
        <p class="text-gray-500">
            {{ __('ui/modals.create_event.description') }}
        </p>
        <div class="text-base-content flex flex-col gap-3">
            <x-mary-input label="{{ __('ui/modals.create_event.event_title.label') }}"
                          wire:model="event.title"
                          required
                          placeholder="{{ __('ui/modals.create_event.event_title.placeholder') }}"/>

            <x-mary-datetime label="{{ __('ui/modals.create_event.start_time.label') }}"
                             wire:model="event.start_time"
                             required
                             placeholder="{{ __('ui/modals.create_event.start_time.placeholder') }}"
                             type="datetime-local"/>

            <x-mary-datetime label="{{ __('ui/modals.create_event.end_time.label') }}"
                             wire:model="event.end_time"
                             required
                             placeholder="{{ __('ui/modals.create_event.end_time.placeholder') }}"
                             type="datetime-local"/>

            <x-mary-textarea label="{{ __('ui/modals.create_event.event_description.label') }}"
                             wire:model="event.description"
                             placeholder="{{ __('ui/modals.create_event.event_description.placeholder') }}"/>
        </div>

        <x-slot:actions>
            <x-mary-button label="{{ __('ui/modals.close_poll.buttons.cancel') }}"
                           class="btn-neutral"
                           @click="$wire.showModal = false"
            />
            <x-mary-button
                label="{{ $poll->isActive() ? __('ui/modals.close_poll.buttons.close') : __('ui/modals.close_poll.buttons.reopen') }}"
                class="btn btn-primary"
                wire:click="createEvent()">
                <x-slot:label>
                    {{ $update ? __('ui/modals.create_event.buttons.update_event') :
                         __('ui/modals.create_event.buttons.create_event') }}
                </x-slot:label>
            </x-mary-button>

            {{--@if($update)
                <x-ui.tw-button wire:click="deleteEvent()"
                                color="outline-danger"
                                class="mx-auto w-100">
                    <x-ui.icon class="trash"/>
                    {{ __('ui/modals.create_event.buttons.delete_event') }}
                </x-ui.tw-button>
            @endif--}}
        </x-slot:actions>
    @endif
</x-mary-modal>
