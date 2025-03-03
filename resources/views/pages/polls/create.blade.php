<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>Create a new Poll</x-slot>

    <div class="container text-center">
        <h1 class="my-3">New Poll</h1>

        <!-- Livewire komponenta pro celý formulář pro vytvoření nové ankety -->
        <livewire:poll.form-create />
    </div>



</x-layouts.app>
