<div>
    <div class="card bg-base-200 mb-3 shadow-sm p-3 flex flex-col gap-2 border border-gray-100"
         x-data="{ collapsed: false }">
        <div class="flex flex-row items-center gap-2 justify-between">
            <div class="grow">
                <span class="text-md font-semibold" x-text="moment(dateIndex).format('dddd, MMMM D, YYYY')"></span>
            </div>
            <div class="flex flex-row gap-2 ms-auto items-center">
                <div x-show="dateErrors[dateIndex]">
                    <div class="badge badge-error badge-sm">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                </div>

                <span class="badge badge-info badge-sm" x-text="dates[dateIndex].length">
                </span>
                <button class="btn btn-sm btn-error"
                        ::class="{ 'disabled': Object.keys(dates).length === 1 }"
                        @click="removeDate(dateIndex)">
                    <i class="bi bi-trash"></i>
                    <span class="d-md-inline d-none">
                    {{ __('pages/poll-editor.time_options.button.delete') }}
                </span>
                </button>
            </div>
        </div>
        <div>
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
        </div>
        <div>
            {{-- Tlačítka pro přidání nové možnosti --}}

            <div class="flex flex-1 align-items-center gap-2">
                <button class="btn btn-sm btn-primary btn-outline grow"
                        type="button"
                        @click="addTimeOption(dateIndex, false)">
                    {{ __('pages/poll-editor.time_options.button.add_empty_time_option') }}
                </button>
                <button class="btn btn-sm btn-primary btn-outline grow"
                        type="button"
                        @click="addTextOption(dateIndex, 'text')">
                    {{ __('pages/poll-editor.time_options.button.add_text_option') }}
                </button>
            </div>
        </div>
    </div>
</div>

