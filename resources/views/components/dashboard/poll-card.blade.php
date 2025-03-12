<div class="col-md-6 col-lg-4 mb-3">
    <div class="card shadow-sm border-0">
        <!-- Card Header -->
        <div class="card-header bg-light d-flex align-items-center justify-content-between">
            <h2 class="h6 mb-0">{{ $poll->title }}</h2>
            <div class="dropdown">
                <a href="{{ route('polls.show', $poll) }}" class="btn  btn-outline-secondary btn-sm" >
                    <i class="bi bi-eye"></i>
                </a>
                <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('polls.edit', $poll) }}">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Card Body -->
        <div class="card-body">
            <p class="mb-2">Number of answers: <strong>{{ $poll->votes()->count() }}</strong></p>

            @if ($poll->deadline)
                @php
                    $daysLeft = now()->startOfDay()->diffInDays(Carbon\Carbon::parse($poll->deadline));
                @endphp
                <span class="badge {{ $daysLeft > 3 ? 'bg-success' : 'bg-danger' }}">
                    <i class="bi bi-clock"></i> Ends in {{ $daysLeft }} days
                </span>
            @else
                <span class="badge bg-secondary"> No deadline</span>
            @endif
        </div>
    </div>

</div>
