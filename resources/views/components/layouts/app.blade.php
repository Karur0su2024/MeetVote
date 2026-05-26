<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="{{ $_COOKIE['theme'] ?? 'light' }}">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}

    <link rel="icon" type="image/png" href="{{ asset('images/app-logo.png') }}">

    <title>{{ isset($title) ? $title . ' - MeetVote' : 'MeetVote - Online app for planning meetings' }}</title>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles




</head>

<body>
@livewireScripts
<div class="bg-linear-to-r from-violet-100/90 dark:from-base-200 to-base-200/80 p-1">
    <div class="text-base-content min-h-screen flex flex-col w-full">

        <!-- Navbar -->
        <x-layouts.navbar />

        <main class="w-7xl mx-auto p-7 my-7 grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <x-layouts.footer/>

        @stack('scripts')

    </div>

    <x-layouts.modals />

</div>

</body>
</html>
