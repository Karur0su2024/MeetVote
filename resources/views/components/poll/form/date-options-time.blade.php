<div class="p-2 mb-2 rounded border" x-show="option.type == 'time'">
    <!-- Zobrazení časového intervalu -->
    <div class="d-flex flex-wrap flex-md-nowrap align-items-between gap-2">
        {{-- Pole pro zadání začátku časového intervalu  --}}
        <input type="time"
               x-model="form.dates[dateIndex][optionIndex].content.start"
               :id="'start_' + dateIndex + '_' + optionIndex"
               class="form-control w-100 w-md-auto"
               :class="{ 'is-invalid': messages.errors['form.dates.' + dateIndex + '.' + [optionIndex] + '.content.start'] }"
        >

        <input type="time"
               x-model="form.dates[dateIndex][optionIndex].content.end"
               :id="'end_' + dateIndex + '_' + optionIndex"
               class="form-control w-100 w-md-auto"
               :class="{ 'is-invalid': messages.errors['form.dates.' + dateIndex + '.' + [optionIndex] + '.content.end'] }"
        >


        {{-- Tlačítko pro odstranění časové možnosti --}}
        <button type="button" @click="removeTimeOption(dateIndex, optionIndex)"
                class="btn btn-danger mx-auto">
            <i class="bi bi-trash"></i><span
                class="d-md-none ms-1">Delete</span>
        </button>
    </div>


</div>
