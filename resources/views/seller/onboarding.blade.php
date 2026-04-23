<x-app-layout>

<div x-data="{ step: {{ $seller->onboarding_step }} }" class="max-w-3xl mx-auto mt-10">

    <!-- PROGRESS BAR -->
    <div class="mb-6">
        <div class="flex justify-between text-sm mb-2">
            <span>Store</span>
            <span>KYC</span>
            <span>Review</span>
        </div>

        <div class="w-full bg-gray-200 h-2 rounded-xl">
            <div class="bg-blue-600 h-2 rounded-xl"
                 :style="'width:' + (step * 33) + '%'">
            </div>
        </div>
    </div>

    <!-- STEP 1 -->
    <div x-show="step === 1">
        <h2 class="text-xl font-bold mb-4">Set Up Your Store</h2>

        <form method="POST" action="/seller/onboarding/store">
            @csrf

            <input name="store_name" placeholder="Store Name"
                   class="border p-2 w-full mb-3 rounded-3xl" required>

            <textarea name="about" placeholder="About your store"
                      class="border p-2 w-full mb-3 rounded-3xl"></textarea>

            <button class="bg-white text-black border border-gray-400 px-4 py-2 rounded-3xl hover:bg-blue-300 shadow-md">
                Continue
            </button>
        </form>
    </div>

    <!-- STEP 2 -->
    <div x-show="step === 2">
        <h2 class="text-xl font-bold mb-4">Verify Identity</h2>

        <form method="POST" action="/seller/onboarding/kyc" enctype="multipart/form-data">
            @csrf

            <input type="file" name="id_document" class="mb-3" required>
            <input type="file" name="selfie_document" class="mb-3" required>

            <button class="bg-white text-black border border-gray-400 px-4 py-2 rounded-3xl hover:bg-blue-300 shadow-md">
                Submit Verification
            </button>
        </form>
    </div>

    <!-- STEP 3 -->
    <div x-show="step === 3">
        <h2 class="text-xl font-bold mb-4">Under Review</h2>

        <div class="bg-yellow-100 p-4 rounded-xl text-yellow-700">
            Your documents are being reviewed by our team.
        </div>

        <a href="/seller/dashboard"
           class="mt-4 inline-block bg-gray-800 text-white px-4 py-2 rounded-xl">
            Go to Dashboard
        </a>
    </div>

</div>

</x-app-layout>