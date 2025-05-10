{{-- Modální okno pro vytvoření události --}}
<div>
    <x-ui.modal.header>
        {{ __('ui/modals.create_event.title', ['poll_title' => $poll->title]) }}
    </x-ui.modal.header>
    <div class="modal-body">
        <p class="text-muted">
            {{ __('ui/modals.create_event.description') }}
        </p>
        <div class="mb-3">
            <x-ui.form.input id="title"
                             wire:model="event.title"
                             required
                             placeholder="{{ __('ui/modals.create_event.event_title.placeholder') }}"
                             error="event.title">
                {{ __('ui/modals.create_event.event_title.label') }}
            </x-ui.form.input>
        </div>

        <div class="mb-3">
            <x-ui.form.input id="start"
                             wire:model="event.start_time"
                             type="datetime-local"
                             required
                             placeholder="{{ __('ui/modals.create_event.start_time.placeholder') }}"
                             error="event.start_time">
                {{ __('ui/modals.create_event.start_time.label') }}
            </x-ui.form.input>
        </div>

        <div class="mb-3">
            <x-ui.form.input id="end"
                             wire:model="event.end_time"
                             type="datetime-local"
                             required
                             placeholder="{{ __('ui/modals.create_event.end_time.placeholder') }}"
                             error="event.end_time">
                {{ __('ui/modals.create_event.end_time.label') }}
            </x-ui.form.input>
        </div>

        <div class="mb-3">
            <x-ui.form.textbox id="description"
                               wire:model="event.description"
                               placeholder="{{ __('ui/modals.create_event.event_description.placeholder') }}"
                               error="event.description">
                {{ __('ui/modals.create_event.event_description.label') }}
            </x-ui.form.textbox>
        </div>
    </div>
    <x-ui.modal.footer>
        @if($update)
            <x-ui.button wire:click="deleteEvent()"
                         color="outline-danger"
                         class="mx-auto w-100">
                <x-ui.icon class="trash"/>
                {{ __('ui/modals.create_event.buttons.delete_event') }}
            </x-ui.button>
        @endif
        <x-ui.button wire:click="createEvent()"
                     color="outline-primary"
                     class="mx-auto w-100">
            <x-ui.icon class="calendar-plus"/>
            {{ $update ? __('ui/modals.create_event.buttons.update_event') :
                         __('ui/modals.create_event.buttons.create_event') }}
        </x-ui.button>
    </x-ui.modal.footer>
</div>
