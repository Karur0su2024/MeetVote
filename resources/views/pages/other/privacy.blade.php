<!-- resources/views/pages/privacy.blade.php -->
<x-layouts.app>
    <x-slot:title>Privacy Policy</x-slot>

    <div class="container py-5">
        <x-ui.card header-hidden class="p-2">
            <x-slot:body>
                <x-slot:body-header>
                    <h2 class="mb-3 fs-1 mb-2">Privacy Policy</h2>
                </x-slot:body-header>
                <p><strong>Last updated:</strong> May 10, 2025</p>
                <hr>

                <h3 class="mt-4">What Data We Collect</h3>
                <ul>
                    <li>Registration data: Name and email</li>
                    <li>Poll data: Content, responses, comments</li>
                    <li>Technical data: Device info, IP address, cookies</li>
                    <li>Google account data (when used for login or calendar sync)</li>
                </ul>

                <h3 class="mt-4">How We Use the Data</h3>
                <ul>
                    <li>To send email notifications</li>
                    <li>To sync with Google Calendar (if enabled)</li>
                </ul>

                <h3 class="mt-4">Data Sharing</h3>
                <p>We only share data with service providers (hosting, email) or when required by law</p>

                <h3 class="mt-4">Security</h3>
                <p>Standard measures such as password encryption and secure connections are in place.</p>

                <h3 class="mt-4">Your Rights</h3>
                <p>You can request access, correction, or deletion of your data by contacting <a href="{{ 'mailto:' . config('app.contact_email') }}">{{ config('app.contact_email') }}</a>.</p>

                <h3 class="mt-4">Cookies</h3>
                <p>We use essential cookies for app functionality and preferences (e.g., dark mode, language).</p>
            </x-slot:body>
        </x-ui.card>
    </div>
</x-layouts.app>
