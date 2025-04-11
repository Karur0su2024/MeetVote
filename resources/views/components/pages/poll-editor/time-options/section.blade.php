<div x-data="TimeOptionsForm" @validation-failed.window="duplicateError($event.detail.errors)">

    {{-- Základní informace o anketě --}}
    <x-ui.card>

        {{-- Hlavička --}}
        <x-slot:header>
            {{ __('pages/poll-editor.time_options.title') }}
        </x-slot:header>

        <x-slot:tooltip>
            {{ __('pages/poll-editor.time_options.tooltip') }}
        </x-slot:tooltip>



        <div class="row">
            <div class="col-lg-5">
                <h3 class="mb-4">{{ __('pages/poll-editor.time_options.calendar.title') }}</h3>
                <div id="js-calendar"
                     class="w-100"
                     x-init="initCalendar()"
                     x-data
                     wire:ignore>
                </div>
                <x-ui.error-alert for="form.dates"/>
            </div>
            <div class="col-lg-7">
                <h3 class="mb-4">{{ __('pages/poll-editor.time_options.calendar.dates') }}</h3>

                <template x-for="(date, dateIndex) in dates" :key="dateIndex">
                    <x-pages.poll-editor.time-options.date-card />
                </template>
            </div>
        </div>
    </x-ui.card>

</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/simple-jscalendar@1.4.4/source/jsCalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="{{ asset('js/alpine/times.js') }}"></script>
@endpush
