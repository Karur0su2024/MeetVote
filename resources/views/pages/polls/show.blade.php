<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ $poll->title }}</x-slot>

    <div class="tw:grid tw:grid-cols-3 tw:gap-4">
        @if (session('error'))
            <div role="alert" class="tw:alert tw:alert-error tw:col-span-3">
                <i class="bi bi-exclamation-triangle-fill tw:me-1"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if (session('success'))
            <div role="alert" class="tw:alert tw:alert-success tw:col-span-3">
                <i class="bi bi-check-circle-fill tw:me-1"></i>
                <span>{{ session('success') }}</span>
            </div>

        @endif


        <div class="tw:md:col-span-2 tw:sm:col-span-3">
            <x-pages.poll-show.poll.section :poll="$poll"/>
        </div>
        <div class="tw:md:col-span-1 tw:sm:col-span-3">


            <livewire:pages.poll-show.info-section :poll-index="$poll->id"/>
            @if($poll->settings['comments'])
                <div class="tw:mt-4">
                    <livewire:pages.poll-show.comments-section :poll-index="$poll->id"/>
                </div>

            @endif

        </div>
    </div>


</x-layouts.app>

