<div
    class="p-2 mb-2 rounded border"
    :class="{ 'existing-option': option.id }">
    <div
        class="d-flex flex-wrap flex-md-nowrap align-items-between gap-2">
        {{-- Pole pro zadání začátku časového intervalu  --}}
        <template x-if="option.type === 'time'">
            <div class="d-flex flex-md-nowrap flex-wrap gap-2 w-100">
                <input type="time"
                       x-model="dates[dateIndex][optionIndex].content.start"
                       :id="'start_' + dateIndex + '_' + optionIndex"
                       class="form-control w-100 w-md-auto"
                       :disabled="option.score !== 0 || option.invalid"
                       :class="{ 'is-invalid': optionErrors['form.dates.' + dateIndex + '.' + [optionIndex] + '.content.end'] }">

                <input type="time"
                       x-model="dates[dateIndex][optionIndex].content.end"
                       :id="'end_' + dateIndex + '_' + optionIndex"
                       class="form-control w-100 w-md-auto"
                       :disabled="option.score !== 0 || option.invalid"
                       :class="{ 'is-invalid': optionErrors['form.dates.' + dateIndex + '.' + [optionIndex] + '.content.end'] }">
            </div>
        </template>
        {{-- Zobrazení textového pole pro zadání textu --}}
        <template x-if="option.type === 'text'">
            <input type="text"
                   x-model="dates[dateIndex][optionIndex].content.text"
                   :id="'text_' + dateIndex + '_' + optionIndex" class="form-control"
                   :placeholder="'Option ' + (optionIndex + 1)"
                   :disabled="option.score !== 0 || option.invalid"
                   :class="{ 'is-invalid': optionErrors['form.dates.' + dateIndex + '.' + [optionIndex] + '.content.text'] }">
        </template>

        {{-- Tlačítko pro odstranění časové možnosti --}}
        <x-ui.button @click="removeOption(dateIndex, optionIndex)"
                     color="danger"
                     ::class="{ 'disabled': Object.keys(dates).length === 1 && dates[dateIndex].length === 1 }">
            <i class="bi" :class="{
            'bi-calendar-x-fill': option.invalid,
            'bi-trash': option.score === 0 && !option.invalid,
                            'bi-exclamation-triangle': option.score !== 0,

                          }">
                <span class="d-md-none ms-1">{{ __('pages/poll-editor.time_options.button.delete') }}</span>
            </i>
        </x-ui.button>


    </div>


</div>
