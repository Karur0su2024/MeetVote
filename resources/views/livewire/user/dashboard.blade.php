<div class="text-start">

    <div class="mb-5">
        <h2 class="mb-3">Your polls</h2>
        <div class="card mb-3 p-2">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('polls.create') }}" class="btn btn-outline-secondary">New poll</a>
                <input type="text" name="search" class="form-control w-25" placeholder="Search polls..."
                    wire:model.live="search" />
            </div>
        </div>
        @if (count($polls) == 0)
            {{-- Upozornění pro žádné ankety --}}
            <x-alert type="info">
                <i class="bi bi-info-circle-fill me-2"></i>
                No polls found.
            </x-alert>
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
    </div>




    <div class="text-start">


        <h2 class="my-3">Events</h2>

        @if (Auth::user()->google_id == null)
            {{-- Upozornění pro žádné události --}}
            <x-alert type="info">
                <i class="bi bi-info-circle-fill me-1"></i>
                <div>
                    You can sync your events with Google Calendar. To do this, please link your Google account in the
                    <a href="{{ route('settings') }}" class="text-decoration-none">settings</a>.
                </div>
            </x-alert>
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
