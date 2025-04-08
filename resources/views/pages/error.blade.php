<x-layouts.app>

    {{-- Název stránky --}}
    <x-slot:title>Error</x-slot>

    <div class="container text-center">
        
        @if (session('error'))
            <div class="alert alert-success">
                {{ session('error') }}
            </div>
        @endif
    </div>

</x-layouts.app>
