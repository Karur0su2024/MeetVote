<x-layouts.app>

    {{-- Název stránky --}}
    <x-slot:title>Error</x-slot>

    <x-ui.card class="w-100 mx-auto">

        <h2 class="text-4xl text-center">404</h2>
        <p class="mt-3 text-md text-center">The page you are looking for does not exist.</p>
        <a href="{{ route('home') }}" class="btn btn-outline mt-3">
            <x-mary-icon name="o-home" />
             Go to home
        </a>
    </x-ui.card>

</x-layouts.app>
