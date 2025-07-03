<div class="card shadow-sm border-1 my-2">

    <div class="p-3 d-flex align-items-center justify-content-between">
        <div class="d-flex gap-2 align-items-center ms-2">
            <h4 class="mb-0 me-auto text-break tw-text-lg tw-font-bold">
                {{ $poll->title }}
            </h4>

        </div>

        @can('is-admin', $poll)

            <div class="tw-dropdown">
                <button class="tw-btn tw-btn-ghost">
                    <i class="bi bi-three-dots"></i>
                </button>
                <ul class="tw-menu tw-dropdown-content tw-bg-base-100 tw-w-52 tw-border tw-rounded tw-shadow-sm">
                    <li>
                        <a  class="{{ !$poll->isActive() ? 'disabled' : '' }}"
                            href="{{ route('polls.edit', $poll) }}">
                            <i class="bi bi-pencil me-2"></i>
                            {{ __('pages/dashboard.poll_card.dropdown.edit') }}
                        </a>
                    </li>
                    <li class="tw-flex"
                        wire:click="openModal('modals.poll.share', '{{ $poll->id }}')">
                        <a href="#">
                            <i class="bi bi-share me-2"></i>
                            {{ __('pages/dashboard.poll_card.dropdown.share') }}
                        </a>
                    </li>
                    <li wire:click="openModal('modals.poll.delete-poll', '{{ $poll->id }}')"
                        class="tw-text-error">
                        <a href="#">
                            <i class="bi bi-trash me-2"></i>
                            {{ __('pages/dashboard.poll_card.dropdown.delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        @endcan
    </div>
    <div class="px-3 d-flex gap-2 align-items-center ms-2 mb-2">
                <span class="badge {{ $poll->isActive() ? 'text-bg-success' : 'text-bg-secondary' }} ">
                    {{ __('pages/dashboard.poll_card.pills.status.' . $poll->status->value) }}
                </span>
        @if(auth()->user()->votes()->where('poll_id', $poll->id)->exists())
            <span class="badge text-bg-info">
                        {{ __('pages/dashboard.poll_card.pills.voted') }}
                    </span>
        @endif
        @can('is-admin', $poll)
            <span class="badge text-bg-warning">
                        {{ __('pages/dashboard.poll_card.pills.admin') }}
                    </span>
        @endcan
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
        <a href="{{ route('polls.show', $poll) }}" class="tw-btn tw-btn-primary">{{ __('pages/dashboard.poll_card.buttons.view') }}</a>
    </div>
</div>

