<x-ui.card collapsable>

    {{-- Hlavička --}}
    <x-slot:header>
        {{ __('pages/poll-editor.time_options.title') }}
    </x-slot:header>

    <x-slot:tooltip>
        {{ __('pages/poll-editor.time_options.tooltip') }}
    </x-slot:tooltip>



    <div class="row">
        {{-- Polovina s kalendářem --}}
        <x-layouts.col-6>
            <h3 class="mb-4">{{ __('pages/poll-editor.time_options.calendar.title') }}</h3>
            <div id="js-calendar"
                 class="w-100"
                 x-init="initCalendar()"
                 x-data
                 wire:ignore>
            </div>
            <x-error-alert for="form.dates"/>
        </x-layouts.col-6>

        {{-- Polovina časovými termíny --}}
        <x-layouts.col-6>
            <h3 class="mb-4">{{ __('pages/poll-editor.time_options.calendar.dates') }}</h3>

            <template x-for="(date, dateIndex) in form.dates" :key="dateIndex">
                <x-pages.poll-editor.time-options.date-card />
            </template>

        </x-layouts.col-6>
    </div>
</x-ui.card>
