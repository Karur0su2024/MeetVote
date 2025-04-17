<div class="card shadow-sm border-1 my-2">

    <div class="p-3 d-flex align-items-center justify-content-between">
        <div class="d-flex gap-2 align-items-center ms-2">
            <h4 class="mb-0 me-auto">
                {{ $poll->title }}
            </h4>
            <div class="d-flex gap-2 align-items-center ms-2">
                <span class="badge {{ $poll->isActive() ? 'text-bg-success' : 'text-bg-secondary' }} ">
                    {{ $poll->status }}
                </span>
                @can('is-admin', $poll)
                    <span class="badge text-bg-warning">
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
                    {{ __('pages/dashboard.poll_card.dropdown.edit') }}
                </x-ui.dropdown.item>
                <x-ui.dropdown.item wire:click="openModal('modals.poll.share', '{{ $poll->id }}')">
                    <x-ui.icon name="share"/>
                    {{ __('pages/dashboard.poll_card.dropdown.share') }}
                </x-ui.dropdown.item>
                <x-ui.dropdown.divider/>
                <x-ui.dropdown.item wire:click="openModal('modals.poll.delete-poll', '{{ $poll->id }}')"
                                    color="danger">
                    <x-ui.icon name="trash"/>
                    {{ __('pages/dashboard.poll_card.dropdown.delete') }}
                </x-ui.dropdown.item>

            </x-slot:dropdownItems>
        </x-ui.dropdown.wrapper>
    </div>


    <div class="card-body">

        <div class="row">
            <div class="col-4 text-center">
                <i class="bi bi-check-circle fs-4"></i>
                <div class="fw-bold">{{ $poll->votes()->count() }}</div>
                <div class="small text-muted">{{ __('pages/dashboard.poll_card.stats.votes') }}</div>
            </div>
            <div class="col-4 text-center">
                <i class="bi bi-clock fs-4"></i>
                <div class="fw-bold">{{ $poll->timeOptions()->count() }}</div>
                <div class="small text-muted">{{ __('pages/dashboard.poll_card.stats.time_options') }}</div>
            </div>
            <div class="col-4 text-center">
                <i class="bi bi-question-circle fs-4"></i>
                <div class="fw-bold">{{ $poll->questions()->count() }}</div>
                <div class="small text-muted">{{ __('pages/dashboard.poll_card.stats.questions') }}</div>
            </div>
        </div>
    </div>

    <!-- Card Footer -->
    <div class="card-footer">
        <a href="{{ route('polls.show', $poll) }}" class="btn btn-primary">{{ __('pages/dashboard.poll_card.buttons.view') }}</a>
    </div>
</div>

