<div>

    <h4 class="tw-text mb-3">
        {{ __('pages/poll-editor.basic_info.section.user') }}
    </h4>


    {{-- Jméno autora --}}
    <x-ui.form.tw-input
        id="user_name"
        wire:model="form.user.name"
        type="text"
        required
        placeholder="{{ __('pages/poll-editor.basic_info.user_name.placeholder') }}">
        <x-slot:label>
            {{ __('pages/poll-editor.basic_info.user_name.label') }}
        </x-slot:label>
    </x-ui.form.tw-input>

    {{-- E-mail autora --}}
    <x-ui.form.tw-input
        id="user_email"
        wire:model="form.user.email"
        type="email"
        required
        placeholder="{{ __('pages/poll-editor.basic_info.user_email.placeholder') }}">
        <x-slot:label>
            {{ __('pages/poll-editor.basic_info.user_email.label') }}
        </x-slot:label>
    </x-ui.form.tw-input>
</div>
