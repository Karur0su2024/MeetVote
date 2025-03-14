<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>Reset password</x-slot>

    <div class="container text-start">
        <h1 class="my-3">Reset password</h1>

        <!-- Registrační formulář -->
        <livewire:auth.reset-password :token="$token" :email="$email"/>
    </div>



</x-layouts.app>
