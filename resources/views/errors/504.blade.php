<x-layouts.app>

    {{-- Název stránky --}}
    <x-slot:title>Error</x-slot>

    <x-ui.card class="w-100 mx-auto">

        <h2 class="text-4xl text-center">504</h2>
        <p class="mt-3 text-md text-center">
            Server took too long to respond.
        </p>
        <a href="{{ route('home') }}" class="btn btn-outline mt-3">
            <x-mary-icon name="o-home" />
             Go to home
        </a>
    </x-ui.card>

</x-layouts.app>
