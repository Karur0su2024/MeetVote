<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="{{ session('darkmode', 'light') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}

    <title>{{ $title ?? 'Aplikace' }} - MeetVote</title>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <livewire:styles/>
</head>

<body class="app-background">
<div class="app-background-overlay">

    <!-- Navbar -->
    <x-layout.navbar />

    <!-- Obsah stránky -->
    <main class="container py-5 min-vh-100 px-0">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-layout.footer/>

    <livewire:modals/>
    <livewire:scripts/>
    @stack('scripts')

</div>
</body>
</html>
