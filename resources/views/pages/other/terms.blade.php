{{--<!-- resources/views/pages/terms.blade.php -->--}}
{{--<x-layouts.app>--}}
{{--    <x-slot:title>Terms of Use</x-slot>--}}

{{--    <div class="container py-5">--}}
{{--        <x-ui.card header-hidden class="p-2">--}}
{{--            <x-slot:body>--}}
{{--                <x-slot:body-header>--}}
{{--                    <h2 class="mb-0 fs-1">Terms of Use</h2>--}}
{{--                </x-slot:body-header>--}}
{{--                <p><strong>Last updated:</strong> May 10, 2025</p>--}}
{{--                <hr>--}}

{{--                <ol>--}}
{{--                    <li><strong>Acceptance of Terms:</strong> By using MeetVote, you agree to these terms.</li>--}}
{{--                    <li><strong>Registration and Accounts:</strong>--}}
{{--                        <ul>--}}
{{--                            <li>Registration is required to fully use the service.</li>--}}
{{--                            <li>You are responsible for securing your account.</li>--}}
{{--                            <li>You agree to provide accurate information.</li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                    <li><strong>Code of Conduct:</strong>--}}
{{--                        <ul>--}}
{{--                            <li>No illegal activity.</li>--}}
{{--                            <li>No harmful or inappropriate content.</li>--}}
{{--                            <li>Do not disrupt the service.</li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                    <li><strong>User Content:</strong> You are responsible for your content.</li>--}}
{{--                    <li><strong>Service Availability:</strong> Provided "as is" with no guarantee of availability.</li>--}}
{{--                    <li><strong>Intellectual Property:</strong>--}}
{{--                        <ul>--}}
{{--                            <li>MIT license for MeetVote.</li>--}}
{{--                            <li>User content remains theirs.</li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                    <li><strong>Termination:</strong> We may restrict or terminate accounts violating terms.</li>--}}
{{--                    <li><strong>Changes to Terms:</strong> Updates may occur; continued use implies agreement.</li>--}}
{{--                    <li><strong>Contact:</strong> <a href="{{ 'mailto:' . config('app.contact_email') }}">{{ config('app.contact_email') }}</a>--}}
{{--                </ol>--}}
{{--            </x-slot:body>--}}
{{--        </x-ui.card>--}}
{{--    </div>--}}

{{--</x-layouts.app>--}}


<!-- resources/views/pages/terms.blade.php -->
<x-layouts.app>
    <x-slot:title>Terms of Use</x-slot>

    <div class="tw:m-auto">
        <div class="tw:card tw:p-8 tw:bg-base-100 tw:shadow-sm">
            <h2 class="tw:text-2xl tw:mb-3">
                Terms of Use
            </h2>

            <p class="tw:font-light tw:text-sm">
                Last updated: May 10, 2025
            </p>
            <hr class="tw:mb-6">

            <ol class="tw:list-decimal tw:list-inside tw:space-y-3 tw:text-md">
                <li><strong>Acceptance of Terms:</strong> By using MeetVote, you agree to these terms.</li>
                <li><strong>Registration and Accounts:</strong>
                    <ul class="tw:text-sm  tw:list-disc tw:list-inside tw:mb-2">
                        <li>Registration is required to fully use the service.</li>
                        <li>You are responsible for securing your account.</li>
                        <li>You agree to provide accurate information.</li>
                    </ul>
                </li>
                <li><strong>Code of Conduct:</strong>
                    <ul class="tw:text-sm  tw:list-disc tw:list-inside tw:mb-2">
                        <li>No illegal activity.</li>
                        <li>No harmful or inappropriate content.</li>
                        <li>Do not disrupt the service.</li>
                    </ul>
                </li>
                <li><strong>User Content:</strong> You are responsible for your content.</li>
                <li><strong>Service Availability:</strong> Provided "as is" with no guarantee of availability.</li>
                <li><strong>Intellectual Property:</strong>
                    <ul class="tw:text-sm  tw:list-disc tw:list-inside tw:mb-2">
                        <li>MIT license for MeetVote.</li>
                        <li>User content remains theirs.</li>
                    </ul>
                </li>
                <li><strong>Termination:</strong> We may restrict or terminate accounts violating terms.</li>
                <li><strong>Changes to Terms:</strong> Updates may occur; continued use implies agreement.</li>
                <li><strong>Contact:</strong> <a href="{{ 'mailto:' . config('app.contact_email') }}">{{ config('app.contact_email') != "" ? config('app.contact_email') : "Empty" }}</a>
            </ol>

        </div>

    </div>

</x-layouts.app>
