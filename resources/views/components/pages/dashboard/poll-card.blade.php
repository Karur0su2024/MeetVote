<div class="card shadow-sm border-1 my-2">
    <!-- Card Header -->
    <div class="p-3 d-flex align-items-center justify-content-between">
        <div class="d-flex gap-2 align-items-center ms-2">
            <h4 class="mb-0 me-auto">
                {{ $poll->title }}
            </h4>
            <div class="d-flex gap-2 align-items-center ms-2">
                <span class="badge {{ $poll->isActive() ? 'bg-success' : 'bg-secondary' }} text-white">
                    {{ $poll->status}}
                </span>
                @can('is-admin', $poll)
                    <span class="badge bg-warning text-dark">
                        Admin
                    </span>
                @endcan
            </div>
        </div>

        <x-ui.dropdown.wrapper>
            <x-slot:header>
                <i class="bi bi-three-dots"></i>
            </x-slot:header>
            <x-slot:dropdownItems>
                <x-ui.dropdown.item href="{{ route('polls.edit', $poll) }}">
                    <x-ui.icon name="pencil"/>
                    Edit
                </x-ui.dropdown.item>
                <x-ui.dropdown.item wire:click="openModal('modals.poll.share', '{{ $poll->id }}')">
                    <x-ui.icon name="share"/>
                    Share
                </x-ui.dropdown.item>
                <x-ui.dropdown.divider/>
                <x-ui.dropdown.item wire:click="openModal('modals.poll.delete-poll', '{{ $poll->id }}')"
                                    color="danger">
                    <x-ui.icon name="trash"/>
                    Delete
                </x-ui.dropdown.item>

            </x-slot:dropdownItems>
        </x-ui.dropdown.wrapper>
    </div>

    <!-- Card Body -->
    <div class="card-body">

        <div class="row">
            <div class="col-4 text-center">
                <i class="bi bi-check-circle fs-4"></i>
                <div class="stat-value fw-bold">{{ $poll->votes()->count() }}</div>
                <div class="stat-label small text-muted">Votes</div>
            </div>
            <div class="col-4 text-center">
                <i class="bi bi-clock fs-4"></i>
                <div class="stat-value fw-bold">{{ $poll->timeOptions()->count() }}</div>
                <div class="stat-label small text-muted">Time options</div>
            </div>
            <div class="col-4 text-center">
                <i class="bi bi-question-circle fs-4"></i>
                <div class="stat-value fw-bold">{{ $poll->questions()->count() }}</div>
                <div class="stat-label small text-muted">Questions</div>
            </div>
        </div>
    </div>

    <!-- Card Footer -->
    <div class="card-footer">
        <a href="{{ route('polls.show', $poll) }}" class="btn btn-primary">View Poll</a>
    </div>
</div>

