<div class="card mb-3 p-2 shadow-sm">
    <div class="d-flex justify-content-end gap-2">
        <a href="#" class="btn btn-outline-secondary">
            <i class="bi bi-bell-fill me-1"></i> Notifications </a>

        {{-- Dropdown pro správce --}}
        <div class="dropdown">
            <form action="{{ route('polls.destroy', $poll) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-trash me-1"></i> Delete poll
                </button>
            </form>


            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                Options
            </button>
            <ul class="dropdown-menu">

                <li><a class="dropdown-item py-1 {{ $poll->status == 'closed' ? 'disabled' : '' }}" href="{{ route('polls.edit', $poll) }}">
                    <i class="bi bi-pencil-square me-1"></i> Edit poll
                </a>
            </li>

                <x-poll.show.dropdown-item modalName="share" :id="$poll->public_id">
                    <i class="bi bi-share me-1"></i> Share poll
                </x-poll.show.dropdown-item>

                <x-poll.show.dropdown-item modalName="close-poll" :id="$poll->public_id">
                    @if ($poll->status == 'active')
                        <i class="bi bi-lock me-1"></i> Close poll
                    @else
                        <i class="bi bi-unlock me-1"></i> Reopen poll
                    @endif
                </x-poll.show.dropdown-item>

                <x-poll.show.dropdown-item modalName="invitations" :id="$poll->public_id">
                    <i class="bi bi-person-plus me-1"></i> Invitations
                </x-poll.show.dropdown-item>

                <x-poll.show.dropdown-item modalName="delete-poll" :id="$poll->public_id" type="danger">
                    <i class="bi bi-trash me-1"></i> Delete poll
                </x-poll.show.dropdown-item>

            </ul>
        </div>

    </div>

</div>
