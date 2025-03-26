@props([
    'event',
    'poll',
    '$syncGoogleCalendar = false',
])

<x-ui.card header-size="h3" class="w-100 h-100">
    <x-slot:header>
        {{ __('pages/poll-show.event_details.title') }}
    </x-slot:header>
    <x-slot:header-right>
        @if ($event)
            <x-ui.dropdown.wrapper element="div" size="md">
                <x-slot:header>
                    {{ __('pages/poll-show.event_details.dropdown.header') }}
                </x-slot:header>
                <x-slot:dropdown-items>
                    <x-ui.dropdown.item wire:click='importToGoogleCalendar()'>
                        {{ __('pages/poll-show.event_details.dropdown.import_to_google') }}
                    </x-ui.dropdown.item>
                    <x-ui.dropdown.item wire:click='importToOutlookCalendar()'>
                        {{ __('pages/poll-show.event_details.dropdown.import_to_outlook') }}
                    </x-ui.dropdown.item>
                </x-slot:dropdown-items>
            </x-ui.dropdown.wrapper>
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

        @isset($event->description)
            <pre>{{ $event->description }}</pre>
        @endisset
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
                @endif
            @else
                <button class="btn btn-outline-secondary"
                        wire:click="openModal('modals.poll.close-poll', '{{ $poll->id }}')">
                    <i class="bi bi-check2-square"></i> {{ __('pages/poll-show.event_details.buttons.close_poll') }}
                </button>
            @endif
        </x-slot:footer>
    @endcan
</x-ui.card>
