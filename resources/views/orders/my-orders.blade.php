<x-app-layout>

<div class="max-w-4xl mx-auto mt-10">

<h2 class="text-2xl font-bold mb-6">My Orders</h2>

<table class="w-full border">

<tr class="bg-gray-200">
<th class="p-2">Order ID</th>
<th class="p-2">Status</th>
<th class="p-2">Delivery Code</th>
</tr>

@foreach($orders as $order)

<tr class="border-t">
    <td class="p-2">{{ $order->id }}</td>
    <td class="p-2 font-semibold">
        @switch($order->status)
            @case('pending')
                <span class="text-gray-500">Pending</span>
            @break
            @case('awaiting_shipment')
                <span class="text-blue-500">Awaiting Shipment</span>
            @break
            @case('shipped')
                <span class="text-orange-500">Shipped</span>
            @break
            @case('delivered')
                <span class="text-green-600">Delivered</span>
            @break
            @case('disputed')
                <span class="text-red-600">Disputed</span>
            @break
            @case('completed')
                <span class="text-green-800">Completed</span>
            @break
            @case('cancelled')
                <span class="text-red-500">Cancelled</span>
            @break
        @endswitch

        {{-- Progress Bar --}}
        <div class="w-full bg-gray-200 rounded h-2 mt-1">
            <div class="bg-green-500 h-2 rounded"
                 style="width: @switch($order->status)
                            @case('pending') 10% @break
                            @case('awaiting_shipment') 30% @break
                            @case('shipped') 60% @break
                            @case('delivered') 90% @break
                            @case('completed') 100% @break
                            @default 0%
                        @endswitch;">
            </div>
        </div>
    </td>
    <td class="p-2 font-bold text-green-700">
        {{ $order->delivery_code }}
    </td>
</tr>

@endforeach

</table>

</div>

</x-app-layout>