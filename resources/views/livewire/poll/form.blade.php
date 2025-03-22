<div>
    <form wire:submit.prevent="submit"
          x-data="getFormData"
          @validation-failed.window="duplicateError($event.detail.errors)"
    >

        {{-- Základní informace o anketě --}}
        <x-poll.form.basic-info-section :poll="$poll"/>

        {{-- Výběr časových termínů --}}
        <x-poll.form.title-option-section/>

        <div class="row">
            <x-layout.col-6>
                {{-- Výběr doplňujících otázek --}}
                <x-poll.form.questions-section/>
            </x-layout.col-6>
            <x-layout.col-6>
                {{-- Nastavení ankety --}}
                <x-poll.form.settings-section/>
            </x-layout.col-6>
        </div>


        <x-error-alert for="error"/>
        <button type="submit" class="btn btn-primary btn-lg w-75 mx-auto">
            {{ __('form.button.submit') }}
        </button>


    </form>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/simple-jscalendar@1.4.4/source/jsCalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="{{ asset('js/alpine/form.js') }}"></script>
@endpush
