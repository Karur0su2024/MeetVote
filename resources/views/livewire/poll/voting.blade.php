@php
    use Carbon\Carbon;
@endphp

<script>
    function votingData() {
        return {
            poll: @json($poll),
            form: @json($form),

            test() {
                console.log(this.poll, this.form.timeOptions);
            },

            showResults() {},

            submitVotes() {
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

            getNextPreference(type, currentPreference){
                if(type == "timeOption"){
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
                }
                else {
                    switch (currentPreference) {
                        case 0:
                            return 2;
                        case 2:
                            return 0;
                    }
                }
            }

        }
    }
</script>



<div x-data="votingData()">


    <x-card bodyPadding="0">

        <x-slot:header>
            <i class="bi bi-check-circle"></i>
            {{ $poll->title }}
        </x-slot:header>

        <x-slot:header>
            Voting
            <button class="btn btn-outline-secondary" @click="openModal('results')">
                Results ?
            </button>
            <button class="btn btn-outline-secondary" @click="test">
                Test
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
                            <i class="bi bi-calendar"></i> Dates (0)
                        </x:slot:header>

                        <div class="row g-0">
                            {{-- alpine.js foreach --}}
                            <template x-for="(timeOption, optionIndex) in form.timeOptions">
                                <div class="col-lg-6">
                                    <x-poll.show.voting.card x-bind:preference="(timeOption.picked_preference * 2)">
                                        <x-slot:content>
                                            <p class="mb-0 text-muted" x-text="timeOption.date"></p>
                                            <p class="mb-0 text-muted" x-text="timeOption.content"></p>
                                        </x-slot:content>
                                        <x-slot:score><span x-text="timeOption.score"></span></x-slot:score>
                                        <x-slot:button>
                                        <button @click="setPreference('timeOption', null, optionIndex, getNextPreference('timeOption', timeOption.picked_preference))"
                                            class="btn btn-outline-vote d-flex align-items-center"
                                            :class="'btn-outline-vote-' + timeOption.picked_preference"
                                            type="button">
                                            <img class="p-1"
                                                :src="'{{ asset('icons/') }}/' + timeOption.picked_preference + '.svg'"
                                                :alt="timeOption.picked_preference" />

                                        </button>
                                        </x-slot:button>
                                    </x-poll.show.voting.card>
                                </div>
                            </template>

                            {{-- V případě, že možné přidat nové časové možnosti, zobrazí se tlačítko pro přidání --}}
                            @if ($poll->add_time_options)
                                <div class="col-lg-6">
                                    <div class="card voting-card voting-card-clickable text-center"
                                        wire:click="openAddNewTimeOptionModal()">
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
                    @forelse ($form->questions as $questionIndex => $question)
                        <x-poll.show.voting.collapse-section id="question-{{ $question['id'] }}-options">
                            <x:slot:header>
                                <i class="bi bi-question-lg"></i> {{ $question['text'] }}
                                ({{ count($question['options']) }})
                            </x:slot:header>

                            <div class="row g-0">
                                @foreach ($question['options'] as $optionIndex => $option)
                                    <div class="col-lg-6">
                                        <x-poll.show.voting.card
                                            class="voting-card-{{ $option['picked_preference'] * 2 }}">
                                            <x-slot:content>
                                                <p class="mb-0 text-muted">
                                                    {{ $option['text'] }}
                                                </p>
                                            </x-slot:content>
                                            <x-slot:score>{{ $option['score'] }}</x-slot:score>
                                            <x-slot:button>
                                                <x-poll.show.preference-button :questionIndex="$questionIndex" :optionIndex="$optionIndex"
                                                    :pickedPreference="$option['picked_preference']" />
                                            </x-slot:button>
                                        </x-poll.show.voting.card>
                                    </div>
                                @endforeach
                            </div>

                        </x-poll.show.voting.collapse-section>

                    @empty
                    @endforelse



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
                                </div>
                                <div class="col-md-6 mb-3">
                                    <x-input id="email" alpine="form.user.email" type="email" required
                                        class="form-control-lg">
                                        Your e-mail
                                    </x-input>
                                </div>
                            </div>
                        @endif

                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <button type="submit" class="btn btn-primary btn-lg px-4 py-2 d-flex align-items-center">
                                <i class="bi bi-check-circle me-2"></i> Submit your vote
                            </button>
                            <div class="d-flex align-items-center ms-2">
                                @if (session()->has('error'))
                                    <span class="text-danger">{{ session('error') }}</span>
                                @else
                                    <span wire:loading wire:target="submit">
                                        <div class="spinner-border spinner-border-sm me-2" role="status">
                                        </div>
                                        Saving...
                                    </span>
                                @endif
                                @if (session()->has('success'))
                                    <span class="text-success">{{ session('success') }}</span>
                                @endif
                            </div>


                        </div>
                    </div>

                </form>
            </div>


        @endif




    </x-card>

</div>
