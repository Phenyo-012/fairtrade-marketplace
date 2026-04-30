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

        <form method="POST" action="{{ route('seller.onboarding.store') }}" enctype="multipart/form-data">
            @csrf

            <label class="font-semibold">Store Name</label>
            <input name="store_name"
                value="{{ old('store_name', $seller->store_name === 'Untitled Store' ? '' : $seller->store_name) }}"
                placeholder="Store Name"
                class="border p-2 w-full mb-3 rounded-3xl"
                required>

            <label class="font-semibold">Store About</label>
            <textarea name="about"
                placeholder="About your store"
                class="border p-2 w-full mb-3 rounded-3xl"
                required>{{ old('about', $seller->about) }}</textarea>

            <label class="font-semibold">Store logo</label>
            <br/>
            <input type="file" name="logo" class="mb-3"><br/>

            <label class="font-semibold">Pickup Address</label>
            <input name="pickup_address"
                value="{{ old('pickup_address', $seller->pickup_address) }}"
                placeholder="Pickup Address"
                class="border p-2 w-full mb-3 rounded-3xl"
                required>

            <label class="font-semibold">Pickup City</label>
            <input name="pickup_city"
                value="{{ old('pickup_city', $seller->pickup_city) }}"
                placeholder="Pickup City"
                class="border p-2 w-full mb-3 rounded-3xl"
                required>

            <label class="font-semibold">Pickup Province</label>
            <select name="pickup_province" class="border p-2 w-full mb-3 rounded-3xl" required>
                <option value="">Select Pickup Province</option>

                @foreach(config('provinces') as $province)
                    <option value="{{ $province }}"
                        {{ old('pickup_province', $seller->pickup_province) === $province ? 'selected' : '' }}>
                        {{ $province }}
                    </option>
                @endforeach
            </select>

            <label class="font-semibold">Pickup Postal Code</label>
            <input name="pickup_postal_code"
                value="{{ old('pickup_postal_code', $seller->pickup_postal_code) }}"
                placeholder="Pickup Postal Code"
                class="border p-2 w-full mb-3 rounded-3xl"
                required>

            <label class="font-semibold">Pickup Country</label>
            <input name="pickup_country"
                value="{{ old('pickup_country', $seller->pickup_country ?? 'South Africa') }}"
                placeholder="Pickup Country"
                class="border p-2 w-full mb-3 rounded-3xl"
                required>

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

            <label class="font-semibold">ID Document:</label>
            <br/>
            <input type="file" name="id_document" class="mb-3" required>
            <br/>
            <label class="font-semibold">Selfie:</label>
            <br/>
            <input type="file" name="selfie_document" class="mb-3" required>
            <br/>
            <br/>
            <br/>

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