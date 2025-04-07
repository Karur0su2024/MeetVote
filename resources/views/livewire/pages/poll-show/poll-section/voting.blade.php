@php
    use Carbon\Carbon;
@endphp

{{-- https://github.com/livewire/livewire/issues/830 --}}


@push('scripts')
    <script src="{{ asset('js/alpine/voting.js') }}" xmlns="http://www.w3.org/1999/html"></script>
@endpush

<div x-data="getVotingData">
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
                    <div class="mt-4 border-top py-2 px-4">
                        <x-pages.poll-show.poll.results.results-section-card title="Time options">
                            <x-slot:title-right>
                                <x-ui.button>
                                    Check availability
                                </x-ui.button>
                            </x-slot:title-right>
                            <x-slot:content>
                                <template x-for="(timeOption, optionIndex) in form.timeOptions">

                                    <div class="col-md-12 col-lg-6">
                                        <x-pages.poll-show.poll.results.option-card
                                            class="btn-outline-vote"
                                            ::class="'voting-card-' + timeOption.picked_preference"
                                            @click="setPreference('timeOption', null, optionIndex, getNextPreference('timeOption', timeOption.picked_preference))">
                                            <x-slot:text>
                                                <span x-text="timeOption.date_formatted"></span>
                                            </x-slot:text>
                                            <x-slot:subtext>
                                                <span x-text="timeOption.full_content"></span>
                                            </x-slot:subtext>
                                            <x-slot:right>
                                                <img class="p-1"
                                                     :src="'{{ asset('icons/') }}/' + timeOption.picked_preference + '.svg'"
                                                     :alt="timeOption.picked_preference"/>
                                            </x-slot:right>
                                            <x-slot:bottom>
                                                <x-ui.badge>
                                                    Available
                                                </x-ui.badge>
                                            </x-slot:bottom>

                                        </x-pages.poll-show.poll.results.option-card>
                                    </div>
                                </template>
                            </x-slot:content>
                        </x-pages.poll-show.poll.results.results-section-card>

                        <div class="mt-3">
                            <h3>Additional questions</h3>

                            <template x-for="(question, questionIndex) in form.questions">
                                <x-pages.poll-show.poll.results.results-section-card>
                                    <x-slot:title>
                                        <span x-text="question.text"></span>
                                    </x-slot:title>
                                    <x-slot:content>
                                        <template x-for="(option, optionIndex) in question.options">

                                            <div class="col-md-12 col-lg-6">
                                                <x-pages.poll-show.poll.results.option-card
                                                    class="btn-outline-vote"
                                                    ::class="'voting-card-' + option.picked_preference"
                                                    @click="setPreference('question', questionIndex, optionIndex, getNextPreference('question', option.picked_preference))">
                                                    <x-slot:text>
                                                        <span x-text="option.text"></span>
                                                    </x-slot:text>
                                                    <x-slot:right>
                                                        <img class="p-1"
                                                             :src="'{{ asset('icons/') }}/' + option.picked_preference + '.svg'"
                                                             :alt="option.picked_preference"/>
                                                    </x-slot:right>
                                                </x-pages.poll-show.poll.results.option-card>
                                            </div>
                                        </template>
                                    </x-slot:content>
                                </x-pages.poll-show.poll.results.results-section-card>
                            </template>
                        </div>

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


                            <x-ui.form.message
                                form-message="error"
                                color="danger"/>
                            <x-ui.form.message
                                form-message="success"
                                type="flash"
                                color="success"/>


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


</div>>


