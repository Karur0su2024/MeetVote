<div>
    <form wire:submit.prevent="submit" x-data="getFormData">

        {{-- Základní informace o anketě --}}
        <x-card>

            {{-- Hlavička --}}
            <x-slot:header>{{ __('form.section.title.basic_info') }}</x-slot>

            {{-- Název ankety --}}
            <x-input id="title" x-model="form.title" type="text" required placeholder="New poll">
                {{ __('form.label.title') }}
            </x-input>
            <x-error for="form.title"/>

            {{-- Popis ankety --}}
            <x-textbox id="description" x-model="form.description">
                {{ __('form.label.description') }}
            </x-textbox>
            <x-error for="form.description"/>

            {{-- Deadline ankety --}}
            <x-input id="deadline" x-model="form.deadline" type="date">
                <x-slot:tooltip>
                    {{ __('form.tooltip.deadline') }}
                </x-slot:tooltip>
                {{ __('form.label.deadline') }}
            </x-input>
            <x-error for="form.deadline"/>


            {{-- Informace o autorovi --}}
            @if (!$poll->id)
                <div x-data="{ anonymous: @entangle('form.user.posted_anonymously') }">

                    {{-- Nastavení anonymity autora --}}
                    <x-poll.form.checkbox id="show.user-info" x-model="anonymous">
                        {{ __('form.label.post_anonymously') }}
                    </x-poll.form.checkbox>

                    <div x-show="!anonymous">

                        {{-- Jméno autora --}}
                        <x-input id="user_name" x-model="form.user.name" type="text" required>
                            {{ __('form.label.user_name') }}
                        </x-input>
                        <x-error for="form.user.name"/>

                        {{-- E-mail autora --}}
                        <x-input id="user_email" x-model="form.user.email" type="email">
                            {{ __('form.label.user_email') }}
                        </x-input>
                        <x-error for="form.user.email"/>

                    </div>
                </div>
            @endif

        </x-card>

        {{-- Výběr časových termínů --}}
        <x-card>

            {{-- Hlavička --}}
            <x-slot:header>{{ __('form.section.title.time_options') }}</x-slot>

            {{-- Tooltip --}}
            <x-slot:tooltip>
                {{ __('form.section.tooltip.time_options') }}
            </x-slot:tooltip>

            <div class="row">

                {{-- Polovina s kalendářem --}}
                <x-layouts.col-6>
                    <h3 class="mb-4">{{ __('form.subsection.title.calendar') }}</h3>
                    <div id="js-calendar" class="w-100" x-init="initCalendar()" x-data wire:ignore></div>
                    <x-error for="form.dates"/>
                </x-layouts.col-6>

                {{-- Polovina časovými termíny --}}
                <x-layouts.col-6>
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
                            <div class="d-flex flex-wrap flex-md-nowrap align-items-center gap-2 mt-1">

                                <x-outline-button class="w-100 w-md-auto" @click="addTimeOption(dateIndex, 'time')">
                                    <i class="bi bi-clock me-1"></i>{{ __('form.button.time_option_time') }}
                                </x-outline-button>

                                <x-outline-button class="w-100 w-md-auto" @click="addTimeOption(dateIndex, 'text')">
                                    <i class="bi bi-fonts me-1"></i>{{ __('form.button.time_option_text') }}
                                </x-outline-button>

                            </div>

                        </x-poll.form.date-card>

                    </template>
                </x-layouts.col-6>
            </div>
        </x-card>


        {{-- Možná přesunout do livewire --}}
        <div class="row">
            <x-layouts.col-6>
                {{-- Výběr doplňujících otázek --}}

                <x-card>
                    <x-slot:header>{{ __('form.section.title.questions') }}</x-slot>
                    <x-slot:tooltip>
                        {{ __('form.section.tooltip.questions') }}
                    </x-slot:tooltip>


                    <template x-if="form.questions.length > 0">
                        <template x-for="(question, questionIndex) in form.questions" :key="questionIndex">
                            <x-poll.form.question-card>
                                <template x-for="(option, optionIndex) in question.options" :key="optionIndex">
                                    <x-poll.form.question-card-option/>
                                    {{-- Zobrazení chybové hlášky, pokud možnost není validní --}}
                                </template>

                                {{-- Tlačítko pro přidání další možnosti --}}
                                <button type="button"
                                        @click="form.questions[questionIndex].options.push({ text: '' })"
                                        class="btn btn-outline-secondary">{{ __('form.button.add_option') }}</button>

                            </x-poll.form.question-card>
                        </template>

                    </template>

                    {{-- Tlačítko pro přidání další otázky --}}
                    <button type="button"
                            @click="addQuestion()"
                            class="btn btn-outline-secondary w-25">{{ __('form.button.add_question') }}</button>

                </x-card>


            </x-layouts.col-6>
            <x-layouts.col-6>
                {{-- Nastavení ankety --}}
                <x-card>
                    <x-slot:header>{{ __('form.section.title.settings') }}</x-slot>

                    {{-- Komentáře --}}
                    <x-poll.form.checkbox id="comments" x-model="form.settings.comments">
                        <x-slot:tooltip>
                            {{ __('form.tooltip.comments') }}
                        </x-slot:tooltip>
                        {{ __('form.label.comments') }}
                    </x-poll.form.checkbox>

                    {{-- Tajné hlasování --}}
                    <x-poll.form.checkbox id="anonymous" x-model="form.settings.anonymous">
                        <x-slot:tooltip>
                            {{ __('form.tooltip.anonymous') }}
                        </x-slot:tooltip>
                        {{ __('form.label.anonymous') }}
                    </x-poll.form.checkbox>

                    {{-- Skrytí výsledků --}}
                    <x-poll.form.checkbox id="hide_results" x-model="form.settings.hide_results">
                        <x-slot:tooltip>
                            {{ __('form.tooltip.hide_results') }}

                        </x-slot:tooltip>
                        {{ __('form.label.hide_results') }}

                    </x-poll.form.checkbox>

                    {{-- Účástníci mohou změnit své odpovědi --}}
                    <x-poll.form.checkbox id="edit_votes" x-model="form.settings.edit_votes">
                        <x-slot:tooltip>
                            {{ __('form.tooltip.edit_votes') }}

                        </x-slot:tooltip>
                        {{ __('form.label.edit_votes') }}

                    </x-poll.form.checkbox>

                    {{-- Pouze pro pozvané --}}
                    <x-poll.form.checkbox id="invite_only" x-model="form.settings.invite_only">
                        <x-slot:tooltip>
                            {{ __('form.tooltip.invite_only') }}

                        </x-slot:tooltip>
                        {{ __('form.label.invite_only') }}

                    </x-poll.form.checkbox>

                    {{-- Přidání časových možností --}}
                    <x-poll.form.checkbox id="add_time_options" x-model="form.settings.add_time_options">
                        <x-slot:tooltip>
                            {{ __('form.tooltip.add_time_options') }}

                        </x-slot:tooltip>
                        {{ __('form.label.add_time_options') }}

                    </x-poll.form.checkbox>

                    {{-- Heslo --}}
                    <x-input id="password" x-model="form.settings.password" type="password">
                        <x-slot:tooltip>
                            {{ __('form.tooltip.password') }}

                        </x-slot:tooltip>
                        {{ __('form.label.password') }}

                    </x-input>
                    <x-error for="form.settings.password"/>
                </x-card>
            </x-layouts.col-6>
        </div>

        {{-- Další Chybové hlášky --}}
        <x-error-alert for="form.dates"/>

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
