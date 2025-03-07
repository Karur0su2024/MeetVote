<div>
    <div class="modal-header bg-warning">
        <h5 class="modal-title">Create event</h5>
        <button type="button" class="btn-close text-white" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body">

        <form wire:submit.prevent='createEvent()' wire:key='{{ now() }}'>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" wire:model='event.title'>
                @error('event.title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" wire:model='event.date'>
                @error('event.date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" wire:model='event.all_day' id="all_day" />
                    <label class="form-check-label" for="all_day">All day event</label>
                </div>
            </div>


            @if (!$event['all_day'])
                <div class="mb-3">
                    <label for="start" class="form-label">Start</label>
                    <input type="time" class="form-control" id="start" wire:model='event.start'>
                    @error('event.start')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="end" class="form-label">End</label>
                    <input type="time" class="form-control" id="end" wire:model='event.end'>
                    @error('event.end')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" wire:model='event.description' rows="10"></textarea>
                @error('event.description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>


    </div>
</div>
