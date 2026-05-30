<x-ui.card>
    <x-ui.text.title-lg>
        {{ __('pages/poll-editor.settings.title') }}
    </x-ui.text.title-lg>

    {{-- Komentáře --}}
    <x-mary-toggle label="{{ __('pages/poll-editor.settings.comments.label') }}"
                   class="toggle-sm toggle-primary"
                   wire:model="form.settings.comments"
                   hint="{{ __('pages/poll-editor.settings.comments.tooltip') }}"
    />
    {{-- Anonymní hlasování --}}
    <x-mary-toggle label="{{ __('pages/poll-editor.settings.anonymous.label') }}"
                   class="toggle-sm toggle-primary"
                   wire:model="form.settings.anonymous_votes"
                   hint="{{ __('pages/poll-editor.settings.anonymous.tooltip') }}"
    />
    {{-- Skrytí výsledků --}}
    <x-mary-toggle label="{{ __('pages/poll-editor.settings.hide_results.label') }}"
                   class="toggle-sm toggle-primary"
                   wire:model="form.settings.hide_results"
                   hint="{{ __('pages/poll-editor.settings.hide_results.tooltip') }}"
    />

    {{-- Přidání časových možností --}}
    <x-mary-toggle label="{{ __('pages/poll-editor.settings.add_time_options.label') }}"
                   class="toggle-sm toggle-primary"
                   wire:model="form.settings.add_time_options"
                   hint="{{ __('pages/poll-editor.settings.add_time_options.label') }}"
    />

    {{-- Umožnit hlasovat pro staré možnosti --}}
    <x-mary-toggle label="{{ __('pages/poll-editor.settings.allow_invalid.label') }}"
                   class="toggle-sm toggle-primary"
                   wire:model="form.settings.allow_invalid"
                   hint="{{ __('pages/poll-editor.settings.allow_invalid.tooltip') }}"
    />

{{--    <h4 class="text-lg mb-1">--}}
{{--        {{ __('pages/poll-editor.settings.section_titles.security') }}--}}
{{--    </h4>--}}

{{--    @auth--}}
{{--        --}}{{-- Pouze pro pozvané --}}
{{--        <x-ui.form.tw-toggle id="invite_only" wire:model="form.settings.invite_only">--}}
{{--            <x-slot:tooltip>--}}
{{--                {{ __('pages/poll-editor.settings.invite_only.tooltip') }}--}}
{{--            </x-slot:tooltip>--}}
{{--            {{ __('pages/poll-editor.settings.invite_only.label') }}--}}
{{--        </x-ui.form.tw-toggle>--}}
{{--    @endauth--}}

    {{-- Nastavení hesla --}}
    <div x-data="{ password:  @entangle('form.password') }">
        <div x-show="password.set !== null">
            <button class="tw-btn tw-btn-error tw-btn-sm tw-btn-outline mt-1"
                    @click="password.set = null"
                    type="button">
                Password is set, click to remove
            </button>
        </div>

        <div x-show="password.set === null" x-collapse>

            <x-mary-input label="{{ __('pages/poll-editor.settings.password.label') }}"
                          x-model="password.value"
                          placeholder="{{ __('pages/poll-editor.settings.password.placeholder') }}"
                          type="password"
                          hint="{{ __('pages/poll-editor.settings.password.tooltip') }}"
            />

        </div>


    </div>
</x-ui.card>
