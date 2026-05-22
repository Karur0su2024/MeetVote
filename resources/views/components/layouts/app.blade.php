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

    <livewire:styles/>
    <livewire:scripts/>
</head>

<body>
<div class="tw:bg-linear-to-r tw:from-base-300 tw:to-base-200">
    <div class="tw:text-base-content">

        <!-- Navbar -->
        <x-layouts.navbar />

        <!-- Obsah stránky -->
{{--        <main class="container py-5 min-vh-100 px-0">--}}
{{--            {{ $slot }}--}}
{{--        </main>--}}

        <main class="tw:max-w-7xl tw:mx-auto tw:p-7 tw:my-7">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <x-layouts.footer/>

        <livewire:modals/>

        @stack('scripts')

    </div>
</div>

</body>
</html>
