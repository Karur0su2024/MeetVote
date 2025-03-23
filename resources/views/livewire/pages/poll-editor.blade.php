<div>
    <form wire:submit.prevent="submit"
          x-data="getFormData"
          @validation-failed.window="duplicateError($event.detail.errors)"
    >

        {{-- Základní informace o anketě --}}
        <x-pages.poll-editor.basic-info-section :poll="$poll"/>

        {{-- Výběr časových termínů --}}
        <x-pages.poll-editor.time-options.section/>

        <div class="row">
            {{-- Výběr doplňujících otázek --}}
            <x-layouts.col-6>
                <x-pages.poll-editor.questions.section/>
            </x-layouts.col-6>
            {{-- Nastavení ankety --}}
            <x-layouts.col-6>
                <x-pages.poll-editor.settings-section/>
            </x-layouts.col-6>
        </div>

        <x-error-alert for="error"/>
        <x-ui.button type="submit" size="lg" class="w-50 mx-auto">
            {{ __('form.button.submit') }}
        </x-ui.button>


    </form>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/simple-jscalendar@1.4.4/source/jsCalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="{{ asset('js/alpine/form.js') }}"></script>
@endpush
