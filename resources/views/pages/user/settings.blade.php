<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/user-settings.title') }}</x-slot>

    <!-- name of each tab group should be unique -->
    <div class="tabs tabs-lift">
        <label class="tab">
            <input type="radio" name="settings_tabs" />
            {{ __('pages/user-settings.profile_settings.title') }}
        </label>
        <div class="tab-content bg-base-100 border-base-300 p-6">
            <h2 class="text-lg font-semibold">
                {{ __('pages/user-settings.profile_settings.title') }}
            </h2>
            <livewire:user.settings.profile-settings />
        </div>

        <label class="tab">
            <input type="radio" name="settings_tabs" checked="checked" />
            {{ __('pages/user-settings.password.title') }}
        </label>
        <div class="tab-content bg-base-100 border-base-300 p-6">
            <h2 class="text-lg font-semibold">
                {{ __('pages/user-settings.profile_settings.title') }}
            </h2>
            <livewire:user.settings.password-settings />
        </div>

        <label class="tab">
            <input type="radio" name="settings_tabs" />
            {{ __('pages/user-settings.google.title') }}
        </label>
        <div class="tab-content bg-base-100 border-base-300 p-6">
            <h2 class="text-lg font-semibold">
                {{ __('pages/user-settings.google.title') }}
            </h2>
            <livewire:user.settings.google-settings />
        </div>

        <label class="tab">
            <input type="radio" name="settings_tabs" />
            {{ __('pages/user-settings.delete_account.title') }}
        </label>
        <div class="tab-content bg-base-100 border-base-300 p-6">
            <h2 class="text-lg font-semibold">
                {{ __('pages/user-settings.delete_account.title') }}
            </h2>
            <livewire:user.settings.delete-account />
        </div>
    </div>
    @if(session('error'))
        <x-ui.alert type="danger">
            {{ session('error') }}
        </x-ui.alert>
    @endif

</x-layouts.app>
