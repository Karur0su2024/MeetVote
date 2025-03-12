<div class="col-lg-4 d-flex">
    <div class="card shadow-sm border-0 w-100 h-100">
        <div class="card-header bg-secondary text-white">
            <h3 class="mb-0">Event Details</h3>
        </div>
        <div class="card-body d-flex flex-column h-100">
            @if ($event)
                <p><strong>Title:</strong> {{ $event->title }}</p>

                @if ($syncGoogleCalendar)
                    <p class="text-success"><i class="bi bi-check-circle"></i> <strong>Synced</strong></p>
                @else
                    <p class="text-danger"><i class="bi bi-x-circle"></i> <strong>Not synced</strong></p>
                @endif

                @if ($event->all_day)
                    <p><strong>Duration:</strong> All day event</p>
                @else
                    <p><strong>Start Time:</strong> {{ Carbon\Carbon::parse($event->start_time)->format('d.m.Y H:i') }}
                    </p>
                    <p><strong>End Time:</strong> {{ Carbon\Carbon::parse($event->end_time)->format('d.m.Y H:i') }}</p>
                @endif

                @isset($event->description)
                    <p><strong>Description:</strong> {{ $event->description }}</p>
                @endisset
            @else
                <div class="text-center">
                    @if ($poll->status == 'closed')
                        <i class="bi bi-calendar-x text-muted fs-1"></i>
                        <p class="text-muted mt-2">No event created for this poll.</p>
                    @else
                        <i class="bi bi-clock text-muted fs-1"></i>
                        <p class="text-muted mt-2">Poll is still open. You can create an event only for closed polls.
                        </p>
                    @endif
                </div>
            @endif
        </div>



        <div class="card-footer bg-light d-grid gap-2">
            @if ($poll->status == 'closed')
                @if ($poll->event)
                    <button wire:click='importToGoogleCalendar' class="btn btn-primary">
                        <i class="bi bi-calendar-plus"></i> Import to Google Calendar
                    </button>
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
