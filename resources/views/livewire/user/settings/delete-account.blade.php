<div>
    <p class="tw:opacity-50">
        {{ __('pages/user-settings.delete_account.description') }}
    </p>
    {{-- Přidat modal pro potvrzení --}}
    <button class="tw:btn tw:btn-error tw:max-w-xs"
            wire:click="deleteAccount">
        {{ __('pages/user-settings.delete_account.buttons.delete_account') }}
    </button>
</div>
