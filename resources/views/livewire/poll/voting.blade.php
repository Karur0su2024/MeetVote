@php
    use Carbon\Carbon;
@endphp

{{-- https://github.com/livewire/livewire/issues/830 --}}
{{-- Přidat ještě listener pro update hlasu --}}
<div x-data="votingData()"
     @validation-failed.window="unsuccessfulVote($event.detail.errors)"
     @vote-submitted.window="successfulVote()"
     @refresh-poll.window="refreshPoll($event.detail.formData)">

    <x-card bodyPadding="0">

        <x-slot:header>
            Voting
            <button class="btn btn-outline-secondary"
                    @click="openModal('results')">
                Results ({{ count($poll->votes) }})
            </button>
        </x-slot:header>

        @can('canVote', $poll)
            <div>
                <div class="p-4 w-100">
                    <div class="mx-auto w-100 d-flex flex-wrap justify-content-around text-center" wire:ignore>
                        <x-poll.show.voting.legend name="Yes" value="2"/>
                        <x-poll.show.voting.legend name="Maybe" value="1"/>
                        <x-poll.show.voting.legend name="No" value="-1"/>
                    </div>
                </div>
                <form @submit.prevent='submitVotes'>

                    <div class="accordion accordion-flush" id="accordionPoll">
                        {{-- Časové možnosti --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button p-4 fw-bold fs-4" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseTimeOptions" aria-expanded="false"
                                        aria-controls="collapseTimeOptions">
                                    <i class="bi bi-calendar-event me-2"></i>
                                    <span>Time Options</span>
                                    <span class="badge text-bg-dark ms-2" x-text="form.timeOptions.length"></span>
                                </button>
                            </h2>
                            <div id="collapseTimeOptions" class="accordion-collapse collapse show">
                                <div class="accordion-body p-0">
                                    <div class="row g-0">
                                        <template x-for="(timeOption, optionIndex) in form.timeOptions">
                                            <div class="col-lg-6">
                                                <x-poll.voting.time-option-card :poll="$poll"/>
                                            </div>
                                        </template>

                                        @if ($poll->add_time_options)
                                            <div class="col-lg-6">
                                                <div
                                                    class="card voting-card voting-card-clickable text-center hover-shadow transition-all"
                                                    @click="openModal('add-new-time-option')">
                                                    <div
                                                        class="card-body add-option-card d-flex align-items-center justify-content-center gap-2 py-4">
                                                        <i class="bi bi-plus-circle-fill text-primary fs-4"></i>
                                                        <h5 class="card-title mb-0">Add new time option</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- Dodatečné otázky --}}
                        <template x-for="(question, questionIndex) in form.questions">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button p-4 fw-bold fs-4" type="button"
                                            data-bs-toggle="collapse"
                                            :data-bs-target="'#collapseQuestion' + questionIndex" aria-expanded="false"
                                            :aria-controls="'collapseQuestion' + questionIndex">
                                        <i class="bi bi-question-circle me-2"></i>
                                        <span x-text="question.text"></span>
                                        <span class="badge text-bg-dark ms-2" x-text="question.options.length"></span>
                                    </button>
                                </h2>
                                <div :id="'collapseQuestion' + questionIndex" class="accordion-collapse collapse show">
                                    <div class="accordion-body p-0">
                                        <div class="row g-0">
                                            <template x-for="(option, optionIndex) in question.options">
                                                <div class="col-lg-6">
                                                    <x-poll.voting.question-option-card :poll="$poll" />
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>


                    {{-- Formulář pro vyplnění jména a e-mailu --}}
                    <div class="p-4">

                        @if (!$poll->anonymous_votes)
                            <x-pages.poll-show.voting.form/>
                        @endif

                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <x-ui.button type="submit" size="lg">
                                Submit your vote
                            </x-ui.button>
                            <span x-show="isSubmitting">
                                <x-ui.saving>
                                        Saving...
                                </x-ui.saving>
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
        @else
            <div class="alert alert-warning mb-0">
                <i class="bi bi-exclamation-triangle-fill"></i> Poll is closed. You can no longer vote.
            </div>
        @endcan


    </x-card>

</div>

@push('scripts')
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
                                pollId: this.poll.id,
                            }
                        },
                    });
                },

                // Nastavení preference pro časovou možnost nebo otázku
                setPreference(type, questionIndex, optionIndex, preference) {
                    if (type === 'timeOption') {
                        this.form.timeOptions[optionIndex].picked_preference = preference;
                    } else if (type == 'question') {
                        this.form.questions[questionIndex].options[optionIndex].picked_preference = preference;
                    }
                },

                // Získání další preference
                getNextPreference(type, currentPreference) {
                    if (type === "timeOption") {
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

                // Kontrola, zda je vybrána alespoň jedna možnost
                checkIfSelected() {
                    for (i = 0; i < this.form.timeOptions.length; i++) {
                        if (this.form.timeOptions[i].picked_preference !== 0) {
                            return true;
                        }
                    }
                    for (i = 0; i < this.form.questions.length; i++) {
                        for (j = 0; j < this.form.questions[i].options.length; j++) {
                            if (this.form.questions[i].options[j].picked_preference !== 0) {
                                return true;
                            }
                        }
                    }

                    this.messages.errors.form = "You have to select at least one option.";

                    return false;
                },

                // Zpracování neúspěšného odeslání hlasu
                unsuccessfulVote(errors) {
                    this.isSubmitting = false;
                    this.messages.errors = errors;
                },

                // Zpracování úspěšného odeslání hlasu
                successfulVote() {
                    this.isSubmitting = false;
                    this.messages.errors = {};
                    this.messages.success = "Your vote has been successfully submitted.";
                    this.form = @json($form, JSON_THROW_ON_ERROR);
                },

                // Získání nových dat pro hlasování
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
@endpush



