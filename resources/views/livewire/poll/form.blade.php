<div>
    <form wire:submit.prevent="submit" x-data="getFormData">

        {{-- Základní informace o anketě --}}
        <x-card>
            <x-slot:header>{{ __('form.section.title.basic_info') }}</x-slot>
            <x-input id="title" x-model="form.title" type="text" required placeholder="New poll">
                {{ __('form.label.title') }}
            </x-input>
            <x-error for="form.title" />

            <x-textbox id="description" x-model="form.description">
                {{ __('form.label.description') }}
            </x-textbox>
            <x-error for="form.description" />


            <x-input id="deadline" x-model="form.deadline" type="date">
                <x-slot:tooltip>
                    {{ __('form.tooltip.deadline') }}
                </x-slot:tooltip>
                {{ __('form.label.deadline') }}
            </x-input>
            <x-error for="form.deadline" />


            {{-- Informace o autorovi --}}
            @if (!$poll->id)
                <div x-data="{ anonymous: @entangle('form.user.posted_anonymously') }">
                    <x-poll.form.checkbox id="show.user-info" x-model="anonymous">
                        {{ __('form.label.post_anonymously') }}
                    </x-poll.form.checkbox>
                    <div x-show="!anonymous">
                        <x-input id="user_name" x-model="form.user.name" type="text" required>
                            {{ __('form.label.user_name') }}
                        </x-input>
                        <x-error for="form.user.name" />

                        <x-input id="user_email" x-model="form.user.email" type="email">
                            {{ __('form.label.user_email') }}
                        </x-input>
                        <x-error for="form.user.email" />
                    </div>
                </div>
            @endif

        </x-card>

        {{-- Výběr časových termínů --}}
        <x-card>
            <x-slot:header>{{ __('form.section.title.time_options') }}</x-slot>
            <x-slot:tooltip>
                {{ __('form.section.tooltip.time_options') }}
            </x-slot:tooltip>
            <div class="row">
                <x-layouts.col-6>
                    <h3 class="mb-4">Calendar</h3>
                    <div id="js-calendar" class="w-100" x-init="initCalendar()" x-data wire:ignore></div>
                    <x-error for="form.dates" />
                </x-layouts.col-6>
                <x-layouts.col-6>
                    <h3 class="mb-4">Chosen dates</h3>

                    <template x-for="(date, dateIndex) in form.dates" :key="dateIndex">

                        <x-poll.form.date-card>
                            <template x-for="(option, optionIndex) in date" :key="optionIndex">
                                <div>
                                    <template x-if="option.type === 'time'">
                                        <x-poll.form.date-options-time />
                                    </template>

                                    <template x-if="option.type === 'text'">
                                        <x-poll.form.date-options-text />
                                    </template>
                                </div>
                            </template>

                            <div class="d-flex flex-wrap flex-md-nowrap align-items-center gap-2 mt-1">
                                <x-outline-button class="w-100 w-md-auto" @click="addTimeOption(dateIndex, 'time')">
                                    <i class="bi bi-clock me-1"></i> Add time option
                                </x-outline-button>

                                <x-outline-button class="w-100 w-md-auto" @click="addTimeOption(dateIndex, 'text')">
                                    <i class="bi bi-fonts me-1"></i> Add text option
                                </x-outline-button>
                            </div>

                        </x-poll.form.date-card>


                    </template>
                </x-layouts.col-6>
            </div>
        </x-card>


        {{-- Možná přesunout do livewire --}}
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-3">
                {{-- Výběr doplňujících otázek --}}

                <x-card>
                    <x-slot:header>{{ __('form.section.title.questions') }}</x-slot>
                    <x-slot:tooltip>
                        {{ __('form.section.tooltip.questions') }}
                    </x-slot:tooltip>


                    <template x-if="form.questions.length > 0">
                        <template x-for="(question, questionIndex) in form.questions" :key="questionIndex">
                            <x-poll.form.question-card>
                                <x-slot:header>
                                    {{-- Input pole pro text otázky --}}
                                    <input type="text" :id="'question_' + questionIndex"
                                        x-model="form.questions[questionIndex].text" class="form-control"
                                        :placeholder="'Question ' + (questionIndex + 1)" required>

                                    {{-- Tlačítko pro odstranění otázky --}}
                                    <button type="button" @click="removeQuestion(questionIndex)"
                                        class="btn btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </x-slot:header>

                                <template x-for="(option, optionIndex) in question.options" :key="optionIndex">
                                    <div class="d-flex align-items-center gap-2 mb-3">

                                        {{-- Input pole pro text možnosti --}}
                                        <input type="text"
                                            :id="'question_' + questionIndex + '_option_' + optionIndex"
                                            x-model="form.questions[questionIndex].options[optionIndex].text"
                                            :placeholder="'Option ' + (optionIndex + 1)" class="form-control" required>

                                        {{-- Tlačítko pro odstranění možnosti --}}
                                        <button type="button" @click="removeQuestionOption(questionIndex, optionIndex)"
                                            class="btn btn-danger"><i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    {{-- Zobrazení chybové hlášky, pokud možnost není validní --}}
                                </template>

                                {{-- Tlačítko pro přidání další možnosti --}}
                                <button type="button" @click="form.questions[questionIndex].options.push({ text: '' })"
                                    class="btn btn-outline-secondary">Add option</button>

                                {{-- Tlačítko pro přidání další otázky --}}

                            </x-poll.form.question-card>
                        </template>

                    </template>

                    <button type="button" @click="addQuestion()"
                        class="btn btn-outline-secondary w-25">Add
                        question</button>

                </x-card>

            </div>
            <div class="col-lg-6 col-md-12 mb-3">
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
                            Allow participants to vote anonymously.
                        </x-slot:tooltip>
                        Anonymous voting
                    </x-poll.form.checkbox>

                    {{-- Skrytí výsledků --}}
                    <x-poll.form.checkbox id="hide_results" x-model="form.settings.hide_results">
                        <x-slot:tooltip>
                            Hide the results of the poll until the deadline.
                        </x-slot:tooltip>
                        Hide results
                    </x-poll.form.checkbox>

                    {{-- Účástníci mohou změnit své odpovědi --}}
                    <x-poll.form.checkbox id="edit_votes" x-model="form.settings.edit_votes">
                        <x-slot:tooltip>
                            Allow participants to edit their votes after submission.
                        </x-slot:tooltip>
                        Allow vote editing
                    </x-poll.form.checkbox>

                    {{-- Pouze pro pozvané --}}
                    <x-poll.form.checkbox id="invite_only" x-model="form.settings.invite_only">
                        <x-slot:tooltip>
                            Permit only invited users to access the poll.
                        </x-slot:tooltip>
                        Invite only
                    </x-poll.form.checkbox>

                    {{-- Přidání časových možností --}}
                    <x-poll.form.checkbox id="add_time_options" x-model="form.settings.add_time_options">
                        <x-slot:tooltip>
                            Allow participants to add their own time options to the poll.
                        </x-slot:tooltip>
                        User can add time options
                    </x-poll.form.checkbox>

                    {{-- Heslo --}}
                    <x-input id="password" x-model="form.settings.password" type="password">
                        <x-slot:tooltip>
                            Set a password for the poll. Only users with the password can access the poll.
                        </x-slot:tooltip>
                        Password
                    </x-input>
                    <x-error for="form.settings.password" />
                </x-card>
            </div>
        </div>

        {{-- Další Chybové hlášky --}}
        <x-error-alert for="form.dates" />

        <button type="submit" class="btn btn-primary btn-lg w-75 mx-auto">
            {{ __('form.submit') }}
        </button>
    </form>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/simple-jscalendar@1.4.4/source/jsCalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="{{ asset('js/alpine/form.js') }}"></script>
@endpush
