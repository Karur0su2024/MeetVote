@php
    use Carbon\Carbon;
@endphp

<x-card bodyPadding="0">

    <x-slot:header>
        Voting
        <button class="btn btn-outline-secondary" wire:click='openResultsModal()'>Results ({{ count($poll->votes) }})
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




        <form wire:submit.prevent='submit'>

            {{-- Časové možnosti --}}
            <x-poll.show.voting.collapse-section id="timeOption">
                <x:slot:header>
                    <i class="bi bi-calendar"></i> Dates ({{ count($form->timeOptions) }})
                </x:slot:header>

                <div class="row g-0">
                    @foreach ($form->timeOptions as $optionIndex => $option)
                        <div class="col-lg-6">
                            <x-poll.show.voting.card class="voting-card-{{ $option['picked_preference'] }}">
                                <x-slot:content>
                                    <p class="mb-0 fw-bold">{{ Carbon::parse($option['date'])->format('F d, Y') }}
                                    </p>
                                    <p class="mb-0 text-muted d-flex align-items-center">
                                        {{ $option['content'] }}
                                        <i class="bi bi-exclamation-circle-fill ms-2 text-warning"></i>
                                    </p>
                                </x-slot:content>
                                <x-slot:score>{{ $option['score'] }}</x-slot:score>
                                <x-slot:button>
                                    <x-poll.show.preference-button :optionIndex="$optionIndex" :pickedPreference="$option['picked_preference']" />
                                </x-slot:button>
                            </x-poll.show.voting.card>
                        </div>
                    @endforeach

                    {{-- V případě, že možné přidat nové časové možnosti, zobrazí se tlačítko pro přidání --}}
                    @if ($poll->add_time_options)
                        <div class="col-lg-6">
                            <div class="card voting-card voting-card-clickable text-center" wire:click="openAddNewTimeOptionModal()">
                                <div class="card-body add-option-card d-flex align-items-center justify-content-center gap-2">
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
                                <x-poll.show.voting.card class="voting-card-{{ $option['picked_preference']*2 }}">
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
            <div class="p-3">
                <h3 class="mb-3">Add new vote</h3>
                <x-input id="name" model="form.user.name" type="text" mandatory="true">
                    Your name
                </x-input>
                <x-input id="email" model="form.user.email" type="email" mandatory="true">
                    Your e-mail
                </x-input>

                <div class="d-flex align-items-center gap-3 mt-3">
                    <button type="submit" class="btn btn-primary btn-lg me-1">Submit your vote</button>

                    <div class="d-flex align-items-center">

                        @if (session()->has('error'))
                            <span class="text-danger">{{ session('error') }}</span>
                        @else
                            <span class="text-dark" wire:loading>Saving...</span>
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
