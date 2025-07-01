{{-- Sekce na stránce nastavení pro odstranění uživatele --}}
<x-ui.tw-card>
    <x-slot:title>
        {{ __('pages/user-settings.delete_account.title') }}
    </x-slot:title>
    <p class="text-muted">
        {{ __('pages/user-settings.delete_account.description') }}
    </p>
    {{-- Přidat modal pro potvrzení --}}
    <x-ui.tw-button color="error"
                    class="tw-mt-2"
                 wire:click="deleteAccount">
        {{ __('pages/user-settings.delete_account.buttons.delete_account') }}
    </x-ui.tw-button>
</x-ui.tw-card>
