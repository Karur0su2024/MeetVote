<div>
    <p class="opacity-50">
        {{ __('pages/user-settings.delete_account.description') }}
    </p>
    {{-- Přidat modal pro potvrzení --}}
    <button class="btn btn-error max-w-xs"
            wire:click="deleteAccount">
        {{ __('pages/user-settings.delete_account.buttons.delete_account') }}
    </button>
</div>
