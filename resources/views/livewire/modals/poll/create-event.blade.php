<div>
    <div class="modal-header bg-warning">
        <h5 class="modal-title">Create event</h5>
        <button type="button" class="btn-close text-white" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body">

        <form wire:submit.prevent='createEvent()' wire:key='{{ now() }}'>

            <x-input id="title" model="event.title" type="text" label="Title" />
            <x-input id="date" model="event.date" type="date" label="Date of event" />
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" wire:model='event.all_day' id="all_day" />
                    <label class="form-check-label" for="all_day">All day event</label>
                </div>
            </div>


            @if (!$event['all_day'])
                <x-input id="end" model="event.end" type="time" label="End" />
                <x-input id="start" model="event.start" type="time" label="Start" />
            @endif

            <x-textbox id="location" model="event.description" label="Description" />

            <button type="submit" class="btn btn-primary">Create</button>
        </form>


    </div>
</div>
