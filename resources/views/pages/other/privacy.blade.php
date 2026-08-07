<!-- resources/views/pages/privacy.blade.php -->
<x-layouts.app>
    <x-slot:title>Privacy Policy</x-slot>

    <div class="m-auto">
        <div class="card p-8 bg-base-100 border border-base-300">
            <h2 class="text-3xl mb-3">
                Privacy Policy
            </h2>
            <p class="font-light text-sm">
                Last updated: May 10, 2025
            </p>
            <hr class="mb-8">


            <h3 class="mb-2 text-lg font-medium">What Data We Collect:</h3>
            <ul class="list-disc list-inside space-y-2 mb-4">
                <li>Registration data: Name and email</li>
                <li>Poll data: Content, responses, comments</li>
                <li>Technical data: Device info, IP address, cookies</li>
                <li>Google account data (when used for login or calendar sync)</li>
            </ul>

            <h3 class="mb-2 text-lg font-medium">How We Use the Data:</h3>
            <ul class="list-disc list-inside space-y-2 mb-4">
                <li>To send email notifications</li>
                <li>To sync with Google Calendar (if enabled)</li>
            </ul>

            <h3 class="mb-2 text-lg font-medium">Data Sharing</h3>
            <p class="mb-4">We only share data with service providers (hosting, email) or when required by law</p>

            <h3 class="mb-2 text-lg font-medium">Security</h3>
            <p class="mb-4">Standard measures such as password encryption and secure connections are in place.</p>

            <h3 class="mb-2 text-lg font-medium">Your Rights</h3>
            <p class="mb-4">You can request access, correction, or deletion of your data by contacting <a href="{{ 'mailto:' . config('app.contact_email') }}">{{ config('app.contact_email') }}</a>.</p>

            <h3 class="mb-2 text-lg font-medium">Cookies</h3>
            <p class="mb-4">We use essential cookies for app functionality and preferences (e.g., dark mode, language).</p>
        </div>
    </div>
</x-layouts.app>
