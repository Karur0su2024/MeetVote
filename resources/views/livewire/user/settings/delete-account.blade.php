{{-- Sekce na stránce nastavení pro odstranění uživatele --}}
<x-ui.tw-card>
    <x-slot:title>
        {{ __('pages/user-settings.delete_account.title') }}
    </x-slot:title>
    <div class="tw-flex tw-flex-col tw-gap-3">
        <p class="text-muted">
            {{ __('pages/user-settings.delete_account.description') }}
        </p>
        {{-- Přidat modal pro potvrzení --}}
        <button class="tw-btn tw-btn-error tw-max-w-xs"
                wire:click="deleteAccount"
        >
            {{ __('pages/user-settings.delete_account.buttons.delete_account') }}
        </button>
    </div>
</x-ui.tw-card>
