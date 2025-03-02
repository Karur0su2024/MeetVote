<div class="card mb-5">
    <div class="card-header">
        <h2>Voting</h2>
    </div>
    <div class="card-body text-start">
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
                            <select wire:change="changeTimeOptionPreference({{ $option['id'] }}, $event.target.value)"
                                class="form-select">
                                <option value="0" {{ $option['chosen_preference'] === 0 ? 'selected' : '' }}>No vote
                                </option>
                                <option value="2" {{ $option['chosen_preference'] === 2 ? 'selected' : '' }}>Yes</option>
                                <option value="1" {{ $option['chosen_preference'] === 1 ? 'selected' : '' }}>Maybe</option>
                                <option value="-1" {{ $option['chosen_preference'] === -1 ? 'selected' : '' }}>No</option>
                            </select>
                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>

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

        <button wire:click="saveVote()" class="btn btn-primary">Submit your vote</button>
    </div>


</div>
