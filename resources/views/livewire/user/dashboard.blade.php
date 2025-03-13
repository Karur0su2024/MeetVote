<div>

    <div class="card mb-5 p-2">
        <div class="d-flex justify-content-between align-items-center">

            <a href="{{ route('polls.create') }}" class="btn btn-outline-secondary">New poll</a>

            <input type="text" name="search" class="form-control w-25" placeholder="Search polls..."
                wire:model.live="search" />

        </div>
    </div>


    <h2 class="my-3">Your polls</h2>
    @if (count($polls) == 0)
        {{-- Upozornění pro žádné ankety --}}
        <div class="alert alert-secondary" role="alert">
            No polls
        </div>
    @else
        <div>
            {{-- Skupiny skupin anket --}}
            @foreach ($polls as $pollGroupName => $pollsGroup)
                <div class="row text-start my-5">
                    <h4 class="my-3">{{ ucfirst($pollGroupName) }} polls</h4>
                    @foreach ($pollsGroup as $poll)
                        {{-- Karta ankety --}}
                        <x-dashboard.poll-card :poll="$poll" />
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif


    <div class="text-start">


        <h2 class="my-3">Events</h2>

        @if (Auth::user()->google_id == null)
            {{-- Upozornění pro žádné události --}}
            <div class="alert alert-secondary" role="alert">
                You do not have a Google account linked to your profile. To sync with Google Calendar, please link your
                account in the settings.
            </div>
        @endif


        @if (count($events) == 0)
            {{-- Upozornění pro žádné události --}}
            <div class="alert alert-secondary" role="alert">
                No events
            </div>
        @else
            <div class="row text-start my-5">
                @foreach ($events as $event)
                    <x-dashboard.event-card :event="$event" />
                @endforeach
            </div>
        @endif

    </div>
</div>
