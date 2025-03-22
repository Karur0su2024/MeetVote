<x-card>

    {{-- Hlavička --}}
    <x-slot:header>{{ __('form.section.title.time_options') }}</x-slot>

    {{-- Tooltip --}}
    <x-slot:tooltip>
        {{ __('form.section.tooltip.time_options') }}
    </x-slot:tooltip>

    <div class="row">

        {{-- Polovina s kalendářem --}}
        <x-layout.col-6>
            <h3 class="mb-4">{{ __('form.subsection.title.calendar') }}</h3>
            <div id="js-calendar" class="w-100" x-init="initCalendar()" x-data wire:ignore></div>
            <x-error for="form.dates"/>
        </x-layout.col-6>

        {{-- Polovina časovými termíny --}}
        <x-layout.col-6>
            <h3 class="mb-4">{{ __('form.subsection.title.dates') }}</h3>

            <template x-for="(date, dateIndex) in form.dates" :key="dateIndex">

                {{-- Karta s datem --}}
                <x-poll.form.date-card>
                    <template x-for="(option, optionIndex) in date" :key="optionIndex">
                        <div>

                            {{-- Zobrazení časového intervalu --}}
                            <template x-if="option.type === 'time'">
                                <x-poll.form.date-options-time/>
                            </template>

                            {{-- Zobrazení textové možnosti --}}
                            <template x-if="option.type === 'text'">
                                <x-poll.form.date-options-text/>
                            </template>

                        </div>
                    </template>

                    {{-- Tlačítka pro přídání časové/textové možnosti --}}


                </x-poll.form.date-card>

            </template>
        </x-layout.col-6>
    </div>
</x-card>
