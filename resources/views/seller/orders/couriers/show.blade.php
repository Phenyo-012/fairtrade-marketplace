<x-app-layout>
    <div class="bg-gray-100 min-h-screen">
        <div class="max-w-5xl mx-auto px-4">

            <!-- BACK TO COURIERS -->
            <a href="{{ route('seller.orders.couriers', $order) }}" class="px-4 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                    </path>
                </svg>
            </a>

            <div class="bg-white rounded-xl shadow p-6 mt-3 mb-6">
                <h1 class="text-2xl font-bold">{{ $courier['name'] }} API Simulation</h1>
                <p class="text-gray-500 text-sm mt-1">
                    This simulates what a real courier API integration would look like.
                </p>
            </div>

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid md:grid-cols-3 gap-6">

                <div class="md:col-span-2 bg-white rounded-xl shadow p-6">
                    <h2 class="font-bold text-lg mb-4">Shipment Details</h2>

                    <div class="bg-gray-50 border rounded-xl p-4 mb-6 text-sm">
                        <p><strong>Pickup From:</strong> {{ $order->sellerProfile->store_name ?? 'Seller Store' }}</p>
                        <p><strong>Deliver To:</strong> {{ $order->shipping_name }}</p>
                        <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
                        <p><strong>City:</strong> {{ $order->shipping_city }}</p>
                        <p><strong>Province:</strong> {{ $order->shipping_province }}</p>
                        <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
                    </div>

                    <form method="POST" action="{{ route('seller.orders.couriers.book', [$order, $courierKey]) }}">
                        @csrf

                        <label class="block font-semibold mb-2">Courier Service</label>
                        <select name="service" class="w-full border rounded-xl p-3 mb-4" required>
                            <option value="">Choose service</option>
                            @foreach($courier['services'] as $service)
                                <option value="{{ $service['name'] }}">
                                    {{ $service['name'] }} — {{ $service['days'] }} — R{{ number_format($service['fee'], 2) }}
                                </option>
                            @endforeach
                        </select>

                        <label class="block font-semibold mb-2">Parcel Weight (kg)</label>
                        <input type="number"
                               step="0.1"
                               min="0.1"
                               name="parcel_weight"
                               class="w-full border rounded-xl p-3 mb-4"
                               placeholder="Example: 1.5"
                               required>

                        <label class="block font-semibold mb-2">Courier Notes</label>
                        <textarea name="parcel_notes"
                                  class="w-full border rounded-xl p-3 mb-4"
                                  rows="4"
                                  placeholder="Fragile item, pickup instructions, packaging notes..."></textarea>

                        <button class="w-full bg-green-600 text-black font-semibold py-3 rounded-3xl hover:bg-green-700"
                                {{ !$order->can_seller_ship ? 'disabled' : '' }}>
                            Book Courier & Mark as Shipped
                        </button>

                        @if(!$order->can_seller_ship)
                            <p class="text-sm text-red-500 mt-3">
                                Courier booking is locked until the buyer cancellation period expires.
                            </p>
                        @endif
                    </form>
                </div>

                <div class="bg-white rounded-xl shadow p-6 h-fit">
                    <h2 class="font-bold text-lg mb-4">API Simulation</h2>

                    <div class="space-y-3 text-sm text-gray-600">
                        <p>1. Validate seller and order</p>
                        <p>2. Send parcel details to courier</p>
                        <p>3. Courier returns quote</p>
                        <p>4. Seller confirms service</p>
                        <p>5. Tracking number is generated</p>
                        <p>6. Order status changes to shipped</p>
                    </div>

                    <div class="mt-5 bg-gray-100 rounded-xl p-3 text-xs">
                        Endpoint simulation:<br>
                        <code>POST /api/courier/{{ $courierKey }}/shipments</code>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>