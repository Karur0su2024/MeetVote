<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MeetVote - {{ $title ?? 'Aplikace' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <livewire:styles />
</head>

<body class="app-background">
    <div class="app-background-overlay">

        {{-- Navbar --}}
        <x-layouts.navbar />




        <!-- Obsah stránky -->
        <main class="container py-5 min-vh-100">
            {{ $slot }}
        </main>


        {{-- Footer --}}
        <x-layouts.footer />

    </div>


    <livewire:scripts />
    <livewire:modals />


</body>

</html>
