<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>Dashboard</x-slot>


    <div class="container text-center">
        <h1 class="my-3">Dashboard</h1>

        @foreach ($polls as $poll)
            <div class="card mb-3">
                <div class="card-header">
                    <h2>{{ $poll->title }}</h2>
                    <a href="{{ route('polls.show', $poll) }}" class="btn btn-primary">Show</a>
                </div>
            </div>    

        @endforeach

        <!-- Potřeba doplnit (kolem 6.-7.) -->
    </div>

</x-layouts.app>
