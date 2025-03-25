@php
    use Carbon\Carbon;
@endphp

{{-- https://github.com/livewire/livewire/issues/830 --}}
{{-- Přidat ještě listener pro update hlasu --}}
<div x-data="getVotingData">

    <x-ui.card body-padding="0" collapsable>

        <x-slot:header>
            {{ __('pages/poll-show.voting.title') }}
        </x-slot:header>

        <x-slot:headerRight>
            <button class="btn btn-outline-secondary"
                    wire:click="openModal('modals.poll.results', '{{ $poll->id }}')">
                {{ __('pages/poll-show.voting.buttons.results') }} ({{ count($poll->votes) }})
            </button>
        </x-slot:headerRight>

        @if($poll->isActive())
            <div>
                <div class="p-4 w-100">
                    <div class="mx-auto w-100 d-flex flex-wrap justify-content-around text-center" wire:ignore>
                        <x-poll.show.voting.legend name="yes" value="2"/>
                        <x-poll.show.voting.legend name="maybe" value="1"/>
                        <x-poll.show.voting.legend name="no" value="-1"/>
                    </div>
                </div>
                @if($loaded)
                    <form wire:submit.prevent="submitVote()">

                        <div class="accordion accordion-flush" id="accordionPoll">
                            {{-- Časové možnosti --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button p-4 fw-bold fs-4" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapseTimeOptions" aria-expanded="false"
                                            aria-controls="collapseTimeOptions">
                                        <i class="bi bi-calendar-event me-2"></i>
                                        <span>{{ __('pages/poll-show.voting.accordion.time_options') }}</span>
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

                                            @can('addOption', $poll)
                                                <div class="col-lg-6">
                                                    <div
                                                        class="card voting-card voting-card-0 voting-card-clickable text-center transition-all"
                                                        wire:click="openModal('modals.poll.add-new-time-option', {{ $poll->id }})">
                                                        <div
                                                            class="card-body add-option-card d-flex align-items-center justify-content-center gap-2 py-4">
                                                            <i class="bi bi-plus-circle-fill text-primary fs-4"></i>
                                                            <h5 class="card-title mb-0">Add new time option</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endcan

                                            @if(((count($poll->timeOptions) + (int)$poll->add_time_options) % 2) !== 0)
                                                <div class="col-lg-6 d-none d-lg-block">
                                                    <div class="card voting-card voting-card-0 text-center transition-all">
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
                                        <button class="accordion-button p-4 fw-bold fs-4"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                :data-bs-target="'#collapseQuestion' + questionIndex" aria-expanded="false"
                                                :aria-controls="'collapseQuestion' + questionIndex">
                                            <i class="bi bi-question-circle me-2"></i>
                                            <span x-text="question.text"></span>
                                            <span class="badge text-bg-dark ms-2" x
                                                  -text="question.options.length"></span>
                                        </button>
                                    </h2>
                                    <div :id="'collapseQuestion' + questionIndex" class="accordion-collapse collapse show">
                                        <div class="accordion-body p-0">
                                            <div class="row g-0">
                                                <template x-for="(option, optionIndex) in question.options">
                                                    <div class="col-lg-6">
                                                        <x-poll.voting.question-option-card :poll="$poll"/>
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
                                    {{ __('pages/poll-show.voting.buttons.submit_vote') }}
                                </x-ui.button>
                                <x-ui.spinner wire:loading wire:target="submitVote">
                                    {{ __('pages/poll-show.voting.buttons.form.loading') }}
                                </x-ui.spinner>

                                <x-ui.form.error-text error="form" />

                                {{-- Zobrazí se, pokud je hlasování úspěšné --}}
                                <span x-show="messages.success" class="text-success me-2">
                                <i class="bi bi-check-circle me-2"></i>
                                <span x-text="messages.success"></span>
                            </span>

                            </div>
                        </div>

                    </form>
                @else
                    <x-ui.spinner>
                        Loading...
                    </x-ui.spinner>
                @endif
            </div>
        @else
            <x-ui.alert type="warning">
                <x-ui.icon name="exclamation-triangle-fill"/>{{ __('pages/poll-show.voting.alert.poll_closed') }}
            </x-ui.alert>
        @endif
    </x-ui.card>

</div>

@push('scripts')
<script src="{{ asset('js/alpine/voting.js') }}"></script>
@endpush



