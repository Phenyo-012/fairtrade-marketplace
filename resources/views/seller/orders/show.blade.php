<x-app-layout>

<div class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4">

        <h2 class="text-2xl font-bold mb-6">
            Order #{{ $order->id }}
        </h2>

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- ITEMS -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h3 class="font-semibold mb-4">Your Items</h3>

            @foreach($items as $item)
                <div class="flex justify-between border-b py-3">
                    <div>
                        <p class="font-medium">{{ $item->product->name }}</p>
                        <p class="text-sm text-gray-500">
                            Qty: {{ $item->quantity }}
                        </p>
                    </div>

                    <p class="font-semibold">
                        R{{ number_format($item->subtotal, 2) }}
                    </p>
                </div>
            @endforeach
        </div>

        <!-- STATUS UPDATE -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="font-semibold mb-4">Update Status</h3>

            <form method="POST" action="{{ route('seller.orders.updateStatus', $order) }}">
                @csrf
                @method('PATCH')

                <select name="status" class="border rounded p-2 w-full mb-4">
                    <option value="awaiting_shipment">Awaiting shipment</option>
                    <option value="shipped">Shipped</option>
                </select>

                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Update Status
                </button>
            </form>
        </div>

    </div>
</div>

</x-app-layout>