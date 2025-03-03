<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ $poll->title }}</x-slot>

    <div class="container text-center">

        <!-- Panel s nastavením ankety -->
        <div class="card mb-5 p-2">
            <div class="d-flex justify-content-end gap-2">
                <a href="#" class="btn btn-secondary">Copy link</a>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Options
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('polls.edit', $poll) }}">Edit</a></li>
                    </ul>
                </div>
            </div>

        </div>

        <div class="card mb-5">

            {{ $poll->title }}
        </div>

        <!-- Hlasovací formulář -->
        <livewire:poll.voting :poll="$poll" />

        @if (!$poll->comments)
            <div class="card mb-5">
                Comments
            </div>
        @endif


    </div>



</x-layouts.app>
