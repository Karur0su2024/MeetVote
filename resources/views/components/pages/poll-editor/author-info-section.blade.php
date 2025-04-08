<div>

    <h4 class="text-muted mb-3">
        User information
    </h4>


    {{-- Jméno autora --}}
    <x-ui.form.input
        id="user_name"
        x-model="form.user.name"
        type="text"
        required
        placeholder="{{ __('pages/poll-editor.basic_info.user_name.placeholder') }}"
        x-error="form.user.name">
        {{ __('pages/poll-editor.basic_info.user_name.label') }}
    </x-ui.form.input>

    {{-- E-mail autora --}}
    <x-ui.form.input
        id="user_email"
        x-model="form.user.email"
        type="email"
        required
        placeholder="{{ __('pages/poll-editor.basic_info.user_email.placeholder') }}"
        x-error="form.user.email">
        {{ __('pages/poll-editor.basic_info.user_email.label') }}
    </x-ui.form.input>
</div>
