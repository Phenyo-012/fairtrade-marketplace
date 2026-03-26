<x-app-layout>

<div class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-6xl mx-auto px-4">

        <h2 class="text-2xl font-bold mb-6">Orders</h2>

        @foreach($orders as $order)
            <a href="{{ route('seller.orders.show', $order) }}"
               class="block bg-white p-4 rounded-xl shadow mb-4 hover:shadow-md transition">

                <div class="flex justify-between">
                    <div>
                        <p class="font-semibold">Order #{{ $order->id }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $order->created_at->format('d M Y') }}
                        </p>
                    </div>

                    <span class="text-sm px-3 py-1 rounded bg-gray-200">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

            </a>
        @endforeach

    </div>
</div>

</x-app-layout>