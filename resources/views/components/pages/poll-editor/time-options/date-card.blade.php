<div class="card mb-3 shadow-sm"
     x-data="{ collapsed: false }">
    <div class="card-header d-flex justify-content-between align-items-center">
        <p class="m-0">
            <strong class="card-title m-0" x-text="moment(dateIndex).format('dddd, MMMM D, YYYY')"></strong>
            <x-badge class="ms-2">
                <span x-text="form.dates[dateIndex].length"></span>
            </x-badge>
        </p>

        <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-secondary" @click="collapsed = !collapsed">
                <i class="bi" :class="!collapsed ? 'bi-eye' : 'bi-eye-slash'"></i>
            </button>
            <button type="button" class="btn btn-sm btn-danger" @click="removeDate(dateIndex)">
                <i class="bi bi-trash"></i> Delete
            </button>
        </div>
    </div>
    <div class="card-body p-2"
         x-show="!collapsed">
        <template x-for="(option, optionIndex) in date" :key="optionIndex">
            <x-pages.poll-editor.time-options.date-options />
        </template>
        <span
            class="text-danger ms-2"
            x-show="messages.errors['form.dates.' + dateIndex]"
            x-text="messages.errors['form.dates.' + dateIndex]">
        </span>
        <div class="d-flex flex-wrap flex-md-nowrap align-items-center gap-2 mt-1">
            <x-ui.button color="outline-secondary" class="w-100 w-md-auto" @click="addTimeOption(dateIndex, 'time')">
                <i class="bi bi-clock me-1"></i>{{ __('pages/poll-editor.time_options.button.add_time_option') }}
            </x-ui.button>
            <x-ui.button color="outline-secondary" class="w-100 w-md-auto" @click="addTimeOption(dateIndex, 'text')">
                <i class="bi bi-text-paragraph me-1"></i>{{ __('pages/poll-editor.time_options.button.add_text_option') }}
            </x-ui.button>
        </div>


    </div>

</div>
