<div class="card mb-3 shadow-sm"
     x-data="{ collapsed: false }">
    <div class="card-header d-flex justify-content-between align-items-center">
        <p class="m-0">
            <strong class="card-title m-0"
                    x-text="moment(dateIndex).format('dddd, MMMM D, YYYY')"></strong>
            <x-ui.badge class="ms-2">
                <span x-text="dates[dateIndex].length"></span>
            </x-ui.badge>
        </p>

        {{--Tlačítka pro správu dne--}}
        <div class="d-flex gap-2">
            <x-ui.button color="outline-secondary"
                         size="sm"
                         @click="collapsed = !collapsed">
                <i class="bi" :class="!collapsed ? 'bi-eye' : 'bi-eye-slash'"></i>
            </x-ui.button>

            <x-ui.button color="danger"
                         size="sm"
                         @click="removeDate(dateIndex)">
                <i class="bi bi-trash"></i>
                <span class="d-md-inline d-none">
                    {{ __('pages/poll-editor.time_options.button.delete') }}
                </span>



            </x-ui.button>
        </div>
    </div>
    <div class="card-body p-2"
         x-show="!collapsed"
         x-collapse>
        <template x-for="(option, optionIndex) in date" :key="optionIndex">
            <x-pages.poll-editor.time-options.date-option/>
        </template>
        <span
            class="text-danger ms-2"
            x-show="messages.errors['form.dates.' + dateIndex]"
            x-text="messages.errors['form.dates.' + dateIndex]">
        </span>
        <div class="d-flex flex-wrap flex-md-nowrap align-items-center gap-2 mt-1">
            <x-ui.button color="outline-secondary"
                         class="w-100 w-md-auto py-2"
                         size="sm"
                         @click="addTimeOption(dateIndex, false)">
                <i class="bi bi-clock me-1"></i>{{ __('pages/poll-editor.time_options.button.add_empty_time_option') }}
            </x-ui.button>
            <x-ui.button color="outline-secondary"
                         class="w-100 w-md-auto py-2"
                         size="sm"
                         @click="addTimeOption(dateIndex, true)">
                <i class="bi bi-clock me-1"></i>{{ __('pages/poll-editor.time_options.button.add_hour_time_option') }}
            </x-ui.button>
            <x-ui.button color="outline-secondary"
                         class="w-100 w-md-auto py-2"
                         size="sm"
                         @click="addTextOption(dateIndex, 'text')">
                <i class="bi bi-text-paragraph me-1"></i>{{ __('pages/poll-editor.time_options.button.add_text_option') }}
            </x-ui.button>
        </div>
    </div>
</div>
