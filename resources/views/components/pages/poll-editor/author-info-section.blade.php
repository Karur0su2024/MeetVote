<div>

    <h4 class="text-muted mb-3">
        {{ __('pages/poll-editor.basic_info.section.user') }}
    </h4>


    {{-- Jméno autora --}}
    <x-ui.form.input
        id="user_name"
        wire:model="form.user.name"
        type="text"
        required
        placeholder="{{ __('pages/poll-editor.basic_info.user_name.placeholder') }}">
        {{ __('pages/poll-editor.basic_info.user_name.label') }}
    </x-ui.form.input>

    {{-- E-mail autora --}}
    <x-ui.form.input
        id="user_email"
        wire:model="form.user.email"
        type="email"
        required
        placeholder="{{ __('pages/poll-editor.basic_info.user_email.placeholder') }}">
        {{ __('pages/poll-editor.basic_info.user_email.label') }}
    </x-ui.form.input>
</div>
