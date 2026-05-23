<x-layouts.app>

    {{-- Název stránky --}}
    <x-slot:title>{{ __('pages/dashboard.title') }}</x-slot>

    <div class="text-center">
        <livewire:user.dashboard />
    </div>

</x-layouts.app>
