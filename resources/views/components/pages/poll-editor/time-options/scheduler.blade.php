@push('scripts')
    {{--    https://stackoverflow.com/questions/42169051/bootstrap-css-overriding-fullcalendar-css-even-if-the-fullcalendar-css-is-placed --}}
    <script src="https://uicdn.toast.com/tui.code-snippet/v1.5.2/tui-code-snippet.min.js"></script>
    <script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js"></script>
    <script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js"></script>
    <script src="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js"></script>


    <script src="{{ asset('js/alpine/times-v2.js') }}"></script>
@endpush


<div x-data="TimeOptionsForm" @validation-failed.window="duplicateError($event.detail.errors)">


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

        </x-slot:body>
    </x-ui.card>

</div>

