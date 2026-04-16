<x-app-layout>
    <div class="bg-gray-100 min-h-screen py-10">

        <div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow">

            <h2 class="text-2xl font-bold mb-6 text-green-600">
                ✅ Orders Placed Successfully!
            </h2>

            @foreach($orders as $order)
                <div class="border rounded-lg p-4 mb-6">

                    <!-- ORDER HEADER -->
                    <div class="flex justify-between mb-4">
                        <div>
                            <p class="font-bold">Order #{{ $order->id }}</p>
                            <p class="text-sm text-gray-500">
                                Delivery Code:
                                <span class="font-bold text-green-700">
                                    {{ $order->delivery_code }}
                                </span>
                            </p>
                        </div>

                        <span class="text-sm bg-gray-200 px-3 py-1 rounded-xl">
                            {{ ucfirst(str_replace('_',' ', $order->status)) }}
                        </span>
                    </div>

                    <!-- ITEMS -->
                    @foreach($order->orderItems as $item)
                        <div class="flex items-center gap-4 border-b py-3">

                            <!-- IMAGE -->
                            @if($item->product->images->count())
                                <img src="{{ asset('storage/'.$item->product->images->first()->image_path) }}"
                                    class="w-16 h-16 object-cover rounded-xl">
                            @else
                                <img src="/placeholder.png"
                                    class="w-16 h-16 object-cover rounded-xl">
                            @endif

                            <!-- INFO -->
                            <div class="flex-1">
                                <p class="font-semibold">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-500">
                                    Qty: {{ $item->quantity }}
                                </p>
                            </div>

                            <!-- PRICE -->
                            <p class="font-bold">
                                R{{ number_format($item->subtotal, 2) }}
                            </p>
                        </div>
                    @endforeach

                    <!-- TOTAL -->
                    <div class="flex justify-between mt-4 font-bold">
                        <span>Order Total</span>
                        <span>R{{ number_format($order->total_amount, 2) }}</span>
                    </div>

                </div>
            @endforeach

            <a href="{{ route('orders.my') }}"
            class="block text-center bg-black text-white py-3 rounded-xl mt-6">
                View My Orders
            </a>

        </div>

    </div>
</x-app-layout>