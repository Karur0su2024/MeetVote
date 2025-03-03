<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>Edit Poll</x-slot>

    <div class="container text-center">
        <h1 class="my-3">Edit Poll</h1>

        <!-- Livewire komponenta pro celý formulář úpravy ankety -->
        <livewire:poll.form-edit :poll="$poll" />
    </div>



</x-layouts.app>
