<x-layouts.app>

    {{-- Název stránky --}}
    <x-slot:title>{{ __('pages/dashboard.title') }}</x-slot>

    <div class="container text-center mx-auto space-y-12 flex flex-col max-w-7xl">
        <livewire:user.dashboard />
    </div>


</x-layouts.app>
