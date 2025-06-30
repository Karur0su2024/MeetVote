<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/poll-editor.page.edit.title', ['poll_title' => $pollTitle]) }}</x-slot>

    <div class="container">
        <h1 class="mb-5 text-center tw-text-3xl">{{ __('pages/poll-editor.page.edit.title', ['poll_title' => $pollTitle]) }}</h1>
        <!-- Livewire komponenta pro celý formulář úpravy ankety -->
        <livewire:pages.poll-editor :poll-index="$pollIndex" />
    </div>

</x-layouts.app>
