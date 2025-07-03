<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/poll-editor.page.create') }}</x-slot>

    <div class="tw-max-w-5xl text-center mx-auto">
        <h1 class="tw-mb-8 tw-font-medium tw-text-3xl">{{ __('pages/poll-editor.page.create') }}</h1>

        <!-- Livewire komponenta pro celý formulář pro vytvoření nové ankety -->
        <livewire:pages.poll-editor />
    </div>

</x-layouts.app>
