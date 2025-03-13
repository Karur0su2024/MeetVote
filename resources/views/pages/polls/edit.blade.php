<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>Edit Poll</x-slot>

    <div class="container text-center">
        <h1 class="mb-5">Edit Poll {{ $poll->title }}</h1>

        <!-- Livewire komponenta pro celý formulář úpravy ankety -->
        <livewire:poll.form :poll="$poll" />
    </div>

</x-layouts.app>
