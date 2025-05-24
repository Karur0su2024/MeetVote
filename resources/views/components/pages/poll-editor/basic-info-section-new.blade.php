<div class="card bg-base-100 shadow-sm p-3">
    <h2 class="text-2xl">
        {{ __('pages/poll-editor.basic_info.title') }}
    </h2>


    <x-ui.form.input-new
        id="title"
        wire:model="form.title"
        type="text"
        placeholder="{{ __('pages/poll-editor.basic_info.poll_title.placeholder') }}"
        required>
        {{ __('pages/poll-editor.basic_info.poll_title.label') }}
    </x-ui.form.input-new>

    <x-ui.form.textbox-new
        id="description"
        wire:model="form.description"
        placeholder="{{ __('pages/poll-editor.basic_info.poll_description.placeholder') }}">
        {{ __('pages/poll-editor.basic_info.poll_description.label') }}
    </x-ui.form.textbox-new>

    <x-ui.form.input-new
        id="deadline"
        wire:model="form.deadline"
        type="date">
        <x-slot:tooltip>
            {{ __('pages/poll-editor.basic_info.poll_deadline.tooltip') }}
        </x-slot:tooltip>
        {{ __('pages/poll-editor.basic_info.poll_deadline.label') }}
    </x-ui.form.input-new>

    <div class="fieldset flex flex-col" x-data="{ timezone: @entangle('form.timezone') }" x-init="timezone = timezone ?? Intl.DateTimeFormat().resolvedOptions().timeZone">
        <label for="timezone" class="fieldset-legend">{{ __('pages/poll-editor.basic_info.poll_timezone.label') }}</label>
        <select class="select w-full" wire:model="form.timezone" id="timezone">
            @foreach($timezones as $timezone)
                <option value="{{ $timezone }}">{{$timezone}} ({{ now()->setTimezone($timezone)->format('P') }})</option>
            @endforeach
        </select>
    </div>


</div>
{{--<x-ui.card header-hidden>--}}


{{--    <x-slot:body>--}}
{{--        --}}{{-- Název ankety --}}

{{--            --}}{{-- Deadline ankety --}}





{{--        </div>--}}



{{--        @guest--}}
{{--            --}}{{-- Informace o autorovi --}}
{{--            @if (!$pollIndex)--}}
{{--                <x-pages.poll-editor.author-info-section />--}}
{{--            @endif--}}
{{--        @endguest--}}

{{--    </x-slot:body>--}}
{{--</x-ui.card>--}}
