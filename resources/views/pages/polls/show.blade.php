<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ $poll->title }}</x-slot>

    <div class="container-fluid text-start">

        <div class="mb-3">
            @if (session('error'))
                <x-ui.alert type="danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>{{ session('error') }}</div>
                </x-ui.alert>
            @endif
            @if (session('success'))
                <x-ui.alert type="success">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>{{ session('success') }}</div>
                </x-ui.alert>
            @endif
        </div>

        <div class="tw-grid tw-grid-cols-3 tw-gap-4">
            <div class="tw-col-span-2">
                <x-pages.poll-show.poll.section :poll="$poll"/>
            </div>
            <div class="tw-col-span-1">
                <div>
                    <livewire:pages.poll-show.info-section :poll-index="$poll->id"/>
                </div>

                @if($poll->settings['comments'])
                    <div class="d-lg-block d-none">
                        <livewire:pages.poll-show.comments-section :poll-index="$poll->id"/>
                    </div>
                @endif

            </div>
        </div>





        @if($poll->settings['comments'])
            <div class="d-lg-none d-md-block">
                <livewire:pages.poll-show.comments-section :poll-index="$poll->id"/>
            </div>
        @endif
    </div>

</x-layouts.app>

