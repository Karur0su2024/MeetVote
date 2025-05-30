<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/poll-editor.page.create') }}</x-slot>

    <div class="container text-center">
        <h1 class="mb-5">{{ __('pages/poll-editor.page.create') }}</h1>

        <!-- Livewire komponenta pro celý formulář pro vytvoření nové ankety -->
        <livewire:pages.poll-editor />
    </div>

</x-layouts.app>
