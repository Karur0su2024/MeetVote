<!-- resources/views/components/enhanced-event-card.blade.php -->
<x-ui.card header-size="5">
    <x-slot:header>
        {{ $event->title }}
    </x-slot:header>
    <x-slot:header-right>
        @if ($event->syncedEvents->where('user_id', Auth::user()->id)->isNotEmpty())
            <i class="bi bi-calendar-check-fill" data-bs-toggle="tooltip" data-bs-placement="top" title="Synced"></i>
        @endif
    </x-slot:header-right>
    <div class="mb-3">
        <div class="d-flex align-items-center mb-2">
            <i class="bi bi-calendar-date me-2"></i>
            <span>{{ Carbon\Carbon::parse($event->start_time)->format('d. m. Y') }}</span>
        </div>
        <div class="d-flex align-items-center mb-2">
            <i class="bi bi-clock  me-2"></i>
            <span>{{ Carbon\Carbon::parse($event->start_time)->format('H:i') }} - {{ Carbon\Carbon::parse($event->end_time)->format('H:i') }}</span>
        </div>
        @if($event->description)
            <div class="mt-3">
                <small class="text-muted">{{ Str::limit($event->description, 80) }}</small>
            </div>
        @endif
    </div>
    <x-slot:footer>
        <a href="{{ route('polls.show', $event->poll) }}" class="btn btn-outline-primary btn-sm">
            Show poll
        </a>
    </x-slot:footer>

</x-ui.card>


