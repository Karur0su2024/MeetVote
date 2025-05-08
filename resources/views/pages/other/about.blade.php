<!-- resources/views/pages/terms.blade.php -->
<x-layouts.app>
    <x-slot:title>About</x-slot>
    <div class="container py-5">
        <x-ui.card header-hidden class="p-2">
            <x-slot:body>
                <x-slot:body-header>
                    <h2 class="mb-0 fs-1 mb-2">About MeetVote</h2>
                </x-slot:body-header>
                <p>MeetVote is an open-source alternative to Doodle, developed as a bachelor’s thesis at the University of Economics in Prague. The application allows users to schedule meetings through group polls where participants can vote on dates and other aspects of the meeting.</p>

                <hr>
                <h3 class="mt-4">Key Features</h3>
                <ul>
                    <li>Create group polls for scheduling</li>
                    <li>Additional questions (e.g. location, agenda)</li>
                    <li>Poll comments</li>
                    <li>Password protection</li>
                    <li>Invitation system</li>
                    <li>Google Calendar synchronization</li>
                    <li>Multilingual interface (CZ, EN)</li>
                </ul>

                <h3 class="mt-4">Contact</h3>
                <p>GitHub: <a href="https://github.com/Karur0su2024/MeetVote" target="_blank">Karur0su2024/MeetVote</a></p>
            </x-slot:body>
        </x-ui.card>
    </div>

</x-layouts.app>
