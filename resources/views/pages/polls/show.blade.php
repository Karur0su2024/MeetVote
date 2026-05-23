<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ $poll->title }}</x-slot>

    <div class="grid grid-cols-3 gap-4">
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
        <div class="md:col-span-1 sm:col-span-3">


            <livewire:pages.poll-show.info-section :poll-index="$poll->id"/>
            @if($poll->settings['comments'])
                <div class="mt-4">
                    <livewire:pages.poll-show.comments-section :poll-index="$poll->id"/>
                </div>

            @endif

        </div>
    </div>


</x-layouts.app>

