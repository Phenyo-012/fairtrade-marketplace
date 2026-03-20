<x-app-layout>
<div class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4">

        <h2 class="text-2xl font-bold mb-6">Your Cart</h2>

        @if($items->isEmpty())
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <p class="text-gray-500">Your cart is empty.</p>
            </div>
        @else

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- LEFT: Cart Items -->
            <div class="lg:col-span-2 space-y-6">

                @foreach($items as $item)
                    @php $image = $item->product->images->first(); @endphp

                    <div class="bg-white rounded-xl shadow p-4 flex flex-col md:flex-row gap-4">
                        <!-- Image -->
                        <div class="w-24 h-24 flex-shrink-0 overflow-hidden rounded">
                            <img src="{{ $image ? asset('storage/' . $image->image_path) : '/placeholder.png' }}"
                                 class="w-full h-full object-cover rounded hover:scale-105 transition-transform">
                        </div>

                        <!-- Product Info -->
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    R{{ number_format($item->product->price, 2) }}
                                </p>
                            </div>

                            <!-- Quantity & Actions -->
                            <div class="flex items-center gap-4 mt-3">
                                <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}"
                                           class="w-16 border rounded text-center">
                                    <button type="submit" class="text-blue-600 text-sm">Update</button>
                                </form>

                                <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 text-sm">Remove</button>
                                </form>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="flex-shrink-0 text-right mt-2 md:mt-0">
                            <p class="font-bold text-gray-800">
                                R{{ number_format($item->product->price * $item->quantity, 2) }}
                            </p>
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- RIGHT: Order Summary -->
            <div class="lg:col-span-1 flex flex-col bg-white rounded-xl shadow p-6 space-y-4">

                <h3 class="text-lg font-semibold text-gray-800 mb-2">Order Summary</h3>

                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span class="font-semibold">R{{ number_format($total, 2) }}</span>
                </div>

                @if($discount ?? false)
                <div class="flex justify-between text-green-600">
                    <span>Discount</span>
                    <span>-R{{ number_format($discount, 2) }}</span>
                </div>
                @endif

                <div class="flex justify-between">
                    <span>Shipping</span>
                    <span class="font-semibold">R{{ number_format($shipping ?? 0, 2) }}</span>
                </div>

                <div class="border-t border-gray-200 pt-3 flex justify-between font-bold text-gray-800">
                    <span>Total</span>
                    <span>R{{ number_format($total + ($shipping ?? 0) - ($discount ?? 0), 2) }}</span>
                </div>

                <div class="mt-3 mb-6">
                    <button class="w-full bg-black text-black py-2 rounded-md hover:bg-gray-800 transition">
                        <p class="text-white">Proceed To Checkout</p>
                    </button>

                </div>

            </div>

        </div>
        @endif
    </div>
</div>
</x-app-layout>