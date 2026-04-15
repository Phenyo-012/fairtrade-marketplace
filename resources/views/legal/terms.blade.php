<x-app-layout>

<div class="max-w-4xl mx-auto px-4 py-10 bg-white shadow rounded-xl mt-6">

    <h1 class="text-3xl font-bold mb-6">Terms of Service</h1>

    <p class="text-sm text-gray-500 mb-6">
        Last updated: {{ now()->format('F Y') }}
    </p>

    <!-- INTRO -->
    <section class="mb-6">
        <p class="text-gray-700">
            Welcome to FairTrade. By accessing or using our platform, you agree to comply with and be bound by these Terms of Service.
            If you do not agree, you may not use our services.
        </p>
    </section>

    <!-- USER ACCOUNTS -->
    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2">1. User Accounts</h2>
        <p class="text-gray-700">
            You must provide accurate information when creating an account. You are responsible for maintaining the confidentiality
            of your account and all activities under it.
        </p>
    </section>

    <!-- SELLERS -->
    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2">2. Seller Responsibilities</h2>
        <ul class="list-disc pl-6 text-gray-700 space-y-1">
            <li>Sellers must provide accurate product descriptions.</li>
            <li>Sellers must ship items within the specified deadline.</li>
            <li>Sellers must complete identity verification before selling.</li>
            <li>Failure to comply may result in suspension or removal.</li>
        </ul>
    </section>

    <!-- BUYERS -->
    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2">3. Buyer Responsibilities</h2>
        <ul class="list-disc pl-6 text-gray-700 space-y-1">
            <li>Buyers must provide accurate delivery information.</li>
            <li>Buyers must not abuse dispute systems.</li>
            <li>Fraudulent activity will result in account termination.</li>
        </ul>
    </section>

    <!-- PAYMENTS -->
    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2">4. Payments & Fees</h2>
        <p class="text-gray-700">
            FairTrade charges a platform fee on completed transactions. Payments are processed securely through third-party providers.
            We are not responsible for payment provider errors.
        </p>
    </section>

    <!-- DISPUTES -->
    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2">5. Disputes</h2>
        <p class="text-gray-700">
            Buyers may open disputes if items are not delivered or not as described. FairTrade reserves the right to review
            and make final decisions on disputes.
        </p>
    </section>

    <!-- PROHIBITED -->
    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2">6. Prohibited Activities</h2>
        <ul class="list-disc pl-6 text-gray-700 space-y-1">
            <li>Fraud or deceptive practices</li>
            <li>Selling illegal or prohibited items</li>
            <li>Manipulating reviews or ratings</li>
        </ul>
    </section>

    <!-- TERMINATION -->
    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2">7. Account Termination</h2>
        <p class="text-gray-700">
            We reserve the right to suspend or terminate accounts that violate these terms without prior notice.
        </p>
    </section>

    <!-- LIABILITY -->
    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2">8. Limitation of Liability</h2>
        <p class="text-gray-700">
            FairTrade is a marketplace platform and is not responsible for transactions between buyers and sellers beyond
            dispute resolution processes.
        </p>
    </section>

    <!-- CHANGES -->
    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2">9. Changes to Terms</h2>
        <p class="text-gray-700">
            We may update these Terms at any time. Continued use of the platform means you accept the updated Terms.
        </p>
    </section>

    <!-- CONTACT -->
    <section>
        <h2 class="text-xl font-semibold mb-2">10. Contact</h2>
        <p class="text-gray-700">
            For questions, contact support through the platform.
        </p>
    </section>

</div>

</x-app-layout>