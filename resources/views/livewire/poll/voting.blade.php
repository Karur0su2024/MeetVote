@php
    use Carbon\Carbon;
@endphp

<script>
    function votingData() {
        return {
            poll: @json($poll), // Data ankety
            form: @json($form), // Data pro hlasování
            isSubmitting: false,
            messages: {
                errors: {},
                success: '',
            },

            submitVotes() {
                this.isSubmitting = true;
                this.messages.errors = {};
                this.messages.success = '';

                // Zjištění, zda je vybrána alespoň jedna možnost
                if (!this.checkIfSelected()) {
                    this.isSubmitting = false;
                    return;
                }

                // Odeslání hlasu
                Livewire.dispatch('submitVote', {
                    voteData: this.form,
                });
            },

            openModal(alias) {
                Livewire.dispatch('showModal', {
                    data: {
                        alias: 'modals.poll.' + alias,
                        params: {
                            publicIndex: this.poll.public_id
                        }
                    },
                });
            },

            setPreference(type, questionIndex, optionIndex, preference) {
                if (type == 'timeOption') {
                    this.form.timeOptions[optionIndex].picked_preference = preference;
                } else if (type == 'question') {
                    this.form.questions[questionIndex].options[optionIndex].picked_preference = preference;
                }
            },

            getNextPreference(type, currentPreference) {
                if (type == "timeOption") {
                    switch (currentPreference) {
                        case 0:
                            return 2;
                        case 2:
                            return 1;
                        case 1:
                            return -1;
                        case -1:
                            return 0;
                    }
                } else {
                    switch (currentPreference) {
                        case 0:
                            return 2;
                        case 2:
                            return 0;
                    }
                }
            },

            checkIfSelected() {
                for (i = 0; i < this.form.timeOptions.length; i++) {
                    if (this.form.timeOptions[i].picked_preference != 0) {
                        return true;
                    }
                }
                for (i = 0; i < this.form.questions.length; i++) {
                    for (j = 0; j < this.form.questions[i].options.length; j++) {
                        if (this.form.questions[i].options[j].picked_preference != 0) {
                            return true;
                        }
                    }
                }

                this.messages.errors.form = "You have to select at least one option.";

                return false;
            },

            unsuccesfulVote(errors) {
                this.isSubmitting = false;
                this.messages.errors = errors;
            },

            succesfulVote() {
                this.isSubmitting = false;
                this.messages.errors = {};
                this.messages.success = "Your vote has been successfully submitted.";
                this.form = @json($form);
            },

            refreshPoll(formData) {
                this.form = formData
                this.isSubmitting = false;
                this.messages.errors = {};

                if (this.form.existingVote != null) {
                    this.messages.success = "Vote has been loaded.";
                }
            },

        }
    }
</script>


{{-- https://github.com/livewire/livewire/issues/830 --}}
{{-- Přidat ještě listener pro update hlasu --}}
<div x-data="votingData()" @validation-failed.window="unsuccesfulVote($event.detail.errors)"
    @vote-submitted.window="succesfulVote()" @refresh-poll.window="refreshPoll($event.detail.formData)">


    <x-card bodyPadding="0">

        <x-slot:header>
            <i class="bi bi-check-circle"></i>
            {{ $poll->title }}
        </x-slot:header>

        <x-slot:header>
            Voting
            <button class="btn btn-outline-secondary" @click="openModal('results')">
                Results ({{ count($poll->votes) }})
            </button>
        </x-slot:header>

        @if ($poll->status == 'closed')
            <div class="alert alert-warning mb-0">
                <i class="bi bi-exclamation-triangle-fill"></i> Poll is closed. You can no longer vote.
            </div>
        @else
            <div>
                <div class="p-4 w-100">
                    <div class="mx-auto w-100 d-flex flex-wrap justify-content-around text-center" wire:ignore>
                        <x-poll.show.voting.legend name="Yes" value="2" />
                        <x-poll.show.voting.legend name="Maybe" value="1" />
                        <x-poll.show.voting.legend name="No" value="-1" />
                    </div>
                </div>
                <form @submit.prevent='submitVotes'>
                    {{-- Časové možnosti --}}
                    <x-poll.show.voting.collapse-section id="timeOption">
                        <x:slot:header>
                            <i class="bi bi-calendar"></i> Dates (<span x-text="form.timeOptions.length"></span>)
                        </x:slot:header>

                        <div class="row g-0">
                            {{-- alpine.js foreach --}}
                            <template x-for="(timeOption, optionIndex) in form.timeOptions">
                                <div class="col-lg-6">
                                    <div class="card card-sharp voting-card  border-start-0 border-end-0 p-3"
                                        :class="'voting-card-' + timeOption.picked_preference">
                                        {{-- Obsah možnosti --}}
                                        <div class="card-body voting-card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                {{-- Obsah možnosti --}}
                                                <div>
                                                    <p class="mb-0 text-muted" x-text="timeOption.date"></p>
                                                    <p class="mb-0 text-muted" x-text="timeOption.content"></p>
                                                </div>

                                                {{-- Zobrazení hlasů --}}
                                                <div class="d-flex flex-column">
                                                    <span x-text="timeOption.score"></span>
                                                </div>

                                                {{-- Výběr preference časové možnosti --}}
                                                <div>
                                                    <button
                                                        @click="setPreference('timeOption', null, optionIndex, getNextPreference('timeOption', timeOption.picked_preference))"
                                                        class="btn btn-outline-vote d-flex align-items-center"
                                                        :class="'btn-outline-vote-' + timeOption.picked_preference"
                                                        type="button">
                                                        <img class="p-1"
                                                            :src="'{{ asset('icons/') }}/' + timeOption.picked_preference +
                                                                '.svg'"
                                                            :alt="timeOption.picked_preference" />

                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </template>







                            {{-- V případě, že možné přidat nové časové možnosti, zobrazí se tlačítko pro přidání --}}
                            @if ($poll->add_time_options)
                                <div class="col-lg-6">
                                    <div class="card voting-card voting-card-clickable text-center"
                                        @click="openModal('add-new-time-option')">
                                        <div
                                            class="card-body add-option-card d-flex align-items-center justify-content-center gap-2">
                                            <i class="bi bi-plus-circle-fill text-muted fs-4"></i>
                                            <h4 class="card-title mb-0">Add new option</h4>
                                        </div>

                                    </div>
                                </div>
                            @endif

                        </div>
                    </x-poll.show.voting.collapse-section>


                    {{-- Otázky ankety --}}

                    <template x-for="(question, questionIndex) in form.questions">
                        <x-poll.show.voting.collapse-section :id="'question-${questionIndex}-options'">
                            <x-slot:header>
                                <i class="bi bi-question-lg"></i>
                                <span x-text="question.text"></span>
                                (<span x-text="question.options.length"></span>)
                            </x-slot:header>

                            <div class="row g-0">
                                <template x-for="(option, optionIndex) in question.options">
                                    <div class="col-lg-6">
                                        <div class="card card-sharp voting-card  border-start-0 border-end-0 p-3"
                                            :class="'voting-card-' + option.picked_preference">
                                            <div class="card-body voting-card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    {{-- Obsah možnosti --}}
                                                    <div>
                                                        <p class="mb-0 text-muted" x-text="option.text"></p>
                                                    </div>

                                                    {{-- Zobrazení hlasů --}}
                                                    <div>
                                                        <span x-text="option.score"></span>
                                                    </div>

                                                    {{-- Výběr preference časové možnosti --}}
                                                    <div>
                                                        <button
                                                        @click="setPreference('question', questionIndex, optionIndex, getNextPreference('question', option.picked_preference))"
                                                        class="btn btn-outline-vote d-flex align-items-center"
                                                        :class="'btn-outline-vote-' + option.picked_preference"
                                                        type="button">
                                                        <img class="p-1"
                                                            :src="'{{ asset('icons/') }}/' + option.picked_preference + '.svg'"
                                                            :alt="option.picked_preference" />
                                                    </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </template>

                            </div>

                        </x-poll.show.voting.collapse-section>
                    </template>



                    {{-- Formulář pro vyplnění jména a e-mailu --}}
                    <div class="p-4">

                        @if (!$poll->anonymous_votes)
                            <div class="row">
                                <h3 class="mb-4 pb-2 fw-bold">
                                    Your information
                                </h3>
                                <div class="col-md-6 mb-3">
                                    <x-input id="name" alpine="form.user.name" type="text" required
                                        class="form-control-lg">
                                        Your name
                                    </x-input>
                                    <div x-show="messages.errors['form.user.name']" class="text-danger">
                                        <span x-text="messages.errors['form.user.name']"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <x-input id="email" alpine="form.user.email" type="email" required
                                        class="form-control-lg">
                                        Your e-mail
                                    </x-input>
                                    <div x-show="messages.errors['form.user.email']" class="text-danger">
                                        <span x-text="messages.errors['form.user.email']"></span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <button type="submit" class="btn btn-primary btn-lg px-4 py-2 d-flex align-items-center">
                                <i class="bi bi-check-circle me-2"></i> Submit your vote
                            </button>
                            <span x-show="isSubmitting" wire:target="submit">
                                <div class="spinner-border spinner-border-sm me-2" role="status">
                                </div>
                                Saving...
                            </span>
                            <span class="text-danger" x-show="messages.errors.form" x-text="messages.errors.form"
                                class="text-danger me-2"></span>

                            {{-- Zobrazí se, pokud je hlasování úspěšné --}}
                            <span x-show="messages.success" class="text-success me-2">
                                <i class="bi bi-check-circle me-2"></i>
                                <span x-text="messages.success"></span>
                            </span>

                        </div>
                    </div>

                </form>
            </div>


        @endif


    </x-card>

</div>
