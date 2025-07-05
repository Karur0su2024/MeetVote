<div>
    <div class="tw-card mb-3 shadow-sm tw-border tw-p-3 tw-bg-purple-50 tw-flex tw-flex-col tw-gap-2"
         x-data="{ collapsed: false }">
        <div class="tw-flex tw-flex-row tw-items-center tw-gap-2">
            <div class="tw-grow">
                <span class="tw-text-md tw-font-semibold" x-text="moment(dateIndex).format('dddd, MMMM D, YYYY')"</span>
            </div>
            <div class="tw-flex tw-flex-row tw-gap-2 ms-auto align-items-center">
                <div x-show="dateErrors[dateIndex]">
                    <x-ui.badge class="h-100 px-2 d-flex align-items-center" color="danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </x-ui.badge>
                </div>

                <span class="tw-badge tw-badge-info tw-badge-sm" x-text="dates[dateIndex].length">
                </span>
                <button class="tw-btn tw-btn-xs tw-btn-outline tw-btn-error"
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
            <div class="tw-flex flex-md-nowrap align-items-center gap-2">
                <button class="tw-btn tw-btn-sm tw-btn-outline tw-btn-neutral"
                        type="button"
                        @click="addTimeOption(dateIndex, false)">
                    <i class="bi bi-clock me-1"></i>{{ __('pages/poll-editor.time_options.button.add_empty_time_option') }}
                </button>
                <button class="tw-btn tw-btn-sm tw-btn-outline tw-btn-neutral"
                        type="button"
                        @click="addTextOption(dateIndex, 'text')">
                    <i class="bi bi-text-paragraph me-1"></i>{{ __('pages/poll-editor.time_options.button.add_text_option') }}
                </button>
            </div>
        </div>
    </div>
</div>

