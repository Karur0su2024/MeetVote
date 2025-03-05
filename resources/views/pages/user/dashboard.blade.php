<x-layouts.app>

    {{-- Název stránky --}}
    <x-slot:title>Dashboard</x-slot>

    <div class="container text-center">
        <h1 class="my-3">Dashboard</h1>

        <livewire:user.dashboard />



        <h2>Planned events</h2>



        <div class="row">
            @foreach ($events as $event)
                <div class="col-lg-4">
                    <div class="card">
                        {{ $event->final_datetime }}
                    </div>
                </div>
            @endforeach
        </div>


        {{-- Později doplnit --}}
    </div>

</x-layouts.app>
