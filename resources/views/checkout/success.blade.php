<x-app-layout>

<div class="bg-gray-100 min-h-screen py-10">

    <div class="max-w-4xl mx-auto px-4">

        <div class="bg-white p-6 rounded-xl shadow space-y-6">

            <!-- SUCCESS MESSAGE -->
            <div>
                <h2 class="text-2xl font-bold text-green-600">
                    🎉 Order Placed Successfully!
                </h2>

                <p class="text-gray-600 mt-2">
                    Your delivery code:
                    <span class="font-bold text-blue-600 text-lg">
                        {{ $order->delivery_code }}
                    </span>
                </p>
            </div>

            <!-- ORDER ITEMS -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Order Items</h3>

                <div class="space-y-4">

                    @foreach($order->items as $item)
                        @php $image = $item->product->images->first(); @endphp

                        <div class="flex items-center gap-4 border-b pb-4">

                            <!-- Image -->
                            <div class="w-20 h-20 flex-shrink-0 mb-6">
                                <img 
                                    src="{{ $image ? asset('storage/' . $image->image_path) : '/placeholder.png' }}"
                                    class="w-full h-full object-cover rounded"
                                >
                            </div>

                            <!-- Info -->
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">
                                    {{ $item->product->name }}
                                </p>

                                <p class="text-sm text-gray-500">
                                    Quantity: {{ $item->quantity }}
                                </p>

                                <p class="text-sm text-gray-500">
                                    Unit Price: R{{ number_format($item->unit_price, 2) }}
                                </p>
                            </div>

                            <!-- Subtotal -->
                            <div class="text-right">
                                <p class="font-bold text-gray-800">
                                    R{{ number_format($item->subtotal, 2) }}
                                </p>
                            </div>

                        </div>
                    @endforeach

                </div>
            </div>

            <!-- TOTAL -->
            <div class="border-t pt-4 flex justify-between text-lg font-bold">
                <span>Total</span>
                <span>R{{ number_format($order->total_amount, 2) }}</span>
            </div>

            <!-- ACTION -->
            <div class="pt-4">
                <a href="{{ route('marketplace.index') }}"
                   class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Continue Shopping
                </a>
            </div>

        </div>

    </div>

</div>

</x-app-layout>