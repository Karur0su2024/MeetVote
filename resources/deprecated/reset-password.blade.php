<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/auth.reset_password.title') }}</x-slot>

    <div class="container text-start">
        <!-- Registrační formulář -->
        <livewire:auth.reset-password :token="$token" :email="$email"/>
    </div>



</x-layouts.app>
