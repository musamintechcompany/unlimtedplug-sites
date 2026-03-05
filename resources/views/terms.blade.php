<x-guest-layout>
    <!-- Hero Section -->
    <section class="py-12 px-6 bg-white dark:bg-[#161615]">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Terms of <span class="text-indigo-600">Service</span>
            </h1>
            <p class="text-lg text-[#706f6c] dark:text-[#A1A09A]">
                Last Updated: {{ date('F d, Y') }}
            </p>
        </div>
    </section>

    <!-- Terms Content -->
    <section class="py-12 px-6">
        <div class="max-w-4xl mx-auto bg-white dark:bg-[#161615] rounded-2xl p-8 border border-[#e3e3e0] dark:border-[#3E3E3A]">
            
            <div class="space-y-8">
                <!-- Introduction -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">1. Introduction</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">
                        Welcome to {{ config('app.name') }}. Our platform provides rental services for websites, web applications, mobile applications, and desktop applications to help businesses launch quickly and provide developers with project samples.
                    </p>
                    <p class="text-[#706f6c] dark:text-[#A1A09A]">
                        By accessing or using our services, you agree to be bound by these Terms of Service. If you do not agree, please do not use our platform.
                    </p>
                </div>

                <!-- Purpose -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">2. Purpose of Service</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">
                        Our platform is designed to:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-[#706f6c] dark:text-[#A1A09A] ml-4">
                        <li>Help legitimate businesses establish their online presence quickly</li>
                        <li>Provide developers with sample projects and templates</li>
                        <li>Offer ready-made solutions for lawful commercial activities</li>
                        <li>Support entrepreneurs in launching their digital products</li>
                    </ul>
                </div>

                <!-- Prohibited Activities -->
                <div>
                    <h2 class="text-2xl font-bold mb-4 text-red-600 dark:text-red-400">3. Prohibited Activities</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4 font-semibold">
                        You are STRICTLY PROHIBITED from using our services for:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-[#706f6c] dark:text-[#A1A09A] ml-4">
                        <li>Any illegal activities, fraud, or scams</li>
                        <li>Phishing, identity theft, or impersonation</li>
                        <li>Distribution of malware, viruses, or harmful software</li>
                        <li>Money laundering or financial fraud</li>
                        <li>Selling counterfeit goods or services</li>
                        <li>Pyramid schemes or multi-level marketing scams</li>
                        <li>Adult content, gambling, or illegal substances</li>
                        <li>Harassment, hate speech, or discrimination</li>
                        <li>Violating intellectual property rights</li>
                        <li>Any activity that violates local, state, national, or international law</li>
                    </ul>
                </div>

                <!-- User Responsibility -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">4. User Responsibility & Liability</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4 font-semibold">
                        YOU ARE SOLELY RESPONSIBLE FOR:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-[#706f6c] dark:text-[#A1A09A] ml-4">
                        <li>All content you upload, publish, or display on rented applications</li>
                        <li>Ensuring your use complies with all applicable laws and regulations</li>
                        <li>Any legal consequences arising from your use of our services</li>
                        <li>All damages, claims, or liabilities resulting from your activities</li>
                        <li>Obtaining necessary licenses, permits, or approvals for your business</li>
                    </ul>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mt-4 font-semibold">
                        By using our platform, you agree to indemnify and hold {{ config('app.name') }}, its owners, operators, and affiliates harmless from any claims, damages, losses, or legal actions arising from your use of our services.
                    </p>
                </div>

                <!-- Account Termination -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">5. Account Termination</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">
                        We reserve the right to:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-[#706f6c] dark:text-[#A1A09A] ml-4">
                        <li>Immediately suspend or terminate accounts suspected of illegal activity</li>
                        <li>Report suspicious activities to law enforcement authorities</li>
                        <li>Refuse service to anyone at our sole discretion</li>
                        <li>Remove content that violates these terms without notice</li>
                    </ul>
                </div>

                <!-- No Warranty -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">6. Disclaimer of Warranties</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">
                        Our services are provided "AS IS" and "AS AVAILABLE" without any warranties of any kind, either express or implied. We do not guarantee that:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-[#706f6c] dark:text-[#A1A09A] ml-4">
                        <li>Services will be uninterrupted or error-free</li>
                        <li>Results obtained will meet your requirements</li>
                        <li>Any errors will be corrected</li>
                    </ul>
                </div>

                <!-- Limitation of Liability -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">7. Limitation of Liability</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">
                        {{ config('app.name') }} SHALL NOT BE LIABLE FOR:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-[#706f6c] dark:text-[#A1A09A] ml-4">
                        <li>Any indirect, incidental, special, or consequential damages</li>
                        <li>Loss of profits, revenue, data, or business opportunities</li>
                        <li>Actions taken by users of rented applications</li>
                        <li>Content posted by users on their rented platforms</li>
                        <li>Any damages exceeding the amount paid for services in the last 12 months</li>
                    </ul>
                </div>

                <!-- Monitoring -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">8. Monitoring & Compliance</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A]">
                        We reserve the right to monitor user activities to ensure compliance with these terms. We may investigate suspected violations and cooperate fully with law enforcement agencies.
                    </p>
                </div>

                <!-- Payment Terms -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">9. Payment & Refunds</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">
                        All payments are processed securely through Flutterwave. Refunds are provided only in cases of service failure on our part, not for user violations or illegal activities.
                    </p>
                </div>

                <!-- Changes to Terms -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">10. Changes to Terms</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A]">
                        We reserve the right to modify these terms at any time. Continued use of our services after changes constitutes acceptance of the new terms.
                    </p>
                </div>

                <!-- Governing Law -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">11. Governing Law</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A]">
                        These terms shall be governed by and construed in accordance with applicable laws. Any disputes shall be resolved in the appropriate courts.
                    </p>
                </div>

                <!-- Contact -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">12. Contact Information</h2>
                    <p class="text-[#706f6c] dark:text-[#A1A09A]">
                        For questions about these terms, please contact us through our support channels.
                    </p>
                </div>

                <!-- Acceptance -->
                <div class="bg-indigo-50 dark:bg-indigo-900/20 p-6 rounded-lg border-l-4 border-indigo-600">
                    <p class="font-bold text-indigo-900 dark:text-indigo-300 mb-2">
                        BY USING OUR SERVICES, YOU ACKNOWLEDGE THAT:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-indigo-800 dark:text-indigo-200">
                        <li>You have read and understood these Terms of Service</li>
                        <li>You agree to use our platform only for lawful purposes</li>
                        <li>You accept full responsibility for your actions</li>
                        <li>You will bear all consequences of any illegal activities</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
