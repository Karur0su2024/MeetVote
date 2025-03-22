<x-layout.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/auth.register.title') }}</x-slot>

    <div class="container text-start">
        <!-- Registrační formulář -->
        <livewire:auth.register />
    </div>

</x-layout.app>
