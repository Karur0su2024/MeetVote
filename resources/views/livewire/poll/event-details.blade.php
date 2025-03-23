<div class="col-lg-4 d-flex">
    <x-ui.card header-size="h3" class="w-100 h-100">
        <x-slot:header>
            Event Details
        </x-slot:header>
        <x-slot:header-right>
            @if ($event)
                <x-ui.dropdown.wrapper element="div" size="md">
                    <x-slot:header>
                        import
                    </x-slot:header>
                    <x-slot:dropdown-items>
                        <x-ui.dropdown.item wire:click='importToGoogleCalendar'>
                            <x-ui.icon class="google me-1"/>
                            Import to Google Calendar
                        </x-ui.dropdown.item>
                    </x-slot:dropdown-items>
                </x-ui.dropdown.wrapper>
            @endif
        </x-slot:header-right>
        @if ($event)
            <p><strong>Title:</strong> {{ $event->title }}</p>

            @if ($syncGoogleCalendar)
                <p class="text-success"><i class="bi bi-check-circle"></i> <strong>Synced with Google Calendar</strong>
                </p>
            @endif

            <p><strong>Start Time:</strong> {{ Carbon\Carbon::parse($event->start_time)->format('d.m.Y H:i') }}
            </p>
            <p><strong>End Time:</strong> {{ Carbon\Carbon::parse($event->end_time)->format('d.m.Y H:i') }}</p>

            @isset($event->description)
                <p>
                <pre>{{ $event->description }}</pre></p>
            @endisset
        @else
            <div class="text-center">
                @if (!$poll->isActive())
                    <i class="bi bi-calendar-x text-muted fs-1"></i>
                    <p class="text-muted mt-2">No event was created for this poll yet.</p>
                @else
                    <i class="bi bi-clock text-muted fs-1"></i>
                    @if ($isAdmin)
                        <p class="text-muted mt-2">Poll is still open. You can create an event only for closed
                            polls.</p>
                    @else
                        <p class="text-muted mt-2">Poll is still open. Event will be created when the poll
                            is closed by owner.
                        </p>
                    @endif

                @endif
            </div>
        @endif

        @can('isAdmin', $poll)
            <x-slot:footer>
                @if (!$poll->isActive())
                    @if ($poll->event)
                        <button wire:click='openEventModal(false)' class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i> Update event
                        </button>
                    @else
                        <button class="btn btn-outline-secondary"
                                onclick="openModal('modals.poll.choose-final-options', '{{ $poll->id }}')">
                            <i class="bi bi-check2-square"></i> Pick from results
                        </button>
                    @endif
                @else
                    <button class="btn btn-outline-secondary"
                            onclick="openModal('modals.poll.close-poll', '{{ $poll->id }}')">
                        <i class="bi bi-check2-square"></i> Close poll
                    </button>
                @endif
            </x-slot:footer>
        @endcan
    </x-ui.card>

</div>

<script>
    function openModal(alias, index) {
        Livewire.dispatch('showModal', {
            data: {
                alias: alias,
                params: {
                    pollId: index
                }
            },
        });
    }
</script>
