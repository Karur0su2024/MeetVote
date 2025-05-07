<!-- resources/views/pages/privacy.blade.php -->
<x-layouts.app>
    <x-slot:title>Privacy Policy</x-slot>

    <div class="container py-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white py-3">
                <h1 class="mb-0 fs-2">Privacy Policy</h1>
            </div>
            <div class="card-body p-4 p-md-5">
                <div class="alert alert-secondary mb-4">
                    <p class="mb-0"><strong>Last updated:</strong> {{ date('F d, Y') }}</p>
                </div>

                <div class="mb-4">
                    <h3 class="border-bottom pb-2 text-primary">1. Introduction</h3>
                    <p>Welcome to MeetVote! This privacy policy describes how we collect, use, and protect personal data you provide while using our web application. We respect your privacy and are committed to protecting your personal data in accordance with applicable legislation.</p>
                </div>

                <div class="mb-4">
                    <h3 class="border-bottom pb-2 text-primary">2. What Personal Data We Collect</h3>
                    <p>When using MeetVote, we may collect the following types of personal data:</p>
                    <div class="card mb-3">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Registration data: name, email address, and password when creating an account</li>
                            <li class="list-group-item">Profile data: information you voluntarily provide in your profile</li>
                            <li class="list-group-item">Usage data: information about how you use the application, including IP address, browser type, time and date of visits</li>
                            <li class="list-group-item">Survey-related data: information you share when creating or voting in polls</li>
                            <li class="list-group-item">Integration data: if you sign in using a Google account or connect your Google Calendar, we process data necessary for these integrations</li>
                        </ul>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="border-bottom pb-2 text-primary">3. How We Use Your Personal Data</h3>
                    <p>We use your personal data for the following purposes:</p>
                    <div class="card mb-3">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Providing and personalizing our services</li>
                            <li class="list-group-item">Creating and managing user accounts</li>
                            <li class="list-group-item">Enabling the creation of polls and voting</li>
                            <li class="list-group-item">Synchronizing with your calendar (if enabled)</li>
                            <li class="list-group-item">Sending email notifications related to polls</li>
                            <li class="list-group-item">Improving and optimizing our application</li>
                            <li class="list-group-item">Ensuring the security and protection of our services</li>
                        </ul>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="border-bottom pb-2 text-primary">4. Legal Basis for Processing</h3>
                    <p>We process your personal data based on the following legal grounds:</p>
                    <div class="card mb-3">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Performance of a contract when providing our services</li>
                            <li class="list-group-item">Your consent (e.g., when connecting a Google account)</li>
                            <li class="list-group-item">Our legitimate interest in improving and securing our services</li>
                            <li class="list-group-item">Compliance with legal obligations</li>
                        </ul>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="border-bottom pb-2 text-primary">5. How Long We Keep Your Data</h3>
                    <p>We retain your personal data only as long as necessary to fulfill the purposes stated in this policy or until you withdraw your consent. If you wish to delete your account, your personal data will be removed from our systems, except where we are legally obligated to retain it.</p>
                </div>

                <div class="mb-4">
                    <h3 class="border-bottom pb-2 text-primary">6. Sharing Your Data with Third Parties</h3>
                    <p>We do not share your personal data with third parties, except in the following cases:</p>
                    <div class="card mb-3">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">With Google services when linking your Google account or calendar (only with your consent)</li>
                            <li class="list-group-item">With service providers who help us operate the application (e.g., cloud services)</li>
                            <li class="list-group-item">In cases required by law or to protect our rights</li>
                        </ul>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="border-bottom pb-2 text-primary">7. Data Security</h3>
                    <p>We implement appropriate technical and organizational measures to protect your personal data against unauthorized access, loss, or damage. Data transmission is secured using SSL/TLS encryption.</p>
                </div>

                <div class="mb-4">
                    <h3 class="border-bottom pb-2 text-primary">8. Your Rights</h3>
                    <p>In accordance with applicable data protection laws, you have the following rights:</p>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="card h-100">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Right to access your personal data</li>
                                    <li class="list-group-item">Right to correct inaccurate data</li>
                                    <li class="list-group-item">Right to data erasure (right to be forgotten)</li>
                                    <li class="list-group-item">Right to restrict processing</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Right to data portability</li>
                                    <li class="list-group-item">Right to object to processing</li>
                                    <li class="list-group-item">Right to withdraw consent</li>
                                    <li class="list-group-item">Right to lodge a complaint with a supervisory authority</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="border-bottom pb-2 text-primary">9. Cookies and Similar Technologies</h3>
                    <p>We use cookies and similar technologies to improve the user experience and analyze how our services are used. For more information on how we use cookies, please see our Cookie Policy.</p>
                </div>

                <div class="mb-4">
                    <h3 class="border-bottom pb-2 text-primary">10. Changes to This Policy</h3>
                    <p>We may update this privacy policy from time to time. The latest version will always be available on our website. We recommend regularly checking for any changes.</p>
                </div>

                <div class="mb-4">
                    <h3 class="border-bottom pb-2 text-primary">11. Contact Information</h3>
                    <p>If you have any questions about data protection in MeetVote, please contact us at <a href="mailto:kareltynek2000@proton.me" class="link-primary">kareltynek2000@proton.me</a>.</p>
                </div>

                <div class="alert alert-info mt-5">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="bi bi-shield-check fs-4"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-0">Your privacy is important to us. We are committed to protecting your personal information and being transparent about our data practices.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
