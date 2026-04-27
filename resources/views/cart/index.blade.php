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
    <div class="max-w-7xl mx-auto px-4">

        <h2 class="text-2xl font-bold mb-6">Your Cart</h2>

        @if($items->isEmpty())
            <div class="bg-white p-10 rounded-xl shadow text-center">
                <p class="text-gray-500 mb-4">Your cart is empty.</p>

                <a href="/" class="bg-white hover:bg-blue-300 text-black py-2 px-4 rounded-3xl text-sm border border-gray-400 shadow-md">
                    Continue Shopping
                </a>
            </div>
        @else

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- LEFT: Cart Items -->
                <div class="lg:col-span-2 space-y-6">

                    @foreach($items as $item)
                        @php 
                            $image = $item->product->images->first(); 
                            $product = $item->product;
                            $price = finalPrice($product);
                        @endphp

                        <div class="bg-white rounded-xl shadow p-4 flex flex-col md:flex-row gap-4">
                            <!-- Image -->
                            <div class="w-24 h-24 flex-shrink-0 overflow-hidden rounded-xl">
                                <img src="{{ $image ? asset('storage/' . $image->image_path) : '/placeholder.png' }}"
                                    class="w-full h-full object-cover rounded-xl hover:scale-105 transition-transform">
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="font-semibold text-gray-800">{{ $item->product->name }}</h3>
                                    <div class="mt-1">
                                        <span class="font-bold text-black ml-2">
                                            R{{ number_format($price * $item->quantity, 2) }}
                                        </span>

                                        @if($price < $product->price)
                                            <span class="line-through text-gray-400 text-sm">
                                                R{{ number_format($product->price * $item->quantity, 2) }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- FREE SHIPPING -->
                                    @if($product->free_shipping)
                                        <span class="text-xs text-green-600">FREE SHIPPING</span>
                                    @endif
                                </div>

                                <!-- Quantity & Actions -->
                                <div class="flex items-center gap-4 mt-3">
                                    <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity"  value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock_quantity }}"
                                            class="border border-gray-300 rounded-xl w-16 text-center focus:ring focus:ring-blue-300 focus:outline-none">
                                        <button type="submit" 
                                            class="text-blue-600 text-md hover:underline"
                                            onclick="this.innerText='Updating...'">
                                            Update
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500 text-md">Remove</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="flex-shrink-0 text-right mt-2 md:mt-0">
                                <div class="mt-1">
                                    <span class="font-bold text-black ml-2">
                                        R{{ number_format($price * $item->quantity, 2) }}
                                    </span>
                                    
                                    @if($price < $product->price)
                                        <span class="line-through text-gray-400 text-sm">
                                            R{{ number_format($product->price * $item->quantity, 2) }}
                                        </span>
                                    @endif
                                </div>
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

                    <div class="border-t border-gray-200 pt-3 flex justify-between font-bold text-gray-800">
                        <span>Total</span>
                        <span>R{{ number_format($total + ($shipping ?? 0) - ($discount ?? 0), 2) }}</span>
                    </div>

                    <div class="mt-3 mb-6">
                       <form method="GET" action="{{ route('checkout.index') }}">
                            <button
                                class="w-full py-3 rounded-3xl font-semibold shadow-md transition mb-2
                                {{ $items->isEmpty() 
                                    ? 'bg-gray-300 cursor-not-allowed text-gray-500' 
                                    : 'bg-black hover:bg-gray-800 text-white' }}"
                                {{ $items->isEmpty() ? 'disabled' : '' }}>

                                Proceed To Checkout

                            </button>
                        </form>

                        <!-- CONTINUE SHOPPING -->
                         <button
                            class="w-full mt-2 py-3 rounded-3xl font-semibold shadow-md transition
                            bg-gray-200 hover:bg-gray-200 text-gray-800"
                            onclick="window.location.href='/'">

                            Continue Shopping
                        </button>
                    </div>

                    <div>
                        <form method="POST" action="{{ route('cart.clear') }}">
                            @csrf
                            @method('DELETE')

                            <button class="text-red-500 text-mb mb-4">
                                Clear Cart
                            </button>
                        </form>
                    </div>

                </div>

            </div>
        @endif
    </div>
</div>
</x-app-layout>