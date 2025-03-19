<div>
    <form wire:submit.prevent="submit" x-data="getFormData">

        <!-- Základní informace o anketě -->
        <x-card>
            <x-slot:header>{{ __('form.section.title.basic_info') }}</x-slot>
            <x-input id="title" wire:model="form.title" type="text" required placeholder="New poll">
                {{ __('form.label.title') }}
            </x-input>
            @error('form.title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            <x-textbox id="description" model="form.description">
                {{ __('form.label.description') }}
            </x-textbox>

            <x-input id="deadline" wire:model="form.deadline" type="date">
                <x-slot:tooltip>
                    {{ __('form.tooltip.deadline') }}
                </x-slot:tooltip>
                {{ __('form.label.deadline') }}
            </x-input>
            @error('form.deadline')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror


            {{-- Informace o autorovi --}}
            @if (!$poll->id)
                <div x-data="{ anonymous: @entangle('form.user.posted_anonymously') }">
                    <x-poll.form.checkbox id="show.user-info" x-model="anonymous">
                        {{ __('form.label.post_anonymously') }}
                    </x-poll.form.checkbox>
                    <div x-show="!anonymous">
                        <x-input id="user_name" wire:model="form.user.name" type="text" required>
                            {{ __('form.label.user_name') }}
                        </x-input>
                        @error('form.user.name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <x-input id="user_email" wire:model="form.user.email" type="email">
                        {{ __('form.label.user_email') }}
                    </x-input>
                    @error('form.user.email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
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
                    @error('form.dates')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </x-layouts.col-6>
                <x-layouts.col-6>
                    <h3 class="mb-4">Chosen dates</h3>

                    <template x-for="(date, dateIndex) in form.dates" :key="dateIndex">

                        <x-poll.form.date-card>
                            <x-slot:header>
                                <!-- Zobrazení data -->
                                <strong class="card-title m-0"
                                    x-text="moment(dateIndex).format('dddd, D. MMMM YYYY')"></strong>
                                <!-- Tlačítko pro odstranění celého data -->
                                <button type="button" class="btn btn-sm btn-danger" @click="removeDate(dateIndex)">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </x-slot:header>
                            <template x-for="(option, optionIndex) in date" :key="optionIndex">
                                <div>
                                    <template x-if="option.type === 'time'">

                                        <div class="p-2 mb-2 rounded border" x-show="option.type == 'time'">
                                            <!-- Zobrazení časového intervalu -->
                                            <div class="d-flex flex-wrap flex-md-nowrap align-items-between gap-2">
                                                {{-- Pole pro zadání začátku časového intervalu  --}}
                                                <input type="time"
                                                    x-model="form.dates[dateIndex][optionIndex].content.start"
                                                    :id="'start_' + dateIndex + '_' + optionIndex"
                                                    class="form-control w-100 w-md-auto">

                                                <input type="time"
                                                    x-model="form.dates[dateIndex][optionIndex].content.end"
                                                    :id="'end_' + dateIndex + '_' + optionIndex"
                                                    class="form-control w-100 w-md-auto">

                                                {{-- Tlačítko pro odstranění časové možnosti --}}
                                                <button type="button" @click="removeTimeOption(dateIndex, optionIndex)"
                                                    class="btn btn-danger mx-auto">
                                                    <i class="bi bi-trash"></i><span
                                                        class="d-md-none ms-1">Delete</span>
                                                </button>
                                            </div>


                                        </div>
                                    </template>



                                    <template x-if="option.type === 'text'">

                                        <!-- Zobrazení textové možnosti -->
                                        <div class="p-2 mb-2 rounded border" x-show="option.type === 'text'">
                                            <div class="d-flex align-items-center gap-2">
                                                <!-- Pole pro zadání textové možnosti -->
                                                <input type="text"
                                                    x-model="form.dates[dateIndex][optionIndex].content.text"
                                                    :id="'text_' + dateIndex + '_' + optionIndex" class="form-control"
                                                    :placeholder="'Option ' + (optionIndex + 1)">


                                                <!-- Tlačítko pro odstranění textové možnosti -->
                                                <button type="button" @click="removeTimeOption(dateIndex, optionIndex)"
                                                    class="btn btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>

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

                    <button type="button" type="button w-25" @click="addQuestion()"
                        class="btn btn-outline-secondary">Add
                        question</button>

                </x-card>

            </div>
            <div class="col-lg-6 col-md-12 mb-3">
                {{-- Nastavení ankety --}}
                <x-card>
                    <x-slot:header>Poll settings</x-slot>

                    <!-- Komentáře -->
                    <x-poll.form.checkbox id="comments" wire:model="form.settings.comments">
                        <x-slot:tooltip>
                            Allow participants to add comments to the poll.
                        </x-slot:tooltip>
                        Comments
                    </x-poll.form.checkbox>

                    {{-- Tajné hlasování --}}
                    <x-poll.form.checkbox id="anonymous" wire:model="form.settings.anonymous">
                        <x-slot:tooltip>
                            Allow participants to vote anonymously.
                        </x-slot:tooltip>
                        Anonymous voting
                    </x-poll.form.checkbox>

                    {{-- Skrytí výsledků --}}
                    <x-poll.form.checkbox id="hide_results" wire:model="form.settings.hide_results">
                        <x-slot:tooltip>
                            Hide the results of the poll until the deadline.
                        </x-slot:tooltip>
                        Hide results
                    </x-poll.form.checkbox>

                    {{-- Allow participants to edit their votes --}}
                    <x-poll.form.checkbox id="edit_votes" wire:model="form.settings.edit_votes">
                        <x-slot:tooltip>
                            Allow participants to edit their votes after submission.
                        </x-slot:tooltip>
                        Allow vote editing
                    </x-poll.form.checkbox>

                    {{-- Pouze pro pozvané --}}
                    <x-poll.form.checkbox id="invite_only" wire:model="form.settings.invite_only">
                        <x-slot:tooltip>
                            Permit only invited users to access the poll.
                        </x-slot:tooltip>
                        Invite only
                    </x-poll.form.checkbox>

                    <x-poll.form.checkbox id="add_time_options" wire:model="form.settings.add_time_options">
                        <x-slot:tooltip>
                            Allow participants to add their own time options to the poll.
                        </x-slot:tooltip>
                        User can add time options
                    </x-poll.form.checkbox>

                    {{-- Heslo --}}
                    <x-input id="password" model="form.settings.password" type="password">
                        <x-slot:tooltip>
                            Set a password for the poll. Only users with the password can access the poll.
                        </x-slot:tooltip>
                        Password
                    </x-input>

                </x-card>
            </div>
        </div>


        @error('form.error')
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @enderror

        <button type="submit" class="btn btn-primary btn-lg w-75 mx-auto">
            {{ __('form.submit') }}
        </button>

    </form>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/simple-jscalendar@1.4.4/source/jsCalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

    <script>
        function getFormData() {
            return {
                form: this.$wire.entangle('form'),

                initCalendar() {
                    var calendar = new jsCalendar("#js-calendar");
                    calendar.min("now");
                    calendar.onDateClick((event, date) => {
                        this.addDate(date);
                        console.log(this.form.dates);
                    });
                },


                addDate(date) {
                    formattedDate = moment(date).format('YYYY-MM-DD');

                    if(moment(date).isBefore(moment(), 'day')) {
                        console.log(moment(date).isBefore(moment(), 'day'));
                        // Přidat error message
                        return;
                    }

                    if(this.form.dates[formattedDate] !== undefined) {
                        // Přidat error message
                        return;
                    }

                    this.form.dates[formattedDate] = [{
                        type: 'time',
                        content: {
                            start: moment().format('HH:mm'),
                            end: moment().add(1, 'hour').format('HH:mm'),
                        }

                    }, ];


                },

                removeDate(date) {
                    if(this.form.dates.length <= 1) {
                        // Přidání error message
                        return;
                    }

                    // Přidat odstranění pro všechny položky uvnitř data
                    // A přidat je do pole pro odstranění pokud obsahují ID


                    // https://www.geeksforgeeks.org/remove-elements-from-a-javascript-array/
                    delete this.form.dates[date];

                },

                // Funkce pro přidání časové možnosti
                addTimeOption(date, type) {


                    // Přidání časové možnosti do formuláře
                    if (this.form.dates[date] === undefined) {
                        this.form.dates[date] = [];
                    }



                    // Kontrola typu možnosti
                    if (type === 'time') {
                        let lastEnd = this.getLastEnd(date);
                        this.form.dates[date].push({
                            type: type,
                            date: date,
                            content: {
                                start: lastEnd,
                                end: moment(lastEnd, 'HH:mm').add(1, 'hour').format('HH:mm'),
                            },
                        });
                    } else {
                        this.form.dates[date].push({
                            type: type,
                            date: date,
                            content: {
                                text: "",
                            },
                        });
                    }


                },

                removeTimeOption(date, index) {

                    // Odstranění časové možnosti z formuláře
                    if (this.form.dates[date].length <= 1) {
                        // Přidat error message
                        return;
                    }

                    if(this.form.dates[date][index].id !== undefined) {
                        this.form.removed['time_options'].push(this.form.dates[date][index].id);
                    }

                    this.form.dates[date].splice(index, 1);
                },



                // Zjištění posledního konce časového intervalu pokud existuje
                getLastEnd(dateIndex){

                    let lastEnd = null;

                    this.form.dates[dateIndex].forEach((option) => {
                        if (option.type === 'time') {
                            lastEnd = option.content.end;
                        }
                    });

                    if (lastEnd === null) {
                        lastEnd = moment().format('HH:mm');
                    }

                    return lastEnd;
                },


                // Funkce pro otázky
                addQuestion() {
                    this.form.questions.push({
                        text: '',
                        options: [{
                                text: '',
                            },
                            {
                                text: '',
                            }
                        ],
                    });
                },

                removeQuestion(index) {


                    if(this.form.questions[index].id !== undefined) {
                        this.form.removed['questions'].push(this.form.questions[index].id);
                    }



                    this.form.questions.splice(index, 1);
                },

                addQuestionOption(questionIndex) {
                    this.form.questions[questionIndex].options.push({
                        text: '',
                    });
                },

                removeQuestionOption(questionIndex, optionIndex) {
                    if (this.form.questions[questionIndex].options.length <= 2) {
                        // Přidat error message
                        return;
                    }

                    if(this.form.questions[questionIndex].options[optionIndex].id !== undefined) {
                        this.form.removed['questions_options'].push(this.form.questions[questionIndex].options[optionIndex].id);
                    }

                    this.form.questions[questionIndex].options.splice(optionIndex, 1);
                },
            }
        }



        //     $this->resetErrorBag('form.dates');

        //     $date = Carbon::parse($date)->format('Y-m-d');


        //     // Kontrola zda je datum již přidáno
        //     if (isset($this->form->dates[$date])) {
        //         $this->addError('form.dates', 'This date has already been added.');

        //         return;
        //     }

        //     $isNotPast = Carbon::parse($date)->isFuture() || Carbon::parse($date)->isToday();

        //     if (! $isNotPast) {
        //         $this->addError('form.dates', 'You cannot add a date in the past.');
        //         return;
        //     }

        //     $this->form->dates[$date] = [];

        //     $this->addTimeOption($date, 'time');

        //     ksort($this->form->dates);

        // }
    </script>
@endpush
