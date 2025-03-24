<div>
    <x-ui.modal.header>
        {{ __('ui/modals.choose_final_options.title') }}
    </x-ui.modal.header>
    <div class="modal-body">
        <p class="text-muted">
            {{ __('ui/modals.choose_final_options.description') }}
        </p>
        <form wire:submit.prevent='chooseFinalResults'>
            <div class="accordion" id="chooseFinalResultsAccordion">
                {{-- TimeOptions --}}
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button fs-3"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#time-results"
                                aria-expanded="true"
                                aria-controls="time-results">
                            <i class="bi bi-clock me-2"></i> {{ __('ui/modals.choose_final_options.accordion.poll_options') }}
                        </button>
                    </h2>
                    <div id="time-results" class="accordion-collapse collapse show">
                        <div class="accordion-body p-0">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                <tr>
                                    <th class="w-75 py-3">
                                        {{ __('ui/modals.choose_final_options.accordion.table_headers.option') }}</th>
                                    <th class="text-center py-3">
                                        {{ __('ui/modals.choose_final_options.accordion.table_headers.score') }}</th>
                                    <th class="text-center py-3">
                                        {{ __('ui/modals.choose_final_options.accordion.table_headers.select') }}</th>
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
                                            <input class="form-check-input" type="radio"
                                                   value="{{ $optionIndex }}" wire:model="selected.time_option"
                                                   name="timeOption" id="timeOption_{{ $option['id'] }}">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>

            @foreach ($questions as $questionIndex => $question)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button fs-3" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#question-{{ $questionIndex }}-results" aria-expanded="true"
                                    aria-controls="question-{{ $questionIndex }}-results">
                                <i class="bi bi-question-lg me-2"></i> {{ $question['text'] }}
                            </button>
                        </h2>
                        <div id="question-{{ $questionIndex }}-results" class="accordion-collapse collapse show">
                            <div class="accordion-body p-0">
                                <table class="table table-striped table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th class="w-75 py-3">
                                            {{ __('ui/modals.choose_final_options.accordion.table_headers.option') }}</th>
                                        <th class="text-center py-3">
                                            {{ __('ui/modals.choose_final_options.accordion.table_headers.score') }}</th>
                                        <th class="text-center py-3">
                                            {{ __('ui/modals.choose_final_options.accordion.table_headers.select') }}</th>
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
                            </div>
                        </div>
                    </div>
            @endforeach
            </div>
            <x-ui.button type="submit" class="btn btn-primary mt-3">
                {{ __('ui/modals.choose_final_options.buttons.insert_to_calendar') }}
            </x-ui.button>
        </form>
    </div>
</div>
