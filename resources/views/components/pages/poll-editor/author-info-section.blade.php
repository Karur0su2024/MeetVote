<div x-data="{ anonymous: @entangle('form.user.posted_anonymously') }">

    <h4 class="text-muted mb-3">
        User information
    </h4>

    @auth
        {{-- Nastavení anonymity autora --}}
        <x-ui.form.checkbox
            id="show.user-info"
            x-model="anonymous">
            <x-slot:tooltip>
                {{ __('pages/poll-editor.basic_info.post_anonymously.tooltip') }}
            </x-slot:tooltip>
            {{ __('pages/poll-editor.basic_info.post_anonymously.label') }}
        </x-ui.form.checkbox>
    @endauth


    <div x-show="!anonymous" x-collapse>

        {{-- Jméno autora --}}
        <x-ui.form.input
            id="user_name"
            x-model="form.user.name"
            type="text"
            required
            placeholder="{{ __('pages/poll-editor.basic_info.user_name.placeholder') }}"
            error="form.user.name">
            {{ __('pages/poll-editor.basic_info.user_name.label') }}
        </x-ui.form.input>

        {{-- E-mail autora --}}
        <x-ui.form.input
            id="user_email"
            x-model="form.user.email"
            type="email"
            required
            placeholder="{{ __('pages/poll-editor.basic_info.user_email.placeholder') }}"
            error="form.user.email">
            {{ __('pages/poll-editor.basic_info.user_email.label') }}
        </x-ui.form.input>
    </div>
</div>
