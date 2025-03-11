@props(['option', 'questionIndex', 'optionIndex'])

<li class="list-group-item d-flex justify-content-between align-items-center">
    <label for="questionOption_{{ $questionIndex }}_{{ $optionIndex }}"
        class="w-100 d-flex justify-content-between align-items-center mb-0">
        <span>{{ $option['content']['text'] }}</span>
        <span>{{ $option['score'] }}</span>
        <input class="form-check-input ms-2" type="radio" value="{{ $optionIndex }}"
            wire:model="selected.questions.{{ $questionIndex }}" name="question_{{ $questionIndex }}"
            id="questionOption_{{ $questionIndex }}_{{ $optionIndex }}">
    </label>
</li>
