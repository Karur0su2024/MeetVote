<div class="text-start" x-data="{ opened: 'Polls' }">

    <div class="mb-5">
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card py-2 text-center bg-info-subtle bg-gradient">
                    <i class="bi bi-check2-square fs-1 mb-2"></i>
                    <p class="fs-5 text-muted fw-bold">
                        You have currently {{ $polls->count() }} polls.
                    </p>
                </div>
            </div>
        </div>

        <div class="card mb-3 p-2">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('polls.create') }}"
                   class="btn btn-outline-secondary">
                    <x-ui.icon name="plus-circle" />
                    New poll
                </a>
                <div class="d-flex gap-2 align-items-center ms-2">
                    <div x-show="opened === 'Polls'">
                        <x-ui.dropdown.wrapper size="md">
                            <x-slot:header>
                                <x-ui.icon name="filter"/>
                                Filter
                            </x-slot:header>
                            <x-slot:dropdown-items>
                                <x-ui.dropdown.item wire:click="filterByStatus('all')"
                                                    :class="$status === 'all' ? 'active' : ''">
                                    All
                                </x-ui.dropdown.item>
                                <x-ui.dropdown.item wire:click="filterByStatus('active')"
                                                    :class="$status === 'active' ? 'active' : ''">
                                    Active
                                </x-ui.dropdown.item>
                                <x-ui.dropdown.item wire:click="filterByStatus('closed')"
                                                    :class="$status === 'closed' ? 'active' : ''">
                                    Closed
                                </x-ui.dropdown.item>
                            </x-slot:dropdown-items>
                        </x-ui.dropdown.wrapper>
                    </div>
                    <x-ui.dropdown.wrapper size="md">
                        <x-slot:header><span x-text="opened"></span></x-slot:header>
                        <x-slot:dropdown-items>
                            <x-ui.dropdown.item @click="opened = 'Polls'"
                                                x-bind:class="opened === 'Polls' ? 'active' : ''">
                                Polls
                            </x-ui.dropdown.item>
                            <x-ui.dropdown.item @click="opened = 'Events'"
                                                x-bind:class="opened === 'Events' ? 'active' : ''">
                                Events
                            </x-ui.dropdown.item>
                        </x-slot:dropdown-items>
                    </x-ui.dropdown.wrapper>
                </div>
            </div>
        </div>


        <div x-show="opened === 'Polls'">
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
    </div>


    <div x-show="opened === 'Events'">
        <h2 class="my-3">Events</h2>

        @if (Auth::user()->google_id == null)
            {{-- Upozornění pro žádné události --}}
            <x-ui.alert type="info">
                <x-ui.icon name="info-circle"/>
                    You can sync your events with Google Calendar. To do this, please link your Google account in the
                    <a href="{{ route('settings') }}" class="text-decoration-none">settings</a>.
            </x-ui.alert>
        @endif


        <div class="row g-4">
            @forelse($events as $event)
                <div class="col-lg-4 col-md-6">
                    <x-pages.dashboard.event-card :event="$event"/>
                </div>
            @empty
                <x-ui.alert type="info">
                    <x-ui.icon name="bi-calendar-x"/>
                    You don't have any events yet.
                </x-ui.alert>
            @endforelse
        </div>
    </div>
</div>
