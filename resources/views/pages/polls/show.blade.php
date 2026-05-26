<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ $poll->title }}</x-slot>

    <div class="grid grid-cols-3 gap-3">
        @if (session('error'))
            <div role="alert" class="alert alert-error col-span-3">
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if (session('success'))
            <div role="alert" class="alert alert-success col-span-3">
                <i class="bi bi-check-circle-fill me-1"></i>
                <span>{{ session('success') }}</span>
            </div>

        @endif


        <div class="md:col-span-2 sm:col-span-3">
            <x-pages.poll-show.poll.section :poll="$poll"/>
        </div>
        <div class="md:col-span-1 sm:col-span-3 flex flex-col gap-1">

            <livewire:sections.poll-show.info :poll-index="$poll->id" />

            @if($poll->isActive())
                <livewire:sections.poll-show.user-vote :poll-index="$poll->id"/>
            @endif

            @if($poll->event)
                <livewire:sections.poll-show.event-details :event="$poll->event" :poll="$poll"/>
            @endif


            @if($poll->settings['comments'])
                <livewire:sections.poll-show.comments :poll-index="$poll->id"/>
            @endif

        </div>
    </div>





</x-layouts.app>

