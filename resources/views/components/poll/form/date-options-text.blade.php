<!-- Zobrazení textové možnosti -->
<div class="p-2 mb-2 rounded border" x-show="option.type === 'text'">
    <div class="d-flex align-items-center gap-2">
        <!-- Pole pro zadání textové možnosti -->
        <input type="text" x-model="form.dates[dateIndex][optionIndex].content.text"
               :id="'text_' + dateIndex + '_' + optionIndex" class="form-control"
               :placeholder="'Option ' + (optionIndex + 1)"
               :class="{ 'is-invalid': messages.errors['form.dates.' + dateIndex + '.' + [optionIndex] + '.content.text'] }"
        >


        <!-- Tlačítko pro odstranění textové možnosti -->
        <button type="button" @click="removeTimeOption(dateIndex, optionIndex)" class="btn btn-danger">
            <i class="bi bi-trash"></i>
        </button>
    </div>
</div>
