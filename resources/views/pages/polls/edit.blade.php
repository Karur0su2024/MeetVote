<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ __('pages/poll-editor.page.edit.title', ['poll_title' => $pollTitle]) }}</x-slot>

    <div class="tw-max-w-5xl text-center mx-auto">
        <h1 class="tw-mb-8 tw-font-medium tw-text-3xl">{{ __('pages/poll-editor.page.edit.title', ['poll_title' => $pollTitle]) }}</h1>
        <!-- Livewire komponenta pro celý formulář úpravy ankety -->
        <livewire:pages.poll-editor :poll-index="$pollIndex" />
    </div>

</x-layouts.app>
