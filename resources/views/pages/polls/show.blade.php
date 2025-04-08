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


        <div class="row flex-row-reverse">
            <div class="col-lg-4">
                {{-- Základní informace o anketě --}}
                <livewire:pages.poll-show.info-section :poll-index="$poll->id" />
                @if ($poll->comments)
                    <livewire:pages.poll-show.comments-section :poll-index="$poll->id"/>
                @endif
            </div>
            <div class="col-lg-8">
                <x-pages.poll-show.poll.section :poll="$poll" />
            </div>
        </div>



        {{-- Komentáře --}}


    </div>

    </x-layouts.app>

