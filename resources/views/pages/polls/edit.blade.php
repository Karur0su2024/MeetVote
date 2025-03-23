<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>Edit Poll</x-slot>

    <div class="container text-center">
        <h1 class="mb-5">Edit poll {{ $poll->title }}</h1>

        <!-- Livewire komponenta pro celý formulář úpravy ankety -->
        <livewire:pages.poll-editor :poll="$poll" />
    </div>

</x-layout.app>
