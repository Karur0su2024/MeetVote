<div>
    
    <div class="card mb-5 p-2">
        <div class="d-flex justify-content-between align-items-center">

            <a href="{{ route('polls.create') }}" class="btn btn-outline-secondary">New poll</a>

            <input type="text" name="search" class="form-control w-25" placeholder="Search polls..." wire:model.live="search" />

        </div>
    </div>


    <h2 class="my-3">Your polls</h2>
    @if (count($polls) == 0)
        {{-- Upozornění pro žádné ankety --}}
        <div class="alert alert-secondary" role="alert">
            No polls
        </div>
    @else
        <div class="row text-start">
            @foreach ($polls as $poll)
                {{-- Karta ankety --}}
                <x-dashboard.poll-card :poll="$poll" />
            @endforeach
        </div>
    @endif
</div>
