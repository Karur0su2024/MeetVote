<x-ui.tw-card>
    <x-slot:title>
        {{ $poll->title }}
    </x-slot:title>
    <x-slot:header-right>
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
    </x-slot:header-right>
    <div class="tw-flex tw-gap-1 align-items-center">

                <span class="tw-badge tw-badge-sm {{ $poll->isActive() ? 'tw-badge-success' : 'tw-badge-neutral' }} ">
                    {{ __('pages/dashboard.poll_card.pills.status.' . $poll->status->value) }}
                </span>
        @if(auth()->user()->votes()->where('poll_id', $poll->id)->exists())
            <span class="tw-badge tw-badge-sm tw-badge-info">
                        {{ __('pages/dashboard.poll_card.pills.voted') }}
                    </span>
        @endif
        @can('is-admin', $poll)
            <span class="tw-badge tw-badge-sm tw-badge-warning">
                        {{ __('pages/dashboard.poll_card.pills.admin') }}
                    </span>
        @endcan
    </div>

    <div class="row tw-mt-2">
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
    <a href="{{ route('polls.show', $poll) }}" class="tw-btn tw-btn-primary tw-mt-4">{{ __('pages/dashboard.poll_card.buttons.view') }}</a>
</x-ui.tw-card>

