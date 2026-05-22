<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ $poll->title }}</x-slot>

    <div class="tw:mb-3">
        @if (session('error'))
            <x-ui.alert type="error">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div>{{ session('error') }}</div>
            </x-ui.alert>
        @endif
        @if (session('success'))
            <div role="alert" class="tw:alert tw:alert-success tw:alert-soft">
                <i class="bi bi-check-circle-fill tw:me-2"></i>
                <span>{{ session('success') }}</span>
            </div>

        @endif
    </div>

    <div class="tw:grid tw:grid-cols-3 tw:gap-4">
        <div class="tw:col-span-2">
            <x-pages.poll-show.poll.section :poll="$poll"/>
        </div>
        <div class="tw:col-span-1">
            <div>
                <livewire:pages.poll-show.info-section :poll-index="$poll->id"/>
            </div>

            @if($poll->settings['comments'])
                <livewire:pages.poll-show.comments-section :poll-index="$poll->id"/>
            @endif

        </div>
    </div>


</x-layouts.app>

