<div class="col-md-6 col-lg-3 mb-3">
    <div class="card shadow-sm border-0">
        <!-- Card Header -->
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="h6 mb-0">{{ $poll->title }}</h2>
            <div class="dropdown">
                <a href="{{ route('polls.show', $poll) }}" class="btn  btn-primary btn-sm" >
                    <i class="bi bi-eye"></i>
                </a>
                <button class="btn btn-secondary btn-sm" type="button">
                    <i class="bi bi-link-45deg"></i>
                </button>
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
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-bar-chart-fill me-2"></i>
                <p class="mb-0">Responses: <strong>{{ $poll->votes()->count() }}</strong></p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-chat-left-fill me-2"></i>
                <p class="mb-0">Comments: <strong></strong>
                </p>
            </div>
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-clock me-2"></i>
                <p class="mb-0">Deadline: <strong></strong></p>
            </div>

        </div>
    </div>

</div>
