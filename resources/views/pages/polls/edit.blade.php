<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>Edit Poll</x-slot>

    <div class="container">
        <h1 class="mb-5 text-center">Edit poll {{ $pollTitle }}</h1>

        <a class="btn btn-secondary btn-lg mb-4 text-start" href="{{ route('polls.show', ['poll' => $publicId]) }}">
            Return to poll
        </a>

        <!-- Livewire komponenta pro celý formulář úpravy ankety -->
        <livewire:pages.poll-editor :poll-index="$pollIndex" />
    </div>

</x-layouts.app>
