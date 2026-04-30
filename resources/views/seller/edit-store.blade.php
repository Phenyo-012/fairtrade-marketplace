<x-app-layout>
    <div class="max-w-3xl mx-auto py-3 px-4">

        <!-- BACK TO SELLER DASHBOARD -->
        <a href="{{ route('seller.dashboard') }}" class="mt-6 px-4 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                </path>
            </svg>
        </a>
    
        <div class="bg-white p-6 rounded-xl shadow">
            
            <h2 class="text-2xl font-bold mb-6">Edit Store</h2>

            @if(session('success'))
                <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif

            <form method="POST" action="{{ route('seller.store.update') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label>Store Name</label>
                    <input type="text" name="store_name"
                        value="{{ $seller->store_name }}"
                        class="w-full border p-2 rounded-xl">
                </div>

                <div class="mb-4">
                    <label>About</label>
                    <textarea name="about"
                            class="w-full border p-2 rounded-xl">{{ $seller->about }}</textarea>
                </div>

                <div>
                    <h3 class="font-bold mt-6 mb-3">Pickup Address</h3>
                    <div class="mb-2">
                        <textarea name="pickup_address" class="w-full border p-2 rounded-xl" placeholder="Street Address" required></textarea>
                    </div>

                    <div>
                        <input type="text" name="shipping_phone" placeholder="Phone Number" class="w-full border p-2 rounded-xl mb-2" required>
                    </div>

                    <div class="mb-4">
                        <input type="text" name="pickup_city" class="w-full border p-2 mt-2 rounded-xl" placeholder="City" required>
                    </div>

                    <select name="pickup_province" class="w-full border rounded-xl p-2 mb-4" required>
                        <option value="">Select Province</option>

                        @foreach(config('provinces') as $province)
                            <option value="{{ $province }}" {{ old('pickup_province', $sellerProfile->pickup_province ?? '') === $province ? 'selected' : '' }}>
                                {{ $province }}
                            </option>
                        @endforeach
                    </select>

                    <div class="mb-4">
                        <input type="text" name="pickup_postal_code" class="w-full border p-2 mt-2 rounded-xl" placeholder="Postal Code" required> 
                    </div>

                    <div class="mb-4">
                        <input type="text" name="pickup_country" class="w-full border p-2 mt-2 rounded-xl" placeholder="Country" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-2">Logo</label>
                    <input type="file" name="logo" class="w-full p-2 rounded-xl">
                </div>

                <button class="bg-blue-600 text-white px-4 py-2 rounded-3xl">
                    Update Store
                </button>
            </form>

        </div>
    </div>
    

</x-app-layout>