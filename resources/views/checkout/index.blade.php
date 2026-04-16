<x-app-layout>
<div class="bg-gray-100 min-h-screen py-10">

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow">

        <h2 class="text-2xl font-bold mb-6">Checkout</h2>

        <form method="POST" action="{{ route('checkout.store') }}">
            @csrf

            <!-- ======================== -->
            <!-- ORDER SUMMARY -->
            <!-- ======================== -->
            <div class="mb-6">
                @foreach($items as $item)
                    <div class="flex justify-between mb-2">
                        <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                        <span>R{{ number_format($item->product->price * $item->quantity, 2) }}</span>
                    </div>
                @endforeach

                <div class="border-t mt-4 pt-4 flex justify-between font-bold">
                    <span>Total</span>
                    <span>R{{ number_format($total, 2) }}</span>
                </div>
            </div>

            <!-- ======================== -->
            <!-- SHIPPING INFO -->
            <!-- ======================== -->
            <div class="bg-gray-50 p-4 rounded mb-6">
                <h3 class="font-bold mb-3">Shipping Information</h3>

                <!-- Name -->
                <input type="text" name="shipping_name"
                    value="{{ old('shipping_name') }}"
                    placeholder="Full Name"
                    class="w-full border p-2 mb-2 rounded"
                    required>
                @error('shipping_name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror

                <!-- Phone -->
                <input type="text" name="shipping_phone"
                    value="{{ old('shipping_phone') }}"
                    placeholder="Phone Number"
                    class="w-full border p-2 mb-2 rounded"
                    required>
                @error('shipping_phone')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror

                <!-- Address -->
                <textarea name="shipping_address"
                    placeholder="Street Address"
                    class="w-full border p-2 mb-2 rounded"
                    required>{{ old('shipping_address') }}</textarea>
                @error('shipping_address')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror

                <!-- City + Postal -->
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <input type="text" name="shipping_city"
                            value="{{ old('shipping_city') }}"
                            placeholder="City"
                            class="w-full border p-2 rounded"
                            required>
                        @error('shipping_city')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <input type="text" name="shipping_postal_code"
                            value="{{ old('shipping_postal_code') }}"
                            placeholder="Postal Code"
                            class="w-full border p-2 rounded"
                            required>
                        @error('shipping_postal_code')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Country -->
                <input type="text" name="shipping_country"
                    value="{{ old('shipping_country') }}"
                    placeholder="Country"
                    class="w-full border p-2 mt-2 rounded"
                    required>
                @error('shipping_country')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- ======================== -->
            <!-- SUBMIT -->
            <!-- ======================== -->
            <button class="w-full bg-green-600 text-white py-3 rounded hover:bg-green-700 transition">
                Confirm Order
            </button>

        </form>

    </div>

</div>
</x-app-layout>