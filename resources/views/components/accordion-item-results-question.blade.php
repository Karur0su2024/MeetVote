@props([
    'questionIndex',
    'question',
    'selected'
])

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
