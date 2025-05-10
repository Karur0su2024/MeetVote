{{-- Sekce na stránce nastavení pro odstranění uživatele --}}
<x-ui.card header-hidden>
    <x-slot:body-header>
        <h2 class="mb-3">
            {{ __('pages/user-settings.delete_account.title') }}
        </h2>

    </x-slot:body-header>
    <p class="text-muted">
        {{ __('pages/user-settings.delete_account.description') }}
    </p>
    {{-- Přidat modal pro potvrzení --}}
    <x-ui.button color="danger"
                 wire:click="deleteAccount">
        {{ __('pages/user-settings.delete_account.buttons.delete_account') }}
    </x-ui.button>
</x-ui.card>
