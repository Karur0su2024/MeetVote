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
            <x-ui.card title="Time">
                <x-ui.text.title-w-icon>
                    <x-slot:icon>
                        <x-mary-icon name="o-clock"/>
                    </x-slot:icon>
                    <x-slot:title>
                        {{ __('pages/poll-show.voting.sections.time_options.title') }}
                    </x-slot:title>
                    <x-slot:subtitle>
                        {{ __('pages/poll-show.voting.sections.time_options.tooltip') }}
                    </x-slot:subtitle>
                </x-ui.text.title-w-icon>
                <div class="grid grid-cols-2 gap-2">


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
                </div>
            </x-ui.card>


            @if(!empty($form->questions))

                <template x-for="(question, questionIndex) in form.questions">
                    <x-ui.card>
                        <x-ui.text.title-w-icon>
                            <x-slot:icon>
                                <x-mary-icon name="o-question-mark-circle"/>
                            </x-slot:icon>
                            <x-slot:title>
                                <span x-text="question.text"></span>
                            </x-slot:title>
                        </x-ui.text.title-w-icon>
                        <div class="grid grid-cols-2 gap-2">
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
                        </div>
                    </x-ui.card>
                </template>
            @endif




            {{-- Formulář pro vyplnění jména a e-mailu --}}
            <div class="card bg-base-100 p-5 shadow-sm">
                @guest
                    <x-pages.poll-show.poll.voting.form :poll="$poll"/>
                @endguest


                <x-mary-textarea label="{{ __('pages/poll-show.voting.form.notes.label') }}"
                                 x-model="form.notes"
                                 placeholder="{{ __('pages/poll-show.voting.form.notes.placeholder') }}"/>

                <div class="flex flex-nowrap items-center gap-3 mt-3">
                    <x-mary-button label="{{ __('pages/poll-show.voting.buttons.submit_vote') }}"
                                   class="btn-primary"
                                   spinner
                                   type="submit"
                    />
                </div>
            </div>


        </form>
    @else
        <span class="loading loading-spinner"></span>{{ __('pages/poll-show.voting.form.loading') }}
    @endif


</div>
