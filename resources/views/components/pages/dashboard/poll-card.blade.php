<x-ui.tw-card>
    <x-slot:title>
        {{ $poll->title }}
    </x-slot:title>
    <x-slot:header-right>
        @can('is-admin', $poll)

            <div class="dropdown">
                <button class="btn btn-ghost">
                    <i class="bi bi-three-dots"></i>
                </button>
                <ul class="menu dropdown-content bg-base-100 w-52 rounded shadow-md">
                    <li>
                        <a class="{{ !$poll->isActive() ? 'disabled' : '' }}"
                           href="{{ route('polls.edit', $poll) }}">
                            <i class="bi bi-pencil me-2"></i>
                            {{ __('pages/dashboard.poll_card.dropdown.edit') }}
                        </a>
                    </li>
                    <li class="flex"
                        wire:click="openModal('modals.poll.share', '{{ $poll->id }}')">
                        <a href="#">
                            <i class="bi bi-share me-2"></i>
                            {{ __('pages/dashboard.poll_card.dropdown.share') }}
                        </a>
                    </li>
                    <li wire:click="openModal('modals.poll.delete-poll', '{{ $poll->id }}')"
                        class="text-error">
                        <a href="#">
                            <i class="bi bi-trash me-2"></i>
                            {{ __('pages/dashboard.poll_card.dropdown.delete') }}
                        </a>
                    </li>
                </ul>
            </div>
        @endcan
    </x-slot:header-right>
    <div class="flex gap-1 align-items-center">

                <span class="badge badge-sm {{ $poll->isActive() ? 'badge-success' : 'badge-neutral' }} ">
                    {{ __('pages/dashboard.poll_card.pills.status.' . $poll->status->value) }}
                </span>
        @if(auth()->user()->votes()->where('poll_id', $poll->id)->exists())
            <span class="badge badge-sm badge-info">
                        {{ __('pages/dashboard.poll_card.pills.voted') }}
                    </span>
        @endif
        @can('is-admin', $poll)
            <span class="badge badge-sm badge-warning">
                        {{ __('pages/dashboard.poll_card.pills.admin') }}
                    </span>
        @endcan
    </div>

    {{--    <div class="row mt-2">--}}
    {{--        <div class="col-4 text-center">--}}
    {{--            <i class="bi bi-check-circle fs-4"></i>--}}
    {{--            <div class="fw-bold">{{ $poll->votes()->count() }}</div>--}}
    {{--            <div class="text-xs text-inherit">{{ __('pages/dashboard.poll_card.stats.votes') }}</div>--}}
    {{--        </div>--}}
    {{--        <div class="col-4 text-center">--}}
    {{--            <i class="bi bi-clock fs-4"></i>--}}
    {{--            <div class="fw-bold">{{ $poll->timeOptions()->count() }}</div>--}}
    {{--            <div class="text-xs text-inherit">{{ __('pages/dashboard.poll_card.stats.time_options') }}</div>--}}
    {{--        </div>--}}
    {{--        <div class="col-4 text-center">--}}
    {{--            <i class="bi bi-question-circle fs-4"></i>--}}
    {{--            <div class="fw-bold">{{ $poll->questions()->count() }}</div>--}}
    {{--            <div class="text-xs text-inherit text-inherit">{{ __('pages/dashboard.poll_card.stats.questions') }}</div>--}}
    {{--        </div>--}}
    {{--    </div>--}}


    <div class="flex gap-4 mt-3">
        <div class="flex-1 text-center">
            <i class="bi bi-check-circle text-2xl"></i>
            <div class="font-bold">{{ $poll->votes()->count() }}</div>
            <div class="text-xs text-inherit">{{ __('pages/dashboard.poll_card.stats.votes') }}</div>
        </div>
        <div class="flex-1 text-center">
            <i class="bi bi-clock text-2xl"></i>
            <div class="font-bold">{{ $poll->timeOptions()->count() }}</div>
            <div class="text-xs text-inherit">{{ __('pages/dashboard.poll_card.stats.time_options') }}</div>
        </div>
        <div class="flex-1 text-center">
            <i class="bi bi-question-circle text-2xl"></i>
            <div class="font-bold">{{ $poll->questions()->count() }}</div>
            <div class="text-xs text-inherit">{{ __('pages/dashboard.poll_card.stats.questions') }}</div>
        </div>
    </div>


    <div class="card-actions">
        <a href="{{ route('polls.show', $poll) }}"
           class="btn btn-outline mt-4">{{ __('pages/dashboard.poll_card.buttons.view') }}</a>
    </div>
</x-ui.tw-card>

