@props([
    'event',
    'poll',
    '$syncGoogleCalendar = false',
])

<x-ui.tw-card header-size="h3" class="w-100 h-100" footer-flex>
    <x-slot:title>
        {{ __('pages/poll-show.event_details.title') }}
    </x-slot:title>
    <x-slot:header-right>
        @if ($event)
            <div class="tw-dropdown tw-dropdown-end tw-w-full">
                <button class="tw-btn tw-btn-outline tw-btn-sm">
                    {{ __('pages/poll-show.event_details.dropdown.header') }}
                </button>
                <ul class="tw-menu tw-dropdown-content tw-bg-base-200 tw-w-full tw-rounded tw-shadow-sm">
                    <li>
                        <a href="#" wire:click='importToGoogleCalendar()'>
                            {{ __('pages/poll-show.event_details.dropdown.import_to_google') }}
                        </a>
                    </li>
                    <li>
                        <a href="#" wire:click='importToOutlookCalendar()'>
                            {{ __('pages/poll-show.event_details.dropdown.import_to_outlook') }}
                        </a>
                    </li>
                </ul>
            </div>
        @can('isAdmin', $poll)
                <button class="tw-btn tw-btn-sm tw-btn-outline" wire:click="deleteEvent">
                    Delete
                </button>
        @endcan
        @endif
    </x-slot:header-right>

    @if ($event)
        <p><strong>Title:</strong> {{ $event->title }}</p>

        @if ($syncGoogleCalendar ?? false)
            <p class="text-success">
                <x-ui.icon name="calendar-check"/>
                <strong>{{ __('pages/poll-show.event_details.text.synced_with_google') }}</strong>
            </p>
        @endif

        <p>
            <strong>
                {{ __('pages/poll-show.event_details.text.start_time') }}
            </strong>
            {{ Carbon\Carbon::parse($event->start_time)->format('d.m.Y H:i') }}
        </p>
        <p>
            <strong>{{ __('pages/poll-show.event_details.text.end_time') }}</strong>
            {{ Carbon\Carbon::parse($event->end_time)->format('d.m.Y H:i') }}
        </p>

        @if($event->description)
            <pre>{{ $event->description }}</pre>
        @endif
    @else
        <div class="text-center">
            @if (!$poll->isActive())
                <i class="bi bi-calendar-x text-muted fs-1 mb-2"></i>
                <p class="text-muted mt-2">
                    {{ __('pages/poll-show.event_details.text.no_event_created_yet') }}
                </p>
            @else
                <i class="bi bi-clock text-muted fs-1 mb-2"></i>
                <p class="text-muted mt-2">{{ __('pages/poll-show.event_details.text.poll_still_open') }}
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
        <x-slot:footer>
            @if (!$poll->isActive())
                @if ($poll->event)
                    <button wire:click="openModal('modals.poll.create-event', {{ $poll->id }})" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> {{ __('pages/poll-show.event_details.buttons.update_event') }}
                    </button>
                @else
                    <button class="btn btn-outline-secondary"
                            wire:click="openModal('modals.poll.choose-final-options', '{{ $poll->id }}')">
                        <i class="bi bi-check2-square"></i> {{ __('pages/poll-show.event_details.buttons.pick_from_results') }}
                    </button>
                    <button class="btn btn-outline-primary"
                            wire:click="createEvent">
                        <i class="bi bi-check2-square"></i> {{ __('pages/poll-show.event_details.buttons.automatically_create_event') }}
                    </button>
                @endif
            @else
                <button class="btn btn-outline-secondary"
                        wire:click="openModal('modals.poll.close-poll', '{{ $poll->id }}')">
                    <i class="bi bi-check2-square"></i> {{ __('pages/poll-show.event_details.buttons.close_poll') }}
                </button>
            @endif
        </x-slot:footer>
    @endcan



</x-ui.tw-card>
