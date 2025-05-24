<div class="card bg-base-200 mb-3 shadow-sm p-3"
     x-data="{ collapsed: false }">
    <div class="flex flex-row place-content-between">
        <h4 class="card-title" x-text="moment(dateIndex).format('dddd, MMMM D, YYYY')"></h4>

        <div class="flex flex-row gap-2">
            <div x-show="dateErrors[dateIndex]">
                <x-ui.badge class="h-100 px-2 d-flex align-items-center" color="danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </x-ui.badge>
            </div>

            <div class="badge badge-primary">
                <span class="fs-6" x-text="dates[dateIndex].length"></span>
            </div>

            <button class="btn btn-info btn-sm"
                    type="button"
                    @click="collapsed = !collapsed">
                <i class="bi" :class="!collapsed ? 'bi-eye' : 'bi-eye-slash'"></i>
            </button>

            <button class="btn btn-error btn-sm"
                    @click="removeDate(dateIndex)"
                    :class="{ 'disabled': Object.keys(dates).length === 1 }">
                <i class="bi bi-trash"></i>
            </button>
        </div>


    </div>

    <div class="card-body p-2"
         x-show="!collapsed"
         x-collapse>
        <template x-for="(option, optionIndex) in date" :key="optionIndex">
            {{-- Časová možnost --}}
            <x-pages.poll-editor.time-options.date-option/>
        </template>

        <div x-show="dateErrors[dateIndex]">
            <x-ui.alert type="danger" class="small">
                <ul class="mb-0">
                    <span x-html="dateErrors[dateIndex]"></span>
                </ul>

            </x-ui.alert>
        </div>
        {{-- Tlačítka pro přidání nové možnosti --}}
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
