<x-app-layout>
<div class="max-w-xl mx-auto mt-20 text-center">

    <h2 class="text-2xl font-bold mb-4">
        Verification Pending
    </h2>

    <p class="text-gray-600 mb-6">
        Your seller account is currently under review.
        You will be notified once approved.
    </p>

    <div class="bg-yellow-100 text-yellow-700 p-4 rounded-xl">
        Status: {{ auth()->user()->sellerProfile->verification_status }}
    </div>

</div>
</x-app-layout>