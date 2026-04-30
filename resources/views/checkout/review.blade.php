<x-app-layout>
    <div class="bg-gray-100 min-h-screen py-10 px-4">
        <div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow">

            <h2 class="text-2xl font-bold mb-6">Order Breakdown</h2>

            <div class="space-y-4 mb-6">
                @foreach($breakdown as $row)
                    @php
                        $item = $row['item'];
                        $product = $item->product;
                    @endphp

                    <div class="border rounded-xl p-4 flex justify-between gap-4">
                        <div>
                            <p class="font-bold">{{ $product->name }}</p>
                            <p class="text-sm text-gray-500">
                                Qty: {{ $item->quantity }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Size: {{ ucfirst($product->shipping_size ?? 'small') }}
                            </p>
                        </div>

                        <div class="text-right text-sm">
                            <p>Item Price: R{{ number_format($row['unit_price'], 2) }}</p>
                            <p>Items Subtotal: R{{ number_format($row['subtotal'], 2) }}</p>
                            <p>Shipping: R{{ number_format($row['shipping_fee'], 2) }}</p>
                            <p class="font-bold mt-2">
                                Total: R{{ number_format($row['total'], 2) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">
                                Seller Province: {{ $product->sellerProfile->pickup_province ?? 'Unknown' }}
                            </p>

                            <p class="text-sm text-gray-500">
                                Delivery Province: {{ $data['shipping_province'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-gray-50 p-4 rounded-xl mb-6 space-y-2">
                <div class="flex justify-between">
                    <span>Items Total</span>
                    <span>R{{ number_format($itemsTotal, 2) }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Shipping Total</span>
                    <span>R{{ number_format($shippingTotal, 2) }}</span>
                </div>

                <div class="border-t pt-3 flex justify-between font-bold text-lg">
                    <span>Total Payment Due</span>
                    <span>R{{ number_format($grandTotal, 2) }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('checkout.payment.prepare') }}">
                @csrf

                <button class="w-full bg-green-600 text-black font-semibold py-3 rounded-3xl hover:bg-green-700 transition">
                    Continue to Payment
                </button>
            </form>

            <a href="{{ route('checkout.index') }}"
            class="block text-center mt-4 text-sm text-blue-600 hover:underline">
                Back to checkout
            </a>

        </div>
    </div>
</x-app-layout>