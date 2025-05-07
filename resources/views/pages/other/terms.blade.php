<!-- resources/views/pages/terms.blade.php -->
<x-layouts.app>

    <div class="container">
        <div class="card">
            <div class="card-body p-5">
                <h1 class="mb-4">Terms of Use</h1>

                <h3>1. Introduction</h3>
                <p>Welcome to MeetVote! These Terms of Use govern your use of our application and the relationship between you as a user and us as a service provider. By using MeetVote, you acknowledge that you have read, understood, and agree to be bound by these Terms of Use. If you do not agree to these terms, please do not use our service.</p>

                <h3>2. Service Description</h3>
                <p>MeetVote is an application designed for scheduling meetings and events through voting on suitable dates. The service allows creating polls, voting on dates, and synchronizing events with calendars.</p>

                <h3>3. User Accounts</h3>
                <p>3.1. You may need to create an account to use certain features of our service. You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.</p>
                <p>3.2. You agree to provide accurate and complete information when creating your account and to update your information to keep it accurate and current.</p>
                <p>3.3. We reserve the right to disable any user account if, in our opinion, you have violated any provision of these Terms of Use.</p>

                <h3>4. User Content</h3>
                <p>4.1. Our service allows you to create polls, add comments, and provide other content. You retain ownership of all content you submit.</p>
                <p>4.2. By submitting content, you grant MeetVote a worldwide, non-exclusive, royalty-free license to use, reproduce, modify, and display such content in connection with providing and promoting the service.</p>
                <p>4.3. You agree not to post content that is illegal, offensive, threatening, defamatory, or infringing on intellectual property rights.</p>

                <h3>5. Prohibited Activities</h3>
                <p>When using MeetVote, you agree not to:</p>
                <ul>
                    <li>Use the service for any illegal purpose</li>
                    <li>Attempt to gain unauthorized access to any part of the service</li>
                    <li>Interfere with or disrupt the service or servers</li>
                    <li>Collect or store personal data about other users without their consent</li>
                    <li>Upload viruses or other malicious code</li>
                    <li>Impersonate another person</li>
                    <li>Use the service to send spam or unsolicited communications</li>
                </ul>

                <h3>6. Third-Party Services</h3>
                <p>6.1. Our service may integrate with third-party services such as Google Calendar. Your use of such third-party services is subject to their respective terms of service.</p>
                <p>6.2. We are not responsible for any aspects of third-party services that our service links to or integrates with.</p>

                <h3>7. Intellectual Property</h3>
                <p>7.1. The service and its original content, features, and functionality are owned by MeetVote and are protected by international copyright, trademark, and other intellectual property laws.</p>
                <p>7.2. Our name, logo, and all related names, logos, product and service names, designs, and slogans are trademarks of MeetVote. You may not use such marks without our prior written permission.</p>

                <h3>8. Disclaimer of Warranties</h3>
                <p>8.1. The service is provided on an "as is" and "as available" basis without any warranties of any kind.</p>
                <p>8.2. We do not guarantee that the service will always be secure, error-free, or available at any particular time or location.</p>

                <h3>9. Limitation of Liability</h3>
                <p>To the maximum extent permitted by law, MeetVote shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use or inability to use the service.</p>

                <h3>10. Privacy</h3>
                <p>Our <a href="{{ route('privacy') }}">Privacy Policy</a> describes how we collect, use, and protect your personal data when using our service. By using MeetVote, you also agree to our Privacy Policy.</p>

                <h3>11. Changes to Terms</h3>
                <p>We may modify these Terms of Use at any time. It is your responsibility to review these Terms periodically. Your continued use of the service after any changes indicates your acceptance of the modified Terms.</p>

                <h3>12. Termination</h3>
                <p>We may terminate or suspend your account and access to the service at our sole discretion, without prior notice, for conduct that we believe violates these Terms or is harmful to other users of the service or third parties, or for any other reason.</p>

                <h3>13. Governing Law</h3>
                <p>These Terms shall be governed by and construed in accordance with the laws of the Czech Republic, without regard to its conflict of law provisions.</p>

                <h3>14. Contact Information</h3>
                <p>If you have any questions about these Terms of Use, please contact us at <a href="mailto:kareltynek2000@proton.me">kareltynek2000@proton.me</a>.</p>

                <p class="mt-4">Last updated: {{ date('F d, Y') }}</p>
            </div>
        </div>
    </div>

</x-layouts.app>
