{{--<!-- resources/views/pages/terms.blade.php -->--}}
{{--<x-layouts.app>--}}
{{--    <x-slot:title>About</x-slot>--}}
{{--    <div class="container py-5">--}}
{{--        <x-ui.card header-hidden class="p-2">--}}
{{--            <x-slot:body>--}}
{{--                <x-slot:body-header>--}}
{{--                    <h2 class="mb-0 fs-1 mb-2">About MeetVote</h2>--}}
{{--                </x-slot:body-header>--}}
{{--                <p>MeetVote is an open-source alternative to Doodle, developed as a bachelor’s thesis at the University of Economics in Prague. The application allows users to schedule meetings through group polls where participants can vote on dates and other aspects of the meeting.</p>--}}

{{--                <hr>--}}
{{--                <h3 class="mt-4">Key Features</h3>--}}
{{--                <ul>--}}
{{--                    <li>Create group polls for scheduling</li>--}}
{{--                    <li>Additional questions (e.g. location, agenda)</li>--}}
{{--                    <li>Poll comments</li>--}}
{{--                    <li>Password protection</li>--}}
{{--                    <li>Invitation system</li>--}}
{{--                    <li>Google Calendar synchronization</li>--}}
{{--                    <li>Multilingual interface (CZ, EN)</li>--}}
{{--                </ul>--}}

{{--                <h3 class="mt-4">Contact</h3>--}}
{{--                <p>GitHub: <a href="https://github.com/Karur0su2024/MeetVote" target="_blank">Karur0su2024/MeetVote</a></p>--}}
{{--                <p>Author: <a href="{{ 'mailto:' . config('app.contact_email') }}">{{ config('app.contact_email') }}</a></p>--}}

{{--            </x-slot:body>--}}
{{--        </x-ui.card>--}}
{{--    </div>--}}

{{--</x-layouts.app>--}}


<!-- resources/views/pages/terms.blade.php -->
<x-layouts.app>
    <x-slot:title>About</x-slot>
    <div class="mx-auto px-4">
        <div class="card p-8 shadow-md bg-base-100 border border-base-300">
            <h2 class="card-title mb-6 text-3xl font-bold">
                About MeetVote
            </h2>
            <p class="mb-6 leading-relaxed text-base-content">
                MeetVote is an open-source alternative to Doodle, developed as a bachelor's thesis at the University
                of Economics in Prague. The application allows users to schedule meetings through group polls where
                participants can vote on dates and other aspects of the meeting.
            </p>

            <div class="divider my-6"></div>

            <h3 class="text-lg font-semibold mb-4">Key Features</h3>
            <ul class="list-disc list-inside mb-6 space-y-2 text-base-content">
                <li>Create group polls for scheduling</li>
                <li>Additional questions (e.g. location, agenda)</li>
                <li>Poll comments</li>
                <li>Password protection</li>
                <li><s>Invitation system</s></li>
                <li><s>Google Calendar synchronization</s></li>
                <li>Multilingual interface (CZ, EN)</li>
                <li>Dark mode</li>
            </ul>

            <div class="divider my-6"></div>

            <h3 class="text-lg font-semibold mb-4">Contact</h3>
            <p class="mb-2">
                GitHub: <a href="https://github.com/Karur0su2024/MeetVote" target="_blank" class="link link-primary">Karur0su2024/MeetVote</a>
            </p>
            <p>
                Author: <a href="{{ 'mailto:' . config('app.contact_email') }}" class="link link-primary">{{ config('app.contact_email') }}</a>
            </p>
        </div>
    </div>
</x-layouts.app>
