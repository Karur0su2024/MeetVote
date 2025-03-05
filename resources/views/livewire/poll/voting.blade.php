@php
    use Carbon\Carbon;

@endphp

<div class="card mb-3 text-start">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h2>Voting</h2>
            <button class="btn btn-outline-secondary">Results ({{ count($poll->votes) }}) </button>
            {{-- Přidat otevření modalu s výsledky --}}

        </div>
    </div>
    <div class="card-body p-0">
        <div class="p-4 w-100">
            <div class="mx-auto w-75 d-flex justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <img class="icon-size" src="{{ asset('icons/yes.svg') }}" alt="Yes">
                    <p class="mb-0 fw-bold text-success">Yes (2)</p>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <img class="icon-size" src="{{ asset('icons/maybe.svg') }}" alt="Maybe">
                    <p class="mb-0 fw-bold text-warning">Maybe (1)</p>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <img class="icon-size" src="{{ asset('icons/no.svg') }}" alt="No">
                    <p class="mb-0 fw-bold text-danger">No (-1)</p>
                </div>
            </div>
        </div>


        <div>
            <div>
                <div class="w-100 p-3 bg-secondary text-light" data-bs-toggle="collapse" href="#dateOptions"
                    role="button" aria-expanded="true" aria-controls="dateOptions">
                    <h2><i class="bi bi-calendar"></i> Dates ({{ count($timeOptions) }})</h2>
                </div>
                <div class="collapse show" id="dateOptions">
                    <div class="row g-0">
                        @foreach ($timeOptions as $option)
                            <div class="col-lg-6">

                                <x-poll.show.option-card :option="$option" :preferences="$preferences" />
                            </div>
                        @endforeach
                        <div class="col-lg-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h4 class="card-title">Add new option</h4>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>


            @if (count($questions) != 0)
                @foreach ($questions as $question)
                    <div class="w-100 p-3 bg-secondary text-light" data-bs-toggle="collapse"
                        href="#question-{{ $question['id'] }}-options" role="button" aria-expanded="true"
                        aria-controls="question-{{ $question['id'] }}-options">
                        <h2><i class="bi bi-question-lg"></i> {{ $question['text'] }} ({{ count($question['options']) }})</h2>
                    </div>
                    <div class="collapse show row g-0" id="question-{{ $question['id'] }}-options">
                        @foreach ($question['options'] as $option)
                            <div class="col-lg-6">

                                {{-- Přidat karty pro zobrazení otázek --}}
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif


            <div class="p-3">
                <h3 class="mb-3">Add new vote</h3>
                <x-input id="name" model="userName" type="text" label="Your name" mandatory="true" />
                <x-input id="email" model="userEmail" type="email" label="Your e-mail" mandatory="true" />

                @error('noOptionChosen')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <button wire:click="saveVote()" class="btn btn-primary mt-3">Submit your vote</button>
            </div>

        </div>

    </div>


</div>
