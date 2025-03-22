<x-layout.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/auth.login.title') }}</x-slot>

    <div class="container text-center">

        <!-- Přihlašovací formulář -->
        <livewire:auth.login />
    </div>


</x-layout.app>
