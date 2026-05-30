<x-ui.card class="p-5">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <h4 class="truncate">
                {{ $poll->title }}
            </h4>

            <div class="mt-2 flex flex-wrap items-center gap-1">
                <span class="badge badge-sm {{ $poll->isActive() ? 'badge-success' : 'badge-neutral' }}">
                    {{ __('pages/dashboard.poll_card.pills.status.' . $poll->status->value) }}
                </span>

                @auth
                    @if(auth()->user()->votes()->where('poll_id', $poll->id)->exists())
                        <span class="badge badge-sm badge-info">
                            {{ __('pages/dashboard.poll_card.pills.voted') }}
                        </span>
                    @endif
                @endauth

                @can('is-admin', $poll)
                    <span class="badge badge-sm badge-warning">
                        {{ __('pages/dashboard.poll_card.pills.admin') }}
                    </span>
                @endcan
            </div>
        </div>

        @can('is-admin', $poll)
            <div class="dropdown dropdown-end">
                <button
                    type="button"
                    class="btn btn-ghost btn-sm"
                    aria-label="{{ __('pages/dashboard.poll_card.dropdown.actions') }}"
                >
                    <i class="bi bi-three-dots"></i>
                </button>

                <ul class="menu dropdown-content z-10 mt-2 w-52 rounded bg-base-100 p-2 shadow-md">
                    <li>
                        <a
                            class="{{ !$poll->isActive() ? 'disabled' : '' }}"
                            href="{{ route('polls.edit', $poll) }}"
                        >
                            <i class="bi bi-pencil me-2"></i>
                            {{ __('pages/dashboard.poll_card.dropdown.edit') }}
                        </a>
                    </li>

                    <li wire:click="openModal('modals.poll.share', '{{ $poll->id }}')">
                        <a href="#">
                            <i class="bi bi-share me-2"></i>
                            {{ __('pages/dashboard.poll_card.dropdown.share') }}
                        </a>
                    </li>

                    <li
                        wire:click="openModal('modals.poll.delete-poll', '{{ $poll->id }}')"
                        class="text-error"
                    >
                        <a href="#">
                            <i class="bi bi-trash me-2"></i>
                            {{ __('pages/dashboard.poll_card.dropdown.delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        @endcan
    </div>

    <div class="mt-5">
        <div class="stats stats-vertical w-full shadow sm:stats-horizontal">
            <div class="stat place-items-center">
                <div class="stat-title">{{ __('pages/dashboard.poll_card.stats.votes') }}</div>
                <div class="stat-value text-2xl">
                    {{ $poll->votes_count ?? $poll->votes()->count() }}
                </div>
            </div>

            <div class="stat place-items-center">
                <div class="stat-title">{{ __('pages/dashboard.poll_card.stats.time_options') }}</div>
                <div class="stat-value text-2xl">
                    {{ $poll->time_options_count ?? $poll->timeOptions()->count() }}
                </div>
            </div>

            <div class="stat place-items-center">
                <div class="stat-title">{{ __('pages/dashboard.poll_card.stats.questions') }}</div>
                <div class="stat-value text-2xl">
                    {{ $poll->questions_count ?? $poll->questions()->count() }}
                </div>
            </div>
        </div>
    </div>

    <div class="card-actions mt-5 justify-end">
        <a href="{{ route('polls.show', $poll) }}" class="btn btn-outline">
            {{ __('pages/dashboard.poll_card.buttons.view') }}
        </a>
    </div>
</x-ui.card>
