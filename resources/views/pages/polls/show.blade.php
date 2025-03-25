<x-layouts.app>

    <!-- Název stránky -->
    <x-slot:title>{{ $poll->title }}</x-slot>

    <div class="container text-start">

        <div class="mb-3 alerts-container">
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

        {{-- Panel s nastavením ankety --}}
        @can('isAdmin', $poll)
            <livewire:pages.poll-show.settings-section :poll-index="$poll->id"/>
        @endcan

        {{-- Základní informace o anketě --}}
        <livewire:pages.poll-show.info-section :poll-index="$poll->id" />

        <!-- Hlasovací formulář -->
        <livewire:pages.poll-show.voting-section :poll-index="$poll->id"/>

        {{-- Komentáře --}}
        @if ($poll->comments)
            <livewire:pages.poll-show.comments-section :poll-index="$poll->id"/>
        @endif

    </div>

    </x-layouts.app>

