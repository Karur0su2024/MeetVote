@push('scripts')
    {{--    https://stackoverflow.com/questions/42169051/bootstrap-css-overriding-fullcalendar-css-even-if-the-fullcalendar-css-is-placed --}}
    <script src="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro@3.1.0/index.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/vanilla-calendar-pro@3.1.0/styles/index.min.css" rel="stylesheet">

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.0.2/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="{{ asset('js/alpine/times-v2.js') }}"></script>
@endpush


<x-ui.card x-data="TimeOptionsForm" @validation-failed.window="duplicateError($event.detail.errors)">
    <x-ui.text.title-lg>
        {{ __('pages/poll-editor.time_options.title') }}
        <div class="tooltip" data-tip="{{ __('pages/poll-editor.time_options.tooltip') }}">
            <x-mary-icon name="s-question-mark-circle" class="w-4 h-4"/>
        </div>
    </x-ui.text.title-lg>


    {{-- Blok s kalendářem --}}
    <div class="card bg-base-200 p-2 border border-gray-100 shadow-sm" x-data="{ myDate: null}">

            <x-mary-datetime x-model="myDate">
                <x-slot:append>
                    <x-mary-button label="Add date" @click="addDate(myDate)" class="btn-primary join-item "/>
                </x-slot:append>
            </x-mary-datetime>
            <div x-show="messages.errors['calendar']">
                <x-ui.alert type="danger" icon="bi-exclamation-triangle-fill" class="mt-2 mb-0">
                    <span x-text="messages.errors['calendar']"></span>
                </x-ui.alert>
            </div>

    </div>
    {{-- Blok s časovými možnostmi --}}
    <template x-for="(date, dateIndex) in dates" :key="dateIndex">
        <x-pages.poll-editor.time-options.date-card/>
    </template>


</x-ui.card>
