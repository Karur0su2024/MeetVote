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
                        <x-heroicon-o-exclamation-triangle class="w-4 h-4" />
                    </div>
                </div>
                <button class="btn btn-sm btn-error"
                        ::class="{ 'btn-disabled': Object.keys(dates).length === 1 }"
                        type="button"
                        @click="removeDate(dateIndex)">
                    <x-heroicon-c-trash class="w-4 h-4" />
                    <span class="d-md-inline d-none">
                    {{ __('pages/poll-editor.time_options.button.delete') }}
                </span>
                </button>
            </div>
        </div>
        <div>
            <template x-for="(option, optionIndex) in date" :key="optionIndex">
                {{-- Časová možnost --}}
                <x-sections.poll-editor.time-options.date-option />
            </template>

            <x-mary-alert class="alert-error alert-soft"
                          x-show="dateErrors[dateIndex]"
                          icon="o-exclamation-triangle">
                <x-slot:title>
                    <span x-html="dateErrors[dateIndex]"></span>
                </x-slot:title>
            </x-mary-alert>
        </div>
        <div>
            {{-- Tlačítka pro přidání nové možnosti --}}

            <div class="flex flex-1 align-items-center gap-2">
                <x-mary-button label="{{ __('pages/poll-editor.time_options.button.add_empty_time_option') }}"
                               class="btn-sm btn-primary btn-outline grow"
                               type="button"
                               @click="addTimeOption(dateIndex, true)"/>
                <x-mary-button label="{{ __('pages/poll-editor.time_options.button.add_text_option') }}"
                               class="btn-sm btn-primary btn-outline grow"
                               type="button"
                               @click="addTextOption(dateIndex, 'text')"/>
            </div>
        </div>
    </div>
</div>

