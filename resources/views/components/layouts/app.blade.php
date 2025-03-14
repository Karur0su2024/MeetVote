<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="{{ session('darkmode', 'light') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}

    <title>MeetVote - {{ $title ?? 'Aplikace' }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/simple-jscalendar@1.4.4/source/jsCalendar.min.js"></script>

    <livewire:styles />
</head>

<body class="app-background">
    <div class="app-background-overlay">

        {{-- Navbar --}}
        <x-layouts.navbar />


        <!-- Obsah stránky -->
        <main class="container py-5 min-vh-100 px-0">
            {{ $slot }}
        </main>


        {{-- Footer --}}
        <x-layouts.footer />

    </div>


    <livewire:scripts />
    <livewire:modals />
</body>

</html>
