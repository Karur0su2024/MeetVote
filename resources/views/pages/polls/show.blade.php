<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>Create a new Poll</x-slot>

    <div class="container text-center">

        <div class="card mb-5">

            {{ $poll->title }}
        </div>

        <div class="card mb-5">

            {{ $poll->title }}
        </div>

        <!-- Hlasovací formulář -->
        <div class="card mb-5">
            <div class="card-header">
                <h2>Voting</h2>
            </div>
            Title
        </div>
        
        @if ($poll->comments)
            <div class="card mb-5">
                Comments
            </div>
        @endif


    </div>



</x-layouts.app>
