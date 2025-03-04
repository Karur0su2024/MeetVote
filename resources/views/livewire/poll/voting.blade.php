<div>
    <div class="card mb-5 text-start">
        <div class="card-header">
            <h2>Voting</h2>
        </div>
        <div class="card-body p-0">
            <div class="p-2 ">
                Legend will be here
            </div>
    
    
            <div>
                <div>
                    <div class="w-100 p-3 bg-secondary text-light" data-bs-toggle="collapse" href="#dateOptions" role="button"
                        aria-expanded="true" aria-controls="dateOptions">
                        <h2>D - Dates</h2>
                    </div>
                    <div class="collapse show" id="dateOptions">
                        <div class="row g-0">
                            @foreach ($timeOptions as $option)
                                <div class="col-lg-6">
                                    <div class="card p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            {{-- Obsah možnosti --}}
                                            <div>
                                                <p class="mb-0 fw-bold">
                                                    {{ Carbon\Carbon::parse($option['date'])->isoFormat('dddd') }},
                                                    {{ Carbon\Carbon::parse($option['date'])->format('F d, Y') }}
                                                </p>
                                                <p class="mb-0 fw-bold">
                                                    @if (!empty($option['start']))
                                                        {{ Carbon\Carbon::parse($option['start'])->format('H:i') }} -
                                                        {{ Carbon\Carbon::parse($option['start'])->addMinutes($option['minutes'])->format('H:i') }}
                                                    @else
                                                        {{ $option['text'] }}
                                                    @endif
                                                </p>
                                            </div>
                
                                            {{-- Zobrazení hlasů --}}
                                            <div>
                                                @foreach ($option['votes'] as $voteName => $vote)
                                                    <p class="mb-0">{{ $voteName }} - {{ $vote }}</p>
                                                @endforeach
                                            </div>
                
                                            {{-- Výběr preference časové možnosti --}}
                                            <div>
                                                <select wire:change="changeTimeOptionPreference({{ $option['id'] }}, $event.target.value)"
                                                    class="form-select">
                                                    <option value="0" {{ $option['chosen_preference'] === 0 ? 'selected' : '' }}>No vote</option>
                                                    <option value="2" {{ $option['chosen_preference'] === 2 ? 'selected' : '' }}>Yes</option>
                                                    <option value="1" {{ $option['chosen_preference'] === 1 ? 'selected' : '' }}>Maybe</option>
                                                    <option value="-1" {{ $option['chosen_preference'] === -1 ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
    
                @if (count($questions) == 0)
                    <p>No questions</p>
                @else
                    @foreach ($questions as $question)
                        <div class="w-100 p-3 bg-secondary text-light" data-bs-toggle="collapse"
                            href="#question-{{ $question['id'] }}-options" role="button" aria-expanded="true"
                            aria-controls="question-{{ $question['id'] }}-options">
                            <h2>? - {{ $question['text'] }}</h2>
                        </div>
                        <div class="collapse show row g-0" id="question-{{ $question['id'] }}-options">
    
                            @foreach ($question['options'] as $option)
                                <div class="col-lg-6">
                                    <div class="card p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            {{-- Obsah možnosti --}}
                                            <div>
                                                <p class="mb-0 fw-bold">{{ $option['text'] }}</p>
                                            </div>
                                            <div>
                                                @foreach ($option['votes'] as $voteName => $vote)
                                                    <p class="mb-0">{{ $voteName }} - {{ $vote }}</p>
                                                @endforeach
    
    
                                            </div>
    
                                            <!-- Výběr preference časové možnosti -->
                                            <div>
                                                <select
                                                    wire:change="changeQuestionOptionPreference({{ $question['id'] }}, {{ $option['id'] }}, $event.target.value,)"
                                                    class="form-select">
                                                    <option value="0"
                                                        {{ $option['chosen_preference'] === 0 ? 'selected' : '' }}>No
                                                        vote
                                                    </option>
                                                    <option value="2"
                                                        {{ $option['chosen_preference'] === 2 ? 'selected' : '' }}>
                                                        Yes
                                                    </option>
    
                                                </select>
                                            </div>
    
                                        </div>
    
                                    </div>
                                </div>
                            @endforeach
    
                        </div>
                    @endforeach
                @endif
    
    
                <div class="p-2">
                    <x-input id="name" model="userName" type="text" label="Your name" mandatory="true"  />
                    <x-input id="email" model="userEmail" type="email" label="Your e-mail" mandatory="true"  />
    
                    @error('noOptionChosen')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
    
                    <button wire:click="saveVote()" class="btn btn-primary mt-3">Submit your vote</button>
                </div>
    
            </div>
    
        </div>
    
    
    </div>
    

</div>
