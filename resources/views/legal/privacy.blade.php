<x-app-layout>

    <div class="max-w-4xl mx-auto px-7 py-10 bg-white shadow rounded-xl mt-6">

        <h1 class="text-3xl font-bold mb-6">Privacy Policy</h1>

        <p class="text-sm text-gray-500 mb-6">
            Last updated: {{ now()->format('F Y') }}
        </p>

        <!-- INTRO -->
        <section class="mb-6">
            <p class="text-gray-700">
                FairTrade ("we", "our", "us") is committed to protecting your privacy. This Privacy Policy explains how we collect,
                use, and protect your personal information when you use our platform.
            </p>
        </section>

        <!-- DATA COLLECTED -->
        <section class="mb-6">
            <h2 class="text-xl font-semibold mb-2">1. Information We Collect</h2>
            <ul class="list-disc pl-6 text-gray-700 space-y-1">
                <li><strong>Account Information:</strong> Name, email, phone number</li>
                <li><strong>Transaction Data:</strong> Orders, payments, shipping details</li>
                <li><strong>Seller Information:</strong> Store details, identity verification documents</li>
                <li><strong>Technical Data:</strong> IP address, browser type, device information</li>
                <li><strong>Usage Data:</strong> Pages visited, actions taken on the platform</li>
            </ul>
        </section>

        <!-- HOW USED -->
        <section class="mb-6">
            <h2 class="text-xl font-semibold mb-2">2. How We Use Your Information</h2>
            <ul class="list-disc pl-6 text-gray-700 space-y-1">
                <li>To create and manage your account</li>
                <li>To process transactions</li>
                <li>To verify seller identities (KYC)</li>
                <li>To improve platform functionality and security</li>
                <li>To communicate important updates</li>
            </ul>
        </section>

        <!-- LEGAL BASIS -->
        <section class="mb-6">
            <h2 class="text-xl font-semibold mb-2">3. Legal Basis for Processing</h2>
            <p class="text-gray-700">
                We process personal data based on consent, contractual necessity, legal obligations, and legitimate interests,
                in accordance with applicable data protection laws such as POPIA and GDPR.
            </p>
        </section>

        <!-- SHARING -->
        <section class="mb-6">
            <h2 class="text-xl font-semibold mb-2">4. Sharing of Information</h2>
            <ul class="list-disc pl-6 text-gray-700 space-y-1">
                <li>Payment processors (for secure payments)</li>
                <li>Shipping providers (for delivery)</li>
                <li>Identity verification partners (for KYC)</li>
                <li>Legal authorities when required by law</li>
            </ul>
        </section>

        <!-- DATA RETENTION -->
        <section class="mb-6">
            <h2 class="text-xl font-semibold mb-2">5. Data Retention</h2>
            <p class="text-gray-700">
                We retain personal data only as long as necessary for the purposes outlined in this policy or as required by law.
            </p>
        </section>

        <!-- SECURITY -->
        <section class="mb-6">
            <h2 class="text-xl font-semibold mb-2">6. Data Security</h2>
            <p class="text-gray-700">
                We implement appropriate technical and organizational measures to protect your personal data from unauthorized access,
                loss, or misuse.
            </p>
        </section>

        <!-- USER RIGHTS -->
        <section class="mb-6">
            <h2 class="text-xl font-semibold mb-2">7. Your Rights</h2>
            <ul class="list-disc pl-6 text-gray-700 space-y-1">
                <li>Access your personal data</li>
                <li>Request correction or deletion</li>
                <li>Withdraw consent</li>
                <li>Object to processing</li>
                <li>Lodge a complaint with a regulatory authority</li>
            </ul>
        </section>

        <!-- COOKIES -->
        <section class="mb-6">
            <h2 class="text-xl font-semibold mb-2">8. Cookies</h2>
            <p class="text-gray-700">
                We use cookies to enhance user experience and analyze platform usage. You can control cookie settings in your browser.
            </p>
        </section>

        <!-- THIRD PARTY -->
        <section class="mb-6">
            <h2 class="text-xl font-semibold mb-2">9. Third-Party Services</h2>
            <p class="text-gray-700">
                We may use third-party services for payments, analytics, and identity verification. These providers have their own
                privacy policies governing data use.
            </p>
        </section>

        <!-- CHANGES -->
        <section class="mb-6">
            <h2 class="text-xl font-semibold mb-2">10. Changes to This Policy</h2>
            <p class="text-gray-700">
                We may update this Privacy Policy periodically. Continued use of the platform indicates acceptance of the updated policy.
            </p>
        </section>

        <!-- CONTACT -->
        <section>
            <h2 class="text-xl font-semibold mb-2">11. Contact Us</h2>
            <p class="text-gray-700">
                If you have questions about this policy, contact us through the platform.
            </p>
        </section>

    </div>

</x-app-layout>