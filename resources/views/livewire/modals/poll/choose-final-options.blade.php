<div>
    <div class="modal-header">
        <h5 class="modal-title">Close Poll</h5>
        <button type="button" class="btn-close text-white" wire:click="$dispatch('hideModal')" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form wire:submit.prevent='chooseFinalResults'>
            <x-collapse-section id="time_option_results">
                <x:slot:header>
                    <i class="bi bi-question-lg"></i> Dates
                </x:slot:header>

                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="w-75">Option</th>
                            <th class="text-center">Score</th>
                            <th class="text-center">Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($timeOptions as $optionIndex => $option)
                            <tr class="{{ $optionIndex == $selected['time_option'] ? 'table-active' : '' }}">
                                <td class="w-75">
                                    <label for="timeOption_{{ $option['id'] }}"
                                        class="w-100 d-flex align-items-center mb-0">
                                        {{ Carbon\Carbon::parse($option['date'])->format('F d, Y') }}
                                        {{ $option['content']['full'] }}
                                    </label>
                                </td>
                                <td class="text-center align-middle">
                                    <label for="timeOption_{{ $option['id'] }}"
                                        class="d-flex justify-content-center align-items-center w-100 mb-0">
                                        {{ $option['score'] }}
                                    </label>
                                </td>
                                <td class="text-center align-middle">
                                    <input class="form-check-input" type="radio" value="{{ $optionIndex }}"
                                        wire:model="selected.time_option" name="timeOption"
                                        id="timeOption_{{ $option['id'] }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </x-collapse-section>


            @foreach ($questions as $questionIndex => $question)
                <x-collapse-section id="question_{{ $questionIndex }}_results">
                    <x:slot:header>
                        <i class="bi bi-question-lg"></i>
                        {{ $question['text'] }}
                    </x:slot:header>

                    <table class="table table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="w-75">Option</th>
                                <th class="text-center">Score</th>
                                <th class="text-center">Select</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($question['options'] as $optionIndex => $option)
                            <tr class="{{ $optionIndex == $selected['time_option'] ? 'table-active' : '' }}">
                                <td class="w-75 align-middle">
                                    <label for="question_{{ $questionIndex }}_{{ $optionIndex }}"
                                        class="w-100 d-flex align-items-center mb-0">
                                        {{ $option['text'] }}
                                    </label>
                                </td>
                                <td class="text-center align-middle">
                                    <label for="question_{{ $questionIndex }}_{{ $optionIndex }}"
                                        class="w-100 d-flex justify-content-center align-items-center mb-0">
                                        {{ $option['score'] }}
                                    </label>
                                </td>
                                <td class="text-center align-middle">
                                    <input class="form-check-input mx-auto" type="radio"
                                        value="{{ $optionIndex }}"
                                        wire:model="selected.questions.{{ $questionIndex }}"
                                        name="question_{{ $questionIndex }}"
                                        id="question_{{ $questionIndex }}_{{ $optionIndex }}">
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </x-collapse-section>
            @endforeach

            <button type="submit" class="btn btn-primary mt-3">Insert to Calendar</button>


        </form>
    </div>
</div>
