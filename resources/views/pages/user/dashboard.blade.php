<x-layouts.app>

    {{-- Název stránky --}}
    <x-slot:title>{{ __('pages/dashboard.title') }}</x-slot>

    <div class="container text-center">
        <livewire:user.dashboard />
    </div>

</x-layouts.app>
