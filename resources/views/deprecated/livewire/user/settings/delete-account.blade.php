<form wire:submit.prevent='deleteAccount'>
    <p class="opacity-50">

    </p>

    <x-mary-alert title="{{ __('pages/user-settings.delete_account.description') }}"
                  class="alert-error"
                  icon="o-exclamation-triangle" />
    {{-- Přidat modal pro potvrzení --}}

    <x-ui.form.tw-input id="current_password"
                        wire:model="current_password"
                        type="password"
                        required>
        <x-slot:label>
            {{ __('pages/user-settings.password.labels.old_password') }}
        </x-slot:label>
    </x-ui.form.tw-input>
    <button class="btn btn-error max-w-xs">
        {{ __('pages/user-settings.delete_account.buttons.delete_account') }}
    </button>
</form>
