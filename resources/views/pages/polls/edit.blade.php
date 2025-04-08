<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>Edit Poll</x-slot>

    <div class="container">
        <h1 class="mb-5 text-center">Edit poll {{ $pollTitle }}</h1>
        <!-- Livewire komponenta pro celý formulář úpravy ankety -->
        <livewire:pages.poll-editor :poll-index="$pollIndex" />
    </div>

</x-layouts.app>
