<div class="col-lg-4 d-flex">
    <div class="card shadow border-0 w-100 h-100">
        <div class="card-header">
            <h3 class="mb-0">Event Details</h3>
        </div>
        <div class="card-body d-flex flex-column h-100">
            @if ($event)
                <p><strong>Title:</strong> {{ $event->title }}</p>

                @if ($syncGoogleCalendar)
                    <p class="text-success"><i class="bi bi-check-circle"></i> <strong>Synced with Google Calendar</strong></p>
                @endif

                <p><strong>Start Time:</strong> {{ Carbon\Carbon::parse($event->start_time)->format('d.m.Y H:i') }}
                </p>
                <p><strong>End Time:</strong> {{ Carbon\Carbon::parse($event->end_time)->format('d.m.Y H:i') }}</p>

                @isset($event->description)
                    <p><pre>{{ $event->description }}</pre></p>
                @endisset
            @else
                <div class="text-center">
                    @if ($poll->status == 'closed')
                        <i class="bi bi-calendar-x text-muted fs-1"></i>
                        <p class="text-muted mt-2">No event was created for this poll yet.</p>
                    @else
                        <i class="bi bi-clock text-muted fs-1"></i>
                        @if ($isAdmin)
                            <p class="text-muted mt-2">Poll is still open. You can create an event only for closed polls.</p>
                        @else
                            <p class="text-muted mt-2">Poll is still open. Event will be created when the poll
                                is closed by owner.
                            </p>
                        @endif

                    @endif
                </div>
            @endif
        </div>



        <div class="card-footer d-grid gap-2">
            @if ($poll->status == 'closed')
                @if ($poll->event)
                    <button wire:click='importToGoogleCalendar' class="btn btn-primary">
                        <i class="bi bi-calendar-plus"></i> Import to Google Calendar
                    </button>
                    @if ($isAdmin)
                        <button wire:click='openEventModal(false)' class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i> Update event
                        </button>
                    @endif
                @else
                    @if ($isAdmin)
                        <button class="btn btn-outline-secondary"
                            onclick="openModal('modals.poll.choose-final-options', '{{ $poll->id }}')">
                            <i class="bi bi-check2-square"></i> Pick from results
                        </button>
                    @endif

                @endif
            @else
                @if ($isAdmin)
                    <button class="btn btn-outline-secondary"
                        onclick="openModal('modals.poll.close-poll', '{{ $poll->public_id }}')">
                        <i class="bi bi-check2-square"></i> Close poll
                    </button>
                @endif

            @endif
        </div>

    </div>
</div>

<script>
    function openModal(alias, index) {
        Livewire.dispatch('showModal', {
            data: {
                alias: alias,
                params: {
                    publicIndex: index
                }
            },
        });
    }
</script>
