<x-app-layout>

<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">

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
                   class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label>About</label>
            <textarea name="about"
                      class="w-full border p-2 rounded">{{ $seller->about }}</textarea>
        </div>

        <div>
            <h3 class="font-bold mt-6 mb-3">Pickup Address</h3>
            <div class="mb-2">
                <textarea name="pickup_address" class="w-full border p-2" placeholder="Street Address" required></textarea>
            </div>

            <div>
                <input type="text" name="shipping_phone" placeholder="Phone Number" class="w-full border p-2 mb-2" required>
            </div>

            <div class="mb-4">
                <input type="text" name="pickup_city" class="w-full border p-2 mt-2" placeholder="City" required>
            </div>

            <div class="mb-4">
                <input type="text" name="pickup_postal_code" class="w-full border p-2 mt-2" placeholder="Postal Code" required> 
            </div>

            <div class="mb-4">
                <input type="text" name="pickup_country" class="w-full border p-2 mt-2" placeholder="Country" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-2">Logo</label>
            <input type="file" name="logo" class="w-full p-2 rounded">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Update Store
        </button>
    </form>

</div>

</x-app-layout>