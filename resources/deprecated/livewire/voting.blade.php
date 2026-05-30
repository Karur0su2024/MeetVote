{{-- https://github.com/livewire/livewire/issues/830 --}}


@push('scripts')
    <script src="{{ asset('js/alpine/voting.js') }}" xmlns="http://www.w3.org/1999/html"></script>
@endpush

<div x-data="votingForm">
    {{--    <p class="font-light mb-3">--}}
    {{--        {{ __('pages/poll-show.voting.description') }}--}}
    {{--    </p>--}}
    @if($loaded)
        <form wire:submit.prevent="submitVote()" class="flex flex-col gap-1">
            <x-pages.poll-show.poll.section-card title="Time">
                <x-ui.text.title-w-icon>
                    <x-slot:icon>
                        <x-mary-icon name="o-clock" />
                    </x-slot:icon>
                    <x-slot:title>
                        {{ __('pages/poll-show.voting.sections.time_options.title') }}
                    </x-slot:title>
                </x-ui.text.title-w-icon>

                <x-slot:title>
                    <x-ui.text.title-w-icon>
                        <x-slot:icon>
                            <x-mary-icon name="o-clock" />
                        </x-slot:icon>
                        <x-slot:title>
                            {{ __('pages/poll-show.voting.sections.time_options.title') }}
                        </x-slot:title>
                        <x-slot:subtitle>
                            {{ __('pages/poll-show.voting.sections.time_options.tooltip') }}
                        </x-slot:subtitle>
                    </x-ui.text.title-w-icon>
                </x-slot:title>
                <x-slot:title-right>
                    {{--                            @can('sync', Auth::user())
                                                    <x-ui.saving wire:loading wire:target="checkAvailability">
                                                        {{ __('pages/poll-show.voting.buttons.check_availability.loading') }}
                                                    </x-ui.saving>
                                                    <div class="tooltip"
                                                         data-tip="{{ __('pages/poll-show.voting.buttons.check_availability.tooltip') }}">
                                                        <button class="btn btn-primary btn-sm" wire:click="checkAvailability">
                                                            <i class="bi bi-calendar-check me-1"></i>
                                                            {{ __('pages/poll-show.voting.buttons.check_availability.label') }}
                                                        </button>

                                                    </div>
                                                @endcan--}}
                </x-slot:title-right>
                <x-slot:content>

                    <template x-for="(timeOption, optionIndex) in form.timeOptions">
                        <x-pages.poll-show.poll.option-card
                            class="btn-outline-vote text-base-content"
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
                                {{-- @can('sync', Auth::user())
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

                                 @endcan--}}

                            </x-slot:bottom>

                        </x-pages.poll-show.poll.option-card>
                    </template>


                    {{--@can('addNewOption', $poll)
                        <div
                            class="card text-base-content p-4 h-100 d-flex justify-content-center align-items-center voting-card-clickable border border-indigo-400"
                            wire:click="openAddNewTimeModal({{ $poll->id }})">
                                    <span class="fw-bold">
                                        {{ __('pages/poll-show.voting.buttons.add_time_option') }}
                                    </span>

                        </div>

                    @endcan--}}


                </x-slot:content>
            </x-pages.poll-show.poll.section-card>


            @if(!empty($form->questions))

                <template x-for="(question, questionIndex) in form.questions">
                    <x-pages.poll-show.poll.section-card>
                        <x-slot:title>
                            <span x-text="question.text"></span>
                        </x-slot:title>
                        <x-slot:title-right>
                            <div class="badge badge-secondary">
                                Custom question
                            </div>
                        </x-slot:title-right>
                        <x-slot:content>
                            <template x-for="(option, optionIndex) in question.options">

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
                            </template>
                        </x-slot:content>
                    </x-pages.poll-show.poll.section-card>
                </template>
            @endif




            {{-- Formulář pro vyplnění jména a e-mailu --}}
            <div class="card bg-base-100 p-5 shadow-sm">
                @guest
                    <x-pages.poll-show.poll.voting.form :poll="$poll"/>
                @endguest

                <x-ui.form.tw-textbox x-model="form.notes"
                                      placeholder="{{ __('pages/poll-show.voting.form.notes.placeholder') }}">
                    {{ __('pages/poll-show.voting.form.notes.label') }}
                </x-ui.form.tw-textbox>

                <div class="flex flex-nowrap items-center gap-3 mt-3">
                    <x-ui.tw-button type="submit">
                        {{ __('pages/poll-show.voting.buttons.submit_vote') }}
                    </x-ui.tw-button>
                    <div wire:loading
                         wire:target="submitVote">
                        <span class="loading loading-spinner"></span>
                        {{ __('pages/poll-show.voting.form.loading') }}
                    </div>

                    {{-- <x-ui.form.message type="flash"
                                        form-message="error"
                                        color="danger"/>
                     <x-ui.form.message
                         form-message="form.error"
                         color="danger"/>--}}
                </div>
            </div>


        </form>
    @else
        <span class="loading loading-spinner"></span>{{ __('pages/poll-show.voting.form.loading') }}
    @endif


</div>
