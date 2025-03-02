<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ $poll->title }}</x-slot>

    <div class="container text-center">

        <!-- Panel s nastavením ankety -->
        <div class="card mb-5">
            <a href="#" class="btn btn-secondary">Edit</a>
            {{ $poll->title }}
        </div>

        <div class="card mb-5">

            {{ $poll->title }}
        </div>

        <!-- Hlasovací formulář -->
        <livewire:poll.voting :poll="$poll" />
        
        @if ($poll->comments)
            <div class="card mb-5">
                Comments
            </div>
        @endif


    </div>



</x-layouts.app>
