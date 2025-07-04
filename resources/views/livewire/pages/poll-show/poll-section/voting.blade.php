{{-- https://github.com/livewire/livewire/issues/830 --}}


@push('scripts')
    <script src="{{ asset('js/alpine/voting.js') }}" xmlns="http://www.w3.org/1999/html"></script>
@endpush

<div x-data="votingForm">
    <p class="tw-text-base-600 tw-font-light mb-3">
        {{ __('pages/poll-show.voting.description') }}
    </p>
    <div>
<div class="tw-card tw-border tw-bg-base-400 tw-flex tw-flex-row tw-p-2 tw-gap-3 tw-items-center tw-shadow-sm">
    <div class="tw-flex tw-flex-row tw-gap-3">
        <x-pages.poll-show.poll.voting.legend name="yes" value="2"/>
        <x-pages.poll-show.poll.voting.legend name="maybe" value="1"/>
        <x-pages.poll-show.poll.voting.legend name="no" value="-1"/>
    </div>
</div>

        @if($loaded)
            <form wire:submit.prevent="submitVote()">
                <div>
                    <x-pages.poll-show.poll.section-card title="Time">
                        <x-slot:title>
                            <span class="tw-text-lg tw-font-semibold me-2">{{ __('pages/poll-show.voting.sections.time_options.title') }}</span>
                            <x-ui.tooltip>
                                {{ __('pages/poll-show.voting.sections.time_options.tooltip') }}
                            </x-ui.tooltip>
                        </x-slot:title>
                        <x-slot:title-right>
                            @can('sync', Auth::user())
                                <x-ui.saving wire:loading wire:target="checkAvailability">
                                    {{ __('pages/poll-show.voting.buttons.check_availability.loading') }}
                                </x-ui.saving>
                            <div class="tw-tooltip" data-tip="{{ __('pages/poll-show.voting.buttons.check_availability.tooltip') }}">
                                <button class="tw-btn tw-btn-primary tw-btn-sm" wire:click="checkAvailability">
                                    <i class="bi bi-calendar-check me-1"></i>
                                    {{ __('pages/poll-show.voting.buttons.check_availability.label') }}
                                </button>

                            </div>
                            @endcan
                        </x-slot:title-right>
                        <x-slot:content>

                            <template x-for="(timeOption, optionIndex) in form.timeOptions">

                                <div class="col-md-12 col-lg-6">
                                    <x-pages.poll-show.poll.option-card
                                        class="btn-outline-vote"
                                        ::class="{ ['voting-card-' + timeOption.picked_preference]: !timeOption.invalid, 'voting-card-invalid': timeOption.invalid }"
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
                                            @can('sync', Auth::user())
                                                <div x-show="timeOption.availability !== undefined">
                                                    <x-ui.pill
                                                        ::class="{ 'text-bg-success' : timeOption.availability, 'text-bg-danger' : !timeOption.availability }">
                                                        <i class="bi me-1"
                                                           :class="{ 'bi-check-circle': timeOption.availability, 'bi-x-circle-fill': !timeOption.availability }"></i>
                                                        <span
                                                            x-text="timeOption.availability ? 'Available' : 'Not available'">
                                                            </span>
                                                    </x-ui.pill>
                                                </div>

                                            @endcan

                                        </x-slot:bottom>

                                    </x-pages.poll-show.poll.option-card>
                                </div>
                            </template>


                            @can('addNewOption', $poll)
                                <div class="col-md-12 col-lg-6">
                                    <div
                                        class="card p-4 h-100 d-flex justify-content-center align-items-center voting-card-clickable"
                                        wire:click="openAddNewTimeModal({{ $poll->id }})">
                                            <span class="text-muted fw-bold">
                                                {{ __('pages/poll-show.voting.buttons.add_time_option') }}
                                            </span>

                                    </div>
                                </div>

                            @endcan


                        </x-slot:content>
                    </x-pages.poll-show.poll.section-card>


                    @if(!empty($form->questions))

                            <template x-for="(question, questionIndex) in form.questions">
                                <x-pages.poll-show.poll.section-card>
                                    <x-slot:title>
                                        <span x-text="question.text"></span>
                                    </x-slot:title>
                                    <x-slot:title-right>
                                        <x-ui.badge color="secondary">Custom question</x-ui.badge>
                                    </x-slot:title-right>
                                    <x-slot:content>
                                        <template x-for="(option, optionIndex) in question.options">

                                            <div class="col-md-12 col-lg-6">
                                                <x-pages.poll-show.poll.option-card
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
                                                </x-pages.poll-show.poll.option-card>
                                            </div>
                                        </template>
                                    </x-slot:content>
                                </x-pages.poll-show.poll.section-card>
                            </template>
                    @endif




                    {{-- Formulář pro vyplnění jména a e-mailu --}}
                    <div class="mt-4">
                        @guest
                            <x-pages.poll-show.poll.voting.form :poll="$poll"/>

                        @endguest

                        <x-ui.form.tw-textbox x-model="form.notes"
                                           placeholder="{{ __('pages/poll-show.voting.form.notes.placeholder') }}">
                            {{ __('pages/poll-show.voting.form.notes.label') }}
                        </x-ui.form.tw-textbox>

                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <x-ui.tw-button type="submit" >
                                {{ __('pages/poll-show.voting.buttons.submit_vote') }}
                            </x-ui.tw-button>
                            <x-ui.spinner wire:loading wire:target="submitVote">
                                {{ __('pages/poll-show.voting.form.loading') }}
                            </x-ui.spinner>
                            <x-ui.form.message type="flash"
                                form-message="error"
                                color="danger"/>
                            <x-ui.form.message
                                               form-message="form.error"
                                               color="danger"/>
                        </div>
                    </div>

                </div>

            </form>
        @else
            <x-ui.spinner>
                {{ __('pages/poll-show.voting.form.loading') }}
            </x-ui.spinner>
        @endif
    </div>


</div>

