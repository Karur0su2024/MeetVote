@push('scripts')
    {{--    https://stackoverflow.com/questions/42169051/bootstrap-css-overriding-fullcalendar-css-even-if-the-fullcalendar-css-is-placed --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.0.2/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="{{ asset('js/alpine/times-v2.js') }}"></script>
@endpush


<div x-data="TimeOptionsForm" @validation-failed.window="duplicateError($event.detail.errors)">

    {{-- Základní informace o anketě --}}
    <x-ui.card header-hidden>
        <x-slot:body-header>
            <h2 class="mb-3 px-3">
                {{ __('pages/poll-editor.time_options.title') }}
                <small>
                    <x-ui.tooltip>
                        {{ __('pages/poll-editor.time_options.tooltip') }}
                    </x-ui.tooltip>
                </small>
            </h2>
        </x-slot:body-header>

        <x-slot:body class="px-sm-0">


                <div class="row g-3">
                    <div class="col-lg-6">
                        <div class="card p-3 shadow-sm">
                            <h3 class="mb-4">{{ __('pages/poll-editor.time_options.calendar.title') }}</h3>
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
                    </div>
                    <div class="col-lg-6">

                        <div class="card p-3 h-100">
                            <h3 class="mb-4">{{ __('pages/poll-editor.time_options.calendar.dates') }}</h3>
                            <template x-for="(date, dateIndex) in dates" :key="dateIndex">
                                <x-pages.poll-editor.time-options.date-card/>
                            </template>
                        </div>
                    </div>
                </div>
        </x-slot:body>
    </x-ui.card>

</div>

