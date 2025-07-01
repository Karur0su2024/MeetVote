<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/user-settings.title') }}</x-slot>

    <div class="tw-flex tw-flex-col tw-max-w-6xl tw-mx-auto tw-gap-4 tw-py-4">
        <livewire:user.settings.profile-settings />

        <livewire:user.settings.password-settings />

        <livewire:user.settings.google-settings />

        <livewire:user.settings.delete-account />
    </div>

    @if(session('error'))
        <x-ui.alert type="danger">
            {{ session('error') }}
        </x-ui.alert>
    @endif


    <div class="container text-center">






    </div>

</x-layouts.app>
