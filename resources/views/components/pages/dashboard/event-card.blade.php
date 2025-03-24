@php
    use Carbon\Carbon;

    $start = Carbon::parse($event->start_time)->format('d.m.Y H:i');
    $end = Carbon::parse($event->end_time)->format('d.m.Y H:i');

    $synced = $event->syncedEvents->where('user_id', Auth::user()->id)->isNotEmpty();

@endphp

<div class="col-md-6 col-lg-4 mb-3">
    <div class="card shadow-sm border-0">
        <!-- Card Header -->
        <div class="card-header bg-light d-flex align-items-center justify-content-between">
            <h2 class="h6 mb-0">{{ $event->title }}
                @if ($synced)
                    <i class="bi bi-calendar-check-fill ms-1 text-success" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Synced with Google Calendar"></i>
                @endif
            </h2>
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-three-dots"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="">
                            Add to google calendar
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Card Body -->
        <div class="card-body">
            <p><strong>Title:</strong> {{ $event->title }}</p>
            <p><strong>Start Time:</strong> {{ $start }}</p>
            <p><strong>End Time:</strong> {{ $end }}</p>
            @isset($event->description)
                <p><strong>Description:</strong> {{ $event->description }}</p>
            @endisset
        </div>
    </div>

</div>


</script>
