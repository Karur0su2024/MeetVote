<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>Dashboard</x-slot>


    <div class="container text-center">
        <h1 class="my-3">Dashboard</h1>

        <div class="card mb-5 p-2">
            <div class="d-flex justify-content-between align-items-center">
                
                <!-- Levá část: Tlačítko -->
                <button class="btn btn-outline-secondary">New poll</button>
        
                <!-- Pravá část: Vyhledávací pole -->
                <input type="text" name="search" class="form-control w-25" placeholder="Search polls..." value="{{ request('search') }}">
                
            </div>
        </div>
        

        <h2 class="my-3">Your polls</h2>
        <div class="row">
            @foreach ($polls as $poll)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header">
                            <h2 class="h5">{{ $poll->title }}</h2>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('polls.show', $poll) }}" class="btn btn-primary">Show</a>
                            <a href="{{ route('polls.edit', $poll) }}" class="btn btn-secondary">Edit</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

                

        <h2>Planned events</h2>


        <!-- Potřeba doplnit (kolem 6.-7.) -->
    </div>

</x-layouts.app>
