<div class="text-start">

    <div class="mb-5">
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card py-2 text-center bg-info-subtle">
                    <i class="bi bi-check2-square fs-1 mb-2"></i>
                    <p class="fs-5 text-muted fw-bold">
                        You have currently {{ $polls->count() }} polls.
                    </p>
                </div>
            </div>
        </div>

        <div class="card mb-3 p-2">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('polls.create') }}" class="btn btn-outline-secondary">New poll</a>
                <div class="d-flex gap-2 align-items-center ms-2">
                    <x-ui.dropdown.wrapper size="md">
                        <x-slot:header>Filter</x-slot:header>
                        <x-slot:dropdown-items>
                            <x-ui.dropdown.item wire:click="setFilter('all')">
                                <x-ui.icon name="check-square"/>
                                All
                            </x-ui.dropdown.item>
                            <x-ui.dropdown.item wire:click="setFilter('active')">
                                <x-ui.icon name="check-circle"/>
                                Active
                            </x-ui.dropdown.item>
                            <x-ui.dropdown.item wire:click="setFilter('inactive')">
                                <x-ui.icon name="circle"/>
                                Inactive
                            </x-ui.dropdown.item>
                        </x-slot:dropdown-items>
                    </x-ui.dropdown.wrapper>

                    <input type="text"
                           class="form-control"
                           placeholder="Search..."
                           wire:model.live="search">

                </div>


            </div>
        </div>


        @if (count($polls) !== 0)
            <div class="row">
                @foreach ($polls as $poll)
                    {{-- Karta ankety --}}
                    <div class="col-md-6 col-lg-4">
                        <x-pages.dashboard.poll-card :poll="$poll"/>
                    </div>
                @endforeach
            </div>

        @else
            {{-- Upozornění pro žádné ankety --}}
            <x-ui.alert type="info">
                <x-ui.icon name="info-circle" class="me-2"/>
                No polls found.
            </x-ui.alert>
        @endif
    </div>


    <div class="text-start">


        <h2 class="my-3">Events</h2>

        @if (Auth::user()->google_id == null)
            {{-- Upozornění pro žádné události --}}
            <x-ui.alert type="info">
                <i class="bi bi-info-circle-fill me-1"></i>
                <div>
                    You can sync your events with Google Calendar. To do this, please link your Google account in the
                    <a href="{{ route('settings') }}" class="text-decoration-none">settings</a>.
                </div>
            </x-ui.alert>
        @endif


        @if (count($events) == 0)
            {{-- Upozornění pro žádné události --}}
            <x-ui.alert type="info">
                <i class="bi bi-info-circle-fill me-2"></i>
                No events found.
            </x-ui.alert>
        @else
            <div class="row text-start my-5">
                @foreach ($events as $event)
                    <x-pages.dashboard.event-card :event="$event"/>
                @endforeach
            </div>
        @endif

    </div>
</div>
