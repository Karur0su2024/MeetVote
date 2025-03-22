<x-layout.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/auth.forgot_password.title') }}d</x-slot>

    <div class="container text-start">
        {{-- Formulář pro obnovení hesla --}}
        <livewire:auth.forgot-password />
    </div>



</x-layout.app>
