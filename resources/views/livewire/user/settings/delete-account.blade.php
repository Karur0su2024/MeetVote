<x-ui.card>
    <x-slot:header>{{ __('pages/user-settings.delete_account.title') }}</x-slot>
    <p class="text-muted">
        {{ __('pages/user-settings.delete_account.description') }}
    </p>
    {{-- Přidat modal pro potvrzení --}}
    <x-ui.button color="danger"
                 wire:click="deleteAccount">
        {{ __('pages/user-settings.delete_account.buttons.delete_account') }}
    </x-ui.button>
</x-ui.card>
