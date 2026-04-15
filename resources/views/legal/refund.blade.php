<x-app-layout>

<div class="max-w-4xl mx-auto px-4 py-10 bg-white shadow rounded-xl mt-6">

    <h1 class="text-3xl font-bold mb-6">Refund Policy</h1>

    <p class="text-sm text-gray-500 mb-6">
        Last updated: {{ now()->format('F Y') }}
    </p>

    <!-- INTRO -->
    <section class="mb-6">
        <p class="text-gray-700">
            This Refund Policy outlines how refunds are handled on FairTrade. As a marketplace,
            FairTrade connects buyers and sellers. Refunds are managed through our dispute resolution system.
        </p>
    </section>

    <!-- ELIGIBILITY -->
    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2">1. Refund Eligibility</h2>
        <p class="text-gray-700 mb-2">
            Buyers may request a refund under the following conditions:
        </p>
        <ul class="list-disc pl-6 text-gray-700 space-y-1">
            <li>Item not received within the expected delivery time</li>
            <li>Item received is significantly different from the listing</li>
            <li>Item is damaged or defective upon arrival</li>
        </ul>
    </section>

    <!-- NON ELIGIBLE -->
    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2">2. Non-Refundable Situations</h2>
        <ul class="list-disc pl-6 text-gray-700 space-y-1">
            <li>Buyer changes their mind after purchase</li>
            <li>Incorrect delivery information provided by buyer</li>
            <li>Minor differences (e.g., color variation due to lighting)</li>
        </ul>
    </section>

    <!-- PROCESS -->
    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2">3. Refund Process</h2>
        <ol class="list-decimal pl-6 text-gray-700 space-y-1">
            <li>Buyer opens a dispute through their order page</li>
            <li>Seller is notified and can respond</li>
            <li>FairTrade reviews the case if needed</li>
            <li>A final decision is made</li>
        </ol>
    </section>

    <!-- SELLER RESPONSIBILITY -->
    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2">4. Seller Responsibilities</h2>
        <ul class="list-disc pl-6 text-gray-700 space-y-1">
            <li>Provide accurate product descriptions</li>
            <li>Ship items within the stated deadline</li>
            <li>Resolve disputes in good faith</li>
        </ul>
    </section>

    <!-- SHIPPING -->
    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2">5. Shipping & Refund Timing</h2>
        <p class="text-gray-700">
            If an item is not shipped within the required timeframe, buyers may be eligible for a refund.
            Shipping delays marked as late may impact seller performance and refund decisions.
        </p>
    </section>

    <!-- PAYMENT -->
    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2">6. Refund Method</h2>
        <p class="text-gray-700">
            Approved refunds will be issued through the original payment method where possible.
            Processing times may vary depending on payment providers.
        </p>
    </section>

    <!-- ABUSE -->
    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2">7. Abuse of Refund System</h2>
        <p class="text-gray-700">
            FairTrade reserves the right to suspend accounts that abuse the refund or dispute system,
            including fraudulent claims or repeated misuse.
        </p>
    </section>

    <!-- PLATFORM ROLE -->
    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2">8. Platform Role</h2>
        <p class="text-gray-700">
            FairTrade acts as an intermediary between buyers and sellers. While we assist in dispute resolution,
            final responsibility for transactions lies with the parties involved.
        </p>
    </section>

    <!-- CONTACT -->
    <section>
        <h2 class="text-xl font-semibold mb-2">9. Contact</h2>
        <p class="text-gray-700">
            For refund-related questions, please contact support through the platform.
        </p>
    </section>

</div>

</x-app-layout>