<div>
    <div class="modal-header">
        <h5 class="modal-title">Create event for poll {{ $poll->title }}</h5>
        <button type="button" class="btn-close text-white" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body">

        <p class="text-muted">
            Fill in the details below to create an event and optionally import final options from the poll results.
        </p>
            <div class="mb-3">
                <x-input id="title" model="event.title" type="text" mandatory="true">
                    Event title
                </x-input>
            </div>

            <div class="mb-3">
                <x-input id="start" model="event.start_time" type="datetime-local" label="Start">
                    Start
                </x-input>
            </div>

            <div class="mb-3">
                <x-input id="end" model="event.end_time" type="datetime-local" label="End">
                    End
                </x-input>
            </div>

            <div class="mb-3">
                <x-textbox id="description" model="event.description">
                    Event Description
                </x-textbox>
            </div>



        <div class="d-flex justify-content-center gap-2">
            <button wire:click='openResultsModal()' class="btn btn-outline-secondary w-100">
                <i class="bi bi-download"></i> Import from poll results
            </button>
            <button class="btn btn-outline-danger w-100" wire:click='deleteEvent'>
                <i class="bi bi-calendar-plus"></i> Delete event

            <button wire:click='createEvent' class="btn btn-primary w-100">
                <i class="bi bi-calendar-plus"></i> {{ $update ? 'Update' : 'Create' }}
                event
            </button>
        </div>
    </div>

</div>
