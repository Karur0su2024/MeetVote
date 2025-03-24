<div>
    <form wire:submit.prevent="submit"
          x-data="getFormData"
          @validation-failed.window="duplicateError($event.detail.errors)">

        {{-- Základní informace o anketě --}}
        <x-pages.poll-editor.basic-info-section :poll-index="$pollIndex"/>

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
        <div class="mb-3">
            <x-ui.saving wire:loading wire:target="submit">
                {{ __('pages/poll-editor.loading') }}
            </x-ui.saving>
        </div>
        <x-ui.button type="submit" size="lg" class="w-50 mx-auto">
            {{ __('pages/poll-editor.button.submit') }}
        </x-ui.button>


    </form>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/simple-jscalendar@1.4.4/source/jsCalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="{{ asset('js/alpine/form.js') }}"></script>
@endpush
