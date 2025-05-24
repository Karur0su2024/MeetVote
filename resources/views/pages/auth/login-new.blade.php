<x-layouts.app-new>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/auth.login.title') }}</x-slot>

    <div class="container text-center">
        <!-- Přihlašovací formulář -->
        <livewire:auth.login-new />
    </div>


</x-layouts.app-new>
