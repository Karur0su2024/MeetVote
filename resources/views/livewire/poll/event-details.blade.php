<div class="col-lg-4 d-flex">
    <div class="card shadow-sm text-start mb-5 w-100 h-100 border-0">
        <div class="card-body d-flex flex-column h-100">
            <h3>Event Details</h3>

            @if ($event)
                <p><strong>Title:</strong> {{ $event->title }}</p>
                @if ($syncGoogleCalendar)
                    <p><strong>Synced</strong></p>

                @else
                    <p><strong>Not synced</strong></p>
                @endif

                @if ($event->all_day)
                    <p><strong>Duration:</strong> All day event</p>
                @else
                    <p><strong>Start Time:</strong> {{ Carbon\Carbon::parse($event->start_time)->format('d.m.Y H:i') }}</p>
                    <p><strong>End Time:</strong> {{ Carbon\Carbon::parse($event->end_time)->format('d.m.Y H:i') }}</p>
                @endif

                @isset($event->description)
                    <p><strong>Description:</strong> {{ $event->description }}</p>
                @endisset

            @else
                <p class="text-muted">No event created for this poll.</p>

                {{-- Pokud je anketa uzavřena, zobraz tlačítka pro vytvoření události --}}
                @if ($poll->status == 'closed')
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" onclick="openModal('modals.poll.create-event', '{{ $poll->id }}')">
                            <i class="bi bi-calendar-event"></i> Create event
                        </button>
                        <button class="btn btn-primary" onclick="openModal('modals.poll.choose-final-options', '{{ $poll->id }}')">
                            <i class="bi bi-check2-square"></i> Final options
                        </button>
                    </div>
                @endif
            @endif
        </div>


        @if ($event)
            <div class="card-footer bg-white border-0 d-flex flex-column gap-2">
                <button wire:click='importToGoogleCalendar' class="btn btn-primary w-100">
                    <i class="bi bi-calendar-plus"></i> Import to Google Calendar
                </button>
                <button wire:click='openEventModal(false)' class="btn btn-primary w-100">
                    <i class="bi bi-calendar-plus"></i> Update event
                </button>
            </div>
        @endif
    </div>
</div>

<script>
    function openModal(alias, index) {
        console.log(index);
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
