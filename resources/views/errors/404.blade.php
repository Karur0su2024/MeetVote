<x-layouts.app>

    {{-- Název stránky --}}
    <x-slot:title>Error</x-slot>

    <div class="container text-center">

        <div class="card">
            <div class="card-body">
                <h2 class="text-danger">404</h2>
                <p class="text-muted">The page you are looking for does not exist.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="bi bi-house-door-fill me-1"></i> Go to home
                </a>
            </div>
        </div>



    </div>

</x-layouts.app>
