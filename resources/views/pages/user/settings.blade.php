<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/user-settings.title') }}</x-slot>

    <div class="container text-center">

        @if(session('error'))
            <x-ui.alert type="danger">
                {{ session('error') }}
            </x-ui.alert>
        @endif

        <livewire:user.settings.profile-settings />

        <livewire:user.settings.password-settings />

        <livewire:user.settings.google-settings />

        <livewire:user.settings.delete-account />



    </div>

</x-layouts.app>
