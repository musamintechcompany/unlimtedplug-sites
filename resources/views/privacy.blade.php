<x-guest-layout>
    <!-- Hero Section -->
    <section class="py-12 px-6 bg-white dark:bg-[#161615]">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Privacy <span class="text-indigo-600">Policy</span>
            </h1>
            <p class="text-lg text-[#706f6c] dark:text-[#A1A09A]">
                Last Updated: {{ date('F d, Y') }}
            </p>
        </div>
    </section>

    <!-- Privacy Content -->
    <section class="py-12 px-6">
        <div class="max-w-4xl mx-auto bg-white dark:bg-[#161615] rounded-2xl p-8 border border-[#e3e3e0] dark:border-[#3E3E3A]">
            
            <div class="space-y-8">
                <!-- Introduction -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">1. Introduction</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">
                        At {{ config('app.name') }}, we respect your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, and safeguard your data when you use our platform.
                    </p>
                </div>

                <!-- Information We Collect -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">2. Information We Collect</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">We collect the following types of information:</p>
                    
                    <h3 class="text-xl font-semibold mb-3 mt-4">Account Information:</h3>
                    <ul class="list-disc list-inside space-y-2 text-[#706f6c] dark:text-[#A1A09A] ml-4">
                        <li>Name and email address</li>
                        <li>Password (encrypted)</li>
                        <li>Account preferences</li>
                    </ul>

                    <h3 class="text-xl font-semibold mb-3 mt-4">Usage Data:</h3>
                    <ul class="list-disc list-inside space-y-2 text-[#706f6c] dark:text-[#A1A09A] ml-4">
                        <li>Rented applications and services</li>
                        <li>Login times and activity logs</li>
                        <li>IP addresses and browser information</li>
                        <li>Device information</li>
                    </ul>

                    <h3 class="text-xl font-semibold mb-3 mt-4">Payment Information:</h3>
                    <ul class="list-disc list-inside space-y-2 text-[#706f6c] dark:text-[#A1A09A] ml-4">
                        <li>Transaction history and amounts</li>
                        <li>Billing information</li>
                    </ul>
                </div>

                <!-- Payment Processing -->
                <div class="bg-blue-50 dark:bg-blue-900/20 p-6 rounded-lg border-l-4 border-blue-600">
                    <h2 class="text-2xl font-bold mb-4 text-blue-900 dark:text-blue-300">3. Payment Data Security</h2>
                    <p class="text-blue-800 dark:text-blue-200 mb-4 font-semibold">
                        IMPORTANT: We do NOT store your credit card or payment details.
                    </p>
                    <p class="text-blue-800 dark:text-blue-200 mb-4">
                        All payments are processed securely by <strong>Flutterwave</strong>, a certified third-party payment processor. Your payment information is handled directly by Flutterwave according to their privacy policy and PCI-DSS compliance standards.
                    </p>
                    <p class="text-blue-800 dark:text-blue-200">
                        We only receive confirmation of successful transactions and do not have access to your full payment card details.
                    </p>
                </div>

                <!-- How We Use Your Information -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">4. How We Use Your Information</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">We use your information to:</p>
                    <ul class="list-disc list-inside space-y-2 text-[#706f6c] dark:text-[#A1A09A] ml-4">
                        <li>Provide and maintain our rental services</li>
                        <li>Process payments and manage subscriptions</li>
                        <li>Send account notifications and updates</li>
                        <li>Improve our platform and user experience</li>
                        <li>Prevent fraud and ensure security</li>
                        <li>Comply with legal obligations</li>
                        <li>Respond to customer support requests</li>
                    </ul>
                </div>

                <!-- Data Sharing -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">5. Data Sharing and Disclosure</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">We may share your information with:</p>
                    
                    <h3 class="text-xl font-semibold mb-3 mt-4">Service Providers:</h3>
                    <ul class="list-disc list-inside space-y-2 text-[#706f6c] dark:text-[#A1A09A] ml-4">
                        <li><strong>Flutterwave</strong> - For payment processing</li>
                        <li>Hosting providers - For data storage</li>
                        <li>Email service providers - For notifications</li>
                    </ul>

                    <h3 class="text-xl font-semibold mb-3 mt-4">Legal Requirements:</h3>
                    <ul class="list-disc list-inside space-y-2 text-[#706f6c] dark:text-[#A1A09A] ml-4">
                        <li>Law enforcement agencies (when required by law)</li>
                        <li>Courts and legal authorities (in response to legal processes)</li>
                        <li>To prevent fraud or illegal activities</li>
                    </ul>

                    <p class="text-[#706f6c] dark:text-[#A1A09A] mt-4 font-semibold">
                        We do NOT sell your personal information to third parties.
                    </p>
                </div>

                <!-- Data Security -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">6. Data Security</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">
                        We implement industry-standard security measures to protect your data:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-[#706f6c] dark:text-[#A1A09A] ml-4">
                        <li>Encrypted data transmission (SSL/TLS)</li>
                        <li>Secure password hashing</li>
                        <li>Regular security audits</li>
                        <li>Access controls and authentication</li>
                    </ul>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mt-4">
                        However, no method of transmission over the internet is 100% secure. While we strive to protect your data, we cannot guarantee absolute security.
                    </p>
                </div>

                <!-- Cookies -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">7. Cookies and Tracking</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">
                        We use cookies and similar technologies to:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-[#706f6c] dark:text-[#A1A09A] ml-4">
                        <li>Keep you logged in</li>
                        <li>Remember your preferences</li>
                        <li>Analyze platform usage</li>
                        <li>Improve user experience</li>
                    </ul>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mt-4">
                        You can control cookies through your browser settings, but disabling them may affect platform functionality.
                    </p>
                </div>

                <!-- Your Rights -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">8. Your Rights</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">You have the right to:</p>
                    <ul class="list-disc list-inside space-y-2 text-[#706f6c] dark:text-[#A1A09A] ml-4">
                        <li><strong>Access</strong> - Request a copy of your personal data</li>
                        <li><strong>Correction</strong> - Update or correct your information</li>
                        <li><strong>Deletion</strong> - Request deletion of your account and data</li>
                        <li><strong>Export</strong> - Download your data in a portable format</li>
                        <li><strong>Opt-out</strong> - Unsubscribe from marketing emails</li>
                        <li><strong>Object</strong> - Object to certain data processing activities</li>
                    </ul>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mt-4">
                        To exercise these rights, contact us through your account settings or support channels.
                    </p>
                </div>

                <!-- Data Retention -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">9. Data Retention</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">
                        We retain your data for as long as:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-[#706f6c] dark:text-[#A1A09A] ml-4">
                        <li>Your account is active</li>
                        <li>Needed to provide services</li>
                        <li>Required by law or for legal purposes</li>
                        <li>Necessary to resolve disputes</li>
                    </ul>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mt-4">
                        When you delete your account, we will delete or anonymize your personal data within 30 days, except where retention is required by law.
                    </p>
                </div>

                <!-- Children's Privacy -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">10. Children's Privacy</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A]">
                        Our services are not intended for users under 18 years of age. We do not knowingly collect personal information from children. If you believe a child has provided us with personal data, please contact us immediately.
                    </p>
                </div>

                <!-- International Users -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">11. International Data Transfers</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A]">
                        Your data may be transferred to and processed in countries other than your own. We ensure appropriate safeguards are in place to protect your information in accordance with this Privacy Policy.
                    </p>
                </div>

                <!-- Changes to Policy -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">12. Changes to This Policy</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A]">
                        We may update this Privacy Policy from time to time. We will notify you of significant changes by email or through a notice on our platform. Continued use after changes constitutes acceptance of the updated policy.
                    </p>
                </div>

                <!-- Contact -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">13. Contact Us</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A]">
                        If you have questions about this Privacy Policy or how we handle your data, please contact us through our support channels.
                    </p>
                </div>

                <!-- Summary -->
                <div class="bg-indigo-50 dark:bg-indigo-900/20 p-6 rounded-lg border-l-4 border-indigo-600">
                    <p class="font-bold text-indigo-900 dark:text-indigo-300 mb-2">
                        In Summary:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-indigo-800 dark:text-indigo-200">
                        <li>We collect only necessary information to provide our services</li>
                        <li>We do NOT store your payment card details</li>
                        <li>We do NOT sell your data to third parties</li>
                        <li>You have full control over your personal information</li>
                        <li>We use industry-standard security measures</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
