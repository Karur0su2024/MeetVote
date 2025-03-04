<div class="col-md-4 mb-3">
    <div class="card h-100 shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="h5">{{ $poll->title }} </h2>
            <div class="dropdown">
                <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    ...
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('polls.show', $poll) }}">Show</a>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('polls.edit', $poll) }}">Edit</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <p>Votes: {{ $poll->votes()->count() }}</p>
            <p>Deadline: {{ $poll->deadline }}</p>

        </div>
    </div>
</div>