<?php

use App\Events\PollEventCreated;
use App\Services\EventService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Spatie\CalendarLinks\Link;

new class extends Component
{
    public $event;

    public $poll;

    public $syncGoogleCalendar = false;

    protected EventService $eventService;

    public function mount($poll, $event)
    {
        $this->poll = $poll;
        $this->event = $event;

        if ($this->poll && $this->event) {
            $this->event = $this->poll->event()->first();
            if (Auth::check() && $this->event) {
                $this->syncGoogleCalendar = $this->poll->event->syncedEvents->where('user_id', Auth::user()->id)->isNotEmpty();
            }
        }
    }

    public function boot(EventService $eventService): void
    {
        $this->eventService = $eventService;
    }

    // https://github.com/spatie/calendar-links
    // Import do Google kalendáře
    public function importToGoogleCalendar()
    {
        $link = $this->buildLink();
        return redirect()->away($link->google());
    }

    // Import do kalendáře Outlook
    public function importToOutlookCalendar()
    {
        $link = $this->buildLink();
        return redirect()->away($link->webOutlook());
    }

    // Sestavení odkazu pro import do kalendáře
    private function buildLink()
    {
        $from = DateTime::createFromFormat('Y-m-d H:i:s', $this->event['start_time']);
        $to = DateTime::createFromFormat('Y-m-d H:i:s', $this->event['end_time']);

        return Link::create($this->event['title'], $from, $to)->description($this->event['description']);
    }

    public function createEvent()
    {
        if (Gate::denies('createEvent', $this->poll)) {
            return null;
        }

        $results = $this->pollResultsService->getResults($this->poll);
        $event = $this->eventService->buildEventArrayFromValidatedData($this->poll, $results);
        $this->eventService->createEvent($this->poll, $event);
        PollEventCreated::dispatch($this->poll);

        return redirect()->route('polls.show', $this->poll)->with('success', __('ui/modals.create_event.messages.success.event_created'));

    }

    public function deleteEvent()
    {
        $this->eventService->deleteEvent($this->poll);

        return redirect()->route('polls.show', $this->poll)->with('success', __('ui/modals.create_event.messages.success.event_deleted'));
    }
};
?>


@props([
    'event',
    'poll',
    '$syncGoogleCalendar = false',
])


<x-ui.card>
    <div class="flex flex-col gap-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex items-start gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <x-mary-icon name="o-calendar" class="text-xl" />
                </div>

                <div>
                    <h4 class="text-lg font-semibold">
                        {{ __('pages/poll-show.event_details.title') }}
                    </h4>

                    @if ($event)
                        <p class="text-sm text-base-content/60">
                            {{ Carbon\Carbon::parse($event->start_time)->format('d.m.Y') }}
                        </p>
                    @else
                        <p class="text-sm text-base-content/60">
                            {{ __('pages/poll-show.event_details.text.no_event_created_yet') }}
                        </p>
                    @endif
                </div>
            </div>

            @if ($event)
                <div class="flex flex-wrap items-center gap-2 sm:justify-end">
                    <div class="dropdown dropdown-end">
                        <button class="btn btn-outline btn-sm">
                            <i class="bi bi-download"></i>
                            {{ __('pages/poll-show.event_details.dropdown.header') }}
                        </button>

                        <ul class="menu dropdown-content z-10 mt-2 w-56 rounded-box bg-base-100 p-2 shadow-lg ring-1 ring-base-300">
                            <li>
                                <a href="#" wire:click="importToGoogleCalendar()">
                                    <i class="bi bi-google"></i>
                                    {{ __('pages/poll-show.event_details.dropdown.import_to_google') }}
                                </a>
                            </li>
                            <li>
                                <a href="#" wire:click="importToOutlookCalendar()">
                                    <i class="bi bi-microsoft"></i>
                                    {{ __('pages/poll-show.event_details.dropdown.import_to_outlook') }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    @can('isAdmin', $poll)
                        <button class="btn btn-outline btn-error btn-sm" wire:click="deleteEvent">
                            <i class="bi bi-trash"></i>
                            Delete
                        </button>
                    @endcan
                </div>
            @endif
        </div>

        @if ($event)
            <div class="rounded-2xl border border-base-300 bg-base-100 p-4">
                <div class="mb-4">
                    <p class="text-sm font-medium text-base-content/60">
                        Title
                    </p>
                    <p class="text-lg font-semibold">
                        {{ $event->title }}
                    </p>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <div class="flex items-start gap-3 rounded-xl bg-base-200 p-3">

                        <div>
                            <p class="text-xs uppercase tracking-wide text-base-content/50">
                                {{ __('pages/poll-show.event_details.text.start_time') }}
                            </p>
                            <p class="font-medium">
                                {{ Carbon\Carbon::parse($event->start_time)->format('d.m.Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 rounded-xl bg-base-200 p-3">

                        <div>
                            <p class="text-xs uppercase tracking-wide text-base-content/50">
                                {{ __('pages/poll-show.event_details.text.end_time') }}
                            </p>
                            <p class="font-medium">
                                {{ Carbon\Carbon::parse($event->end_time)->format('d.m.Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                @if ($event->description)
                    <div class="mt-4 rounded-xl bg-base-200 p-4">
                        <p class="mb-2 text-xs uppercase tracking-wide text-base-content/50">
                            Description
                        </p>
                        <div class="text-sm leading-relaxed text-base-content/80">
                            {{ $event->description }}
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-base-300 bg-base-100 px-6 py-10 text-center">
                @if (!$poll->isActive())
                    <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-base-200 text-base-content/50">
                        <i class="bi bi-calendar-x text-2xl"></i>
                    </div>

                    <p class="font-medium">
                        {{ __('pages/poll-show.event_details.text.no_event_created_yet') }}
                    </p>
                @else
                    <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-base-200 text-base-content/50">
                        <i class="bi bi-clock text-2xl"></i>
                    </div>

                    <p class="font-medium">
                        {{ __('pages/poll-show.event_details.text.poll_still_open') }}
                    </p>

                    <p class="mt-1 text-sm text-base-content/60">
                        @can('is-admin', $poll)
                            {{ __('pages/poll-show.event_details.text.admin_can_create_event') }}
                        @else
                            {{ __('pages/poll-show.event_details.text.event_will_be_created') }}
                        @endcan
                    </p>
                @endif
            </div>
        @endif

        @can('isAdmin', $poll)
            <div class="flex flex-wrap gap-2 border-t border-base-300 pt-4">
                @if (!$poll->isActive())
                    @if ($poll->event)
                        <button wire:click="openModal('modals.poll.create-event', {{ $poll->id }})" class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i>
                            {{ __('pages/poll-show.event_details.buttons.update_event') }}
                        </button>
                    @else
                        <button class="btn btn-outline"
                                wire:click="openModal('modals.poll.choose-final-options', '{{ $poll->id }}')">
                            <i class="bi bi-check2-square"></i>
                            {{ __('pages/poll-show.event_details.buttons.pick_from_results') }}
                        </button>

                        <button class="btn btn-primary"
                                wire:click="createEvent">
                            <i class="bi bi-magic"></i>
                            {{ __('pages/poll-show.event_details.buttons.automatically_create_event') }}
                        </button>
                    @endif
                @else
                    <button class="btn btn-outline"
                            wire:click="openModal('modals.poll.close-poll', '{{ $poll->id }}')">
                        <i class="bi bi-lock"></i>
                        {{ __('pages/poll-show.event_details.buttons.close_poll') }}
                    </button>
                @endif
            </div>
        @endcan
    </div>
</x-ui.card>

