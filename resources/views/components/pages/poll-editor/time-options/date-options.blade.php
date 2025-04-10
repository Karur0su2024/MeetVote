<div
    class="p-2 mb-2 rounded border"
    :class="{ 'bg-warning': option.id }">
    <!-- Zobrazení časového intervalu -->
    <div
        class="d-flex flex-wrap flex-md-nowrap align-items-between gap-2">
        {{-- Pole pro zadání začátku časového intervalu  --}}

        <template x-if="option.type === 'time'">
            <div class="d-flex flex-md-nowrap flex-wrap gap-2 w-100">
                <input type="time"
                       x-model="form.dates[dateIndex][optionIndex].content.start"
                       :id="'start_' + dateIndex + '_' + optionIndex"
                       class="form-control w-100 w-md-auto"
                       :class="{ 'is-invalid': messages.errors['form.dates.' + dateIndex + '.' + [optionIndex] + '.content.start'] }">

                <input type="time"
                       x-model="form.dates[dateIndex][optionIndex].content.end"
                       :id="'end_' + dateIndex + '_' + optionIndex"
                       class="form-control w-100 w-md-auto"
                       :class="{ 'is-invalid': messages.errors['form.dates.' + dateIndex + '.' + [optionIndex] + '.content.end'] }">
            </div>
        </template>
        <template x-if="option.type === 'text'">
            <input type="text"
                   x-model="form.dates[dateIndex][optionIndex].content.text"
                   :id="'text_' + dateIndex + '_' + optionIndex" class="form-control"
                   :placeholder="'Option ' + (optionIndex + 1)"
                   :class="{ 'is-invalid': messages.errors['form.dates.' + dateIndex + '.' + [optionIndex] + '.content.text'] }">
        </template>


        {{-- Tlačítko pro odstranění časové možnosti --}}
        <x-ui.button @click="removeTimeOption(dateIndex, optionIndex)"
                     color="danger"
                     ::class="{ 'disabled': form.dates[dateIndex].length === 1 }">
            <i :class="{ 'bi bi-exclamation-triangle': form.dates[dateIndex][optionIndex].score > 0,
                         'bi bi-trash': !form.dates[dateIndex][optionIndex].score }">
                <span class="d-md-none ms-1">{{ __('pages/poll-editor.time_options.button.delete') }}</span>
            </i>
        </x-ui.button>


    </div>


</div>
