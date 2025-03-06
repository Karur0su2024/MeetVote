<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Aplikace' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Vlastní styly --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Bootstrap --}}


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <livewire:styles />

</head>

<body class="app-background">
    <div class="app-background-overlay">

        {{-- Navbar --}}
        <x-layouts.navbar />




        <!-- Obsah stránky -->
        <main class="container py-5">
            {{ $slot }}
        </main>


        {{-- Footer --}}
        <x-layouts.footer />

    </div>



    {{-- Scripty --}}
    <script src="{{ asset('js/app.js') }}"></script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <livewire:scripts />
    <livewire:modals />


</body>

</html>
