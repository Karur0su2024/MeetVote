<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/poll-editor.page.edit.title', ['poll_title' => $pollTitle]) }}</x-slot>

    <div class="text-center">
        <h1 class="mb-8 font-medium text-3xl">{{ __('pages/poll-editor.page.edit.title', ['poll_title' => $pollTitle]) }}</h1>
        <!-- Livewire komponenta pro celý formulář úpravy ankety -->
        <livewire:pages.poll-editor :poll-index="$pollIndex" />
    </div>

</x-layouts.app>
