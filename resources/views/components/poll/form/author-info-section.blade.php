<div x-data="{ anonymous: @entangle('form.user.posted_anonymously') }">

    {{-- Nastavení anonymity autora --}}
    <x-ui.form.checkbox
        id="show.user-info"
        x-model="anonymous">
        {{ __('form.label.post_anonymously') }}
    </x-ui.form.checkbox>

    <div x-show="!anonymous">

        {{-- Jméno autora --}}
        <x-ui.form.input
            id="user_name"
            x-model="form.user.name"
            type="text"
            required
            error="form.user.name">
            {{ __('form.label.user_name') }}
        </x-ui.form.input>

        {{-- E-mail autora --}}
        <x-ui.form.input
            id="user_email"
            x-model="form.user.email"
            type="email"
            required
            error="form.user.email">
            {{ __('form.label.user_email') }}
        </x-ui.form.input>
    </div>
</div>
