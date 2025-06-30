<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ $poll->title }}</x-slot>



    <div class="container max-w-7xl">
        <div class="mb-3">

            <!-- Zobrazit případné chybové nebo úspěšné zprávy -->
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

        <div class="grid grid-cols-7 gap-2">
            <div class="col-span-5">
                <x-pages.poll-show.poll-new.section :poll="$poll"/>
            </div>
            <div class="col-span-2">
                <livewire:pages.poll-show.info-section-new :poll-index="$poll->id"/>
                @if($poll->settings['comments'])
                    <div class="d-lg-block d-none">
                        <livewire:pages.poll-show.comments-section-new :poll-index="$poll->id"/>
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

