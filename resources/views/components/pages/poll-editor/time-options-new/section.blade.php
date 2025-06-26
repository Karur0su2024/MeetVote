@push('scripts')
    {{--    https://stackoverflow.com/questions/42169051/bootstrap-css-overriding-fullcalendar-css-even-if-the-fullcalendar-css-is-placed --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.0.2/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="{{ asset('js/alpine/times-v2.js') }}"></script>
@endpush


<div x-data="TimeOptionsForm" @validation-failed.window="duplicateError($event.detail.errors)">

    <div class="card bg-base-100 shadow-md p-3">
        <h2 class="text-2xl">
            {{ __('pages/poll-editor.time_options.title') }}
            <x-ui.tooltip-new size="md">
                {{ __('pages/poll-editor.time_options.tooltip') }}
            </x-ui.tooltip-new>
        </h2>

        <div class="flex flex-row gap-6">
            <div class="flex-1">
                <h3 class="text-lg">{{ __('pages/poll-editor.time_options.calendar.title') }}</h3>
                <div id="calendar"
                     x-init="initCalendar()"
                     x-data
                     wire:ignore>
                </div>

                <div x-show="messages.errors['calendar']">
                    <x-ui.alert type="danger" icon="bi-exclamation-triangle-fill" class="mt-2 mb-0">
                        <span x-text="messages.errors['calendar']"></span>
                    </x-ui.alert>
                </div>
            </div>

            <div class="card p-3 h-100 flex-1">
                <h3 class="mb-4">{{ __('pages/poll-editor.time_options.calendar.dates') }}</h3>
                <template x-for="(date, dateIndex) in dates" :key="dateIndex">
                    <x-pages.poll-editor.time-options-new.date-card/>
                </template>
            </div>
        </div>

    </div>

</div>

