<div>
    <p class="opacity-50">

    </p>

    <x-mary-alert title="{{ __('pages/user-settings.delete_account.description') }}"
                  class="alert-error"
                  icon="o-exclamation-triangle" />
    {{-- Přidat modal pro potvrzení --}}
    <button class="btn btn-error max-w-xs mt-6"
            wire:click="deleteAccount">
        {{ __('pages/user-settings.delete_account.buttons.delete_account') }}
    </button>
</div>
