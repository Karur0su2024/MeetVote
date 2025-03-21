<div class="card mb-3 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong class="card-title m-0" x-text="moment(dateIndex).format('dddd, MMMM D, YYYY')"></strong>
        <button type="button" class="btn btn-sm btn-danger" @click="removeDate(dateIndex)">
            <i class="bi bi-trash"></i> Delete
        </button>
    </div>
    <div class="card-body p-2">
        {{ $slot }}


        <span
            class="text-danger ms-2"
            x-show="messages.errors['form.dates.' + dateIndex]"
            x-text="messages.errors['form.dates.' + dateIndex]">
        </span>

        <span
            class="text-danger ms-2"
            x-show="messages.errors['form.dates.' + dateIndex + '.*']"
            x-text="messages.errors['form.dates.' + dateIndex + '.*']">
        </span>

        <div class="d-flex flex-wrap flex-md-nowrap align-items-center gap-2 mt-1">

            <x-outline-button class="w-100 w-md-auto" @click="addTimeOption(dateIndex, 'time')">
                <i class="bi bi-clock me-1"></i>{{ __('form.button.time_option_time') }}
            </x-outline-button>

            <x-outline-button class="w-100 w-md-auto" @click="addTimeOption(dateIndex, 'text')">
                <i class="bi bi-fonts me-1"></i>{{ __('form.button.time_option_text') }}
            </x-outline-button>

        </div>


    </div>

</div>
