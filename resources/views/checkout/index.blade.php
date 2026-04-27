@php
    function finalPrice($product) {
        if ($product->discount_percentage && $product->discount_ends_at && now()->lt($product->discount_ends_at)) {
            return $product->price - ($product->price * $product->discount_percentage / 100);
        }
        return $product->price;
    }
@endphp

<x-app-layout>
    <div class="bg-gray-100 min-h-screen py-10">

        <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow">

            <h2 class="text-2xl font-bold mb-6">Checkout</h2>

            <form method="POST" action="{{ route('checkout.review') }}">
                @csrf

                <div class="bg-gray-50 p-4 rounded-xl mb-6">
                    <h3 class="font-bold mb-3">Payment Method</h3>

                    <div class="space-y-3">

                        <label class="flex items-center gap-3 border p-3 rounded-xl cursor-pointer">
                            <input type="radio" name="payment_method" value="card" required>
                            <span>Card Payment</span>
                        </label>

                        <label class="flex items-center gap-3 border p-3 rounded-xl cursor-pointer">
                            <input type="radio" name="payment_method" value="eft" required>
                            <span>EFT / Bank Transfer</span>
                        </label>

                        <label class="flex items-center gap-3 border p-3 rounded-xl cursor-pointer">
                            <input type="radio" name="payment_method" value="ozow" required>
                            <span>Ozow Instant EFT</span>
                        </label>

                        <label class="flex items-center gap-3 border p-3 rounded-xl cursor-pointer">
                            <input type="radio"
                                name="payment_method"
                                value="cod"
                                {{ $total > 2000 ? 'disabled' : '' }}
                                required>
                            <span>
                                Cash on Delivery
                                <span class="text-xs text-gray-500">(Limit: R2,000)</span>
                            </span>
                        </label>

                        @if($total > 2000)
                            <p class="text-sm text-red-500">
                                Cash on Delivery is only available for orders up to R2,000.
                            </p>
                        @endif

                    </div>

                    @error('payment_method')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SHIPPING INFO -->
                <div class="bg-gray-50 p-4 rounded-xl mb-6">
                    <h3 class="font-bold mb-3">Shipping Information</h3>

                    <!-- Name -->
                    <input type="text" name="shipping_name"
                        value="{{ old('shipping_name') }}"
                        placeholder="Full Name"
                        class="w-full border border-gray-400 p-2 mb-2 rounded-xl"
                        required>
                    @error('shipping_name')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror

                    <!-- Phone -->
                    <input type="text" name="shipping_phone"
                        value="{{ old('shipping_phone') }}"
                        placeholder="Phone Number"
                        class="w-full border border-gray-400 p-2 mb-2 rounded-xl"
                        required>
                    @error('shipping_phone')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror

                    <!-- Address -->
                    <textarea name="shipping_address"
                        placeholder="Street Address"
                        class="w-full border border-gray-400 p-2 mb-2 rounded-xl"
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
                                class="w-full border border-gray-400 p-2 rounded-xl"
                                required>
                            @error('shipping_city')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <input type="text" name="shipping_postal_code"
                                value="{{ old('shipping_postal_code') }}"
                                placeholder="Postal Code"
                                class="w-full border border-gray-400 p-2 rounded-xl"
                                required>
                            @error('shipping_postal_code')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <select name="shipping_province"
                            class="w-full border border-gray-400 p-2 mt-2 rounded-xl"
                            required>
                        <option value="">Select Province</option>

                        @foreach(config('provinces') as $province)
                            <option value="{{ $province }}" {{ old('shipping_province') === $province ? 'selected' : '' }}>
                                {{ $province }}
                            </option>
                        @endforeach
                    </select>

                    @error('shipping_province')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror

                    <input type="text" name="shipping_country"
                        value="{{ old('shipping_country') }}"
                        placeholder="Country"
                        class="w-full border border-gray-400 p-2 mt-2 rounded-xl"
                        required>
                    @error('shipping_country')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror

                    <!-- Country -->
                    <input type="text" name="shipping_country"
                        value="{{ old('shipping_country') }}"
                        placeholder="Country"
                        class="w-full border border-gray-400 p-2 mt-2 rounded-xl"
                        required>
                    @error('shipping_country')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SUBMIT -->
                <button class="w-full bg-green-600 text-black font-semibold py-3 rounded-3xl hover:bg-green-700 transition">
                    Confirm Order
                </button>

            </form>

        </div>

    </div>
</x-app-layout>