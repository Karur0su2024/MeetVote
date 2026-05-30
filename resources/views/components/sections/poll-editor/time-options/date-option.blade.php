<div
    class="mb-2"
    :class="{ 'existing-option': option.id }">
    <div
        class="flex flex-md-nowrap gap-2 flex-nowrap">
        {{-- Pole pro zadání začátku časového intervalu  --}}
        <template x-if="option.type === 'time'">
            <div class="flex flex-row gap-2 w-full grow">
                <input type="time"
                       x-model="dates[dateIndex][optionIndex].content.start"
                       :id="'start_' + dateIndex + '_' + optionIndex"
                       class="input input-sm grow"
                       :disabled="option.score !== 0 || option.invalid"
                       :class="{ 'is-invalid': optionErrors['form.dates.' + dateIndex + '.' + [optionIndex] + '.content.end'] }">

                <input type="time"
                       x-model="dates[dateIndex][optionIndex].content.end"
                       :id="'end_' + dateIndex + '_' + optionIndex"
                       class="input input-sm grow"
                       :disabled="option.score !== 0 || option.invalid"
                       :class="{ 'is-invalid': optionErrors['form.dates.' + dateIndex + '.' + [optionIndex] + '.content.end'] }">
            </div>
        </template>
        {{-- Zobrazení textového pole pro zadání textu --}}
        <template x-if="option.type === 'text'">
            <div class="flex flex-row gap-2 w-100 grow">
            <input type="text"
                   x-model="dates[dateIndex][optionIndex].content.text"
                   :id="'text_' + dateIndex + '_' + optionIndex" class="input input-sm grow"
                   :placeholder="'Option ' + (optionIndex + 1)"
                   :disabled="option.score !== 0 || option.invalid"
                   :class="{ 'is-invalid': optionErrors['form.dates.' + dateIndex + '.' + [optionIndex] + '.content.text'] }">
            </div>
        </template>

        {{-- Tlačítko pro odstranění časové možnosti --}}
        <button class="btn btn-sm btn-outline btn-error"
                @click="removeOption(dateIndex, optionIndex)"
                ::class="{ 'disabled': Object.keys(dates).length === 1 && dates[dateIndex].length === 1 }">
            <i class="bi" :class="{
            'bi-calendar-x-fill': option.invalid,
            'bi-trash': option.score === 0 && !option.invalid,
                            'bi-exclamation-triangle': option.score !== 0
                          }"></i>
            <span class="md:hidden ms-1">{{ __('pages/poll-editor.time_options.button.delete') }}</span>
        </button>


    </div>


</div>
