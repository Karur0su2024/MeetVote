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
                    <h2>Dates</h2>
                </div>
                <div class="collapse show p-2" id="dateOptions">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Duration</th>
                                <th>Preference</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($timeOptions as $option)
                                <tr>
                                    <td>{{ $option['date'] . ' ' . $option['text'] }}</td>
                                    <td>{{ $option['minutes'] }} min</td>
                                    <td>

                                        <!-- Výběr preference časové možnosti -->
                                        <select
                                            wire:change="changeTimeOptionPreference({{ $option['id'] }}, $event.target.value)"
                                            class="form-select">
                                            <option value="0"
                                                {{ $option['chosen_preference'] === 0 ? 'selected' : '' }}>No
                                                vote
                                            </option>
                                            <option value="2"
                                                {{ $option['chosen_preference'] === 2 ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                            <option value="1"
                                                {{ $option['chosen_preference'] === 1 ? 'selected' : '' }}>
                                                Maybe
                                            </option>
                                            <option value="-1"
                                                {{ $option['chosen_preference'] === -1 ? 'selected' : '' }}>
                                                No
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>

            @if (count($questions) == 0)
                <p>No questions</p>
            @else
                @foreach ($questions as $question)
                    <div class="w-100 p-3 bg-secondary text-light" data-bs-toggle="collapse"
                        href="#question-{{ $question['id'] }}-options" role="button" aria-expanded="true"
                        aria-controls="question-{{ $question['id'] }}-options">
                        <h2>{{ $question['text'] }}</h2>
                    </div>
                    <div class="collapse show p-2" id="question-{{ $question['id'] }}-options">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Option</th>
                                    <th>Preference</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($question['options'] as $option)
                                    <tr>
                                        <td>{{ $option['text'] }}</td>
                                        <td>
                                            <select
                                                wire:change="changeQuestionOptionPreference({{ $question['id'] }}, {{ $option['id'] }}, $event.target.value,)"
                                                class="form-select">
                                                <option value="0"
                                                    {{ $option['chosen_preference'] === 0 ? 'selected' : '' }}>No vote
                                                </option>
                                                <option value="2"
                                                    {{ $option['chosen_preference'] === 2 ? 'selected' : '' }}>Yes
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @endif


            <div class="p-2">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" wire:model="userName" class="form-control">
                    @error('userName')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" wire:model="userEmail" class="form-control">
                    @error('userEmail')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                @error('noOptionChosen')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <button wire:click="saveVote()" class="btn btn-primary mt-3">Submit your vote</button>
            </div>

        </div>

    </div>


</div>
