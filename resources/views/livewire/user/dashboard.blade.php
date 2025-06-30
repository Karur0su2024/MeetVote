{{-- Dashboard  uživatele --}}
<div x-data="{ opened: 'Polls' }">
    <div class="my-5">
        <h3 class="text-3xl">
            {{ __("ui/navbar.dashboard") }}
        </h3>
        <div class="flex flex-col md:flex-row items-center justify-between gap-3 p-1 bg-base-100 shadow rounded-box mt-4 mb-2">
            <div>
                <a href="{{ route('polls.create') }}"
                   class="btn btn-outline btn-secondary">
                    <x-ui.icon name="plus-circle"/>
                    {{ __('pages/dashboard.buttons.new_poll') }}
                </a>
            </div>
            <div class="flex gap-2 items-center">
                <div x-show="opened === 'Polls'">
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-md btn-outline btn-primary flex items-center gap-2">
                            <x-ui.icon name="filter"/>
                            {{ __('pages/dashboard.dropdowns.filter.title') }}
                        </label>
                        <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                            <li>
                                <a wire:click="filterByStatus('all')"
                                   class="{{ $status === 'all' ? 'active' : '' }}">
                                    {{ __('pages/dashboard.dropdowns.filter.items.all') }}
                                </a>
                            </li>
                            <li>
                                <a wire:click="filterByStatus('active')"
                                   class="{{ $status === 'active' ? 'active' : '' }}">
                                    {{ __('pages/dashboard.dropdowns.filter.items.active') }}
                                </a>
                            </li>
                            <li>
                                <a wire:click="filterByStatus('closed')"
                                   class="{{ $status === 'closed' ? 'active' : '' }}">
                                    {{ __('pages/dashboard.dropdowns.filter.items.closed') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-md btn-outline btn-primary">
                        <span x-text="opened === 'Polls' ? '{{ __('pages/dashboard.dropdowns.opened.items.polls') }}' : '{{ __('pages/dashboard.dropdowns.opened.items.events') }}'"></span>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li>
                            <a @click="opened = 'Polls'"
                               :class="opened === 'Polls' ? 'active' : ''">
                                {{ __('pages/dashboard.dropdowns.opened.items.polls') }}
                            </a>
                        </li>
                        <li>
                            <a @click="opened = 'Events'"
                               :class="opened === 'Events' ? 'active' : ''">
                                {{ __('pages/dashboard.dropdowns.opened.items.events') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @if (count($polls) !== 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($polls as $poll)
                    {{-- Karta ankety --}}
                    <div class="card bg-base-100 shadow-md border border-base-200">
                        <div class="card-body p-4 flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <div class="flex gap-2 items-center">
                                    <h4 class="card-title break-words">
                                        {{ $poll->title }}
                                    </h4>
                                </div>
                                @can('is-admin', $poll)
                                    <div class="dropdown dropdown-end">
                                        <label tabindex="0" class="btn btn-ghost btn-circle">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/></svg>
                                        </label>
                                        <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                                            <li>
                                                <a href="{{ route('polls.edit', $poll) }}" class="{{ !$poll->isActive() ? 'disabled pointer-events-none opacity-50' : '' }}">
                                                    <x-ui.icon name="pencil"/>
                                                    {{ __('pages/dashboard.poll_card.dropdown.edit') }}
                                                </a>
                                            </li>
                                            <li>
                                                <button type="button" wire:click="openModal('modals.poll.share', '{{ $poll->id }}')" class="w-full text-left">
                                                    <x-ui.icon name="share"/>
                                                    {{ __('pages/dashboard.poll_card.dropdown.share') }}
                                                </button>
                                            </li>
                                            <li><hr class="my-1"></li>
                                            <li>
                                                <button type="button" wire:click="openModal('modals.poll.delete-poll', '{{ $poll->id }}')" class="w-full text-left text-error">
                                                    <x-ui.icon name="trash"/>
                                                    {{ __('pages/dashboard.poll_card.dropdown.delete') }}
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                @endcan
                            </div>
                            <div class="flex gap-2 items-center flex-wrap mb-2">
                                <span class="badge {{ $poll->isActive() ? 'badge-success' : 'badge-ghost' }}">
                                    {{ __('pages/dashboard.poll_card.pills.status.' . $poll->status->value) }}
                                </span>
                                @if(auth()->user()->votes()->where('poll_id', $poll->id)->exists())
                                    <span class="badge badge-info">
                                        {{ __('pages/dashboard.poll_card.pills.voted') }}
                                    </span>
                                @endif
                                @can('is-admin', $poll)
                                    <span class="badge badge-warning">
                                        {{ __('pages/dashboard.poll_card.pills.admin') }}
                                    </span>
                                @endcan
                            </div>
                            <div class="grid grid-cols-3 gap-2 text-center">
                                <div>
                                    <i class="bi bi-check-circle text-2xl"></i>
                                    <div class="font-bold">{{ $poll->votes()->count() }}</div>
                                    <div class="text-xs text-base-content/60">{{ __('pages/dashboard.poll_card.stats.votes') }}</div>
                                </div>
                                <div>
                                    <i class="bi bi-clock text-2xl"></i>
                                    <div class="font-bold">{{ $poll->timeOptions()->count() }}</div>
                                    <div class="text-xs text-base-content/60">{{ __('pages/dashboard.poll_card.stats.time_options') }}</div>
                                </div>
                                <div>
                                    <i class="bi bi-question-circle text-2xl"></i>
                                    <div class="font-bold">{{ $poll->questions()->count() }}</div>
                                    <div class="text-xs text-base-content/60">{{ __('pages/dashboard.poll_card.stats.questions') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-actions justify-end p-4 pt-0">
                            <a href="{{ route('polls.show', $poll) }}" class="btn btn-primary">
                                {{ __('pages/dashboard.poll_card.buttons.view') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info mt-4">
                <x-ui.icon name="info-circle" class="me-2"/>
                {{ __('pages/dashboard.alerts.no_polls') }}
            </div>
        @endif

    </div>
</div>

