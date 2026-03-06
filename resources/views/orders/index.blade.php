<x-app-layout>

<h2>Your Orders</h2>

<table border="1">

<thead>
<tr>
<th>Product</th>
<th>Quantity</th>
<th>Total</th>
<th>Status</th>
<th>Ordered At</th>
</tr>
</thead>

<tbody>

@foreach($orders as $order)

<tr>

<td>{{ $order->product->name }}</td>

<td>{{ $order->quantity }}</td>

<td>${{ $order->total_amount }}</td>

<td>{{ $order->status }}</td>

<td>{{ $order->created_at }}</td>

</tr>

@endforeach

</tbody>

</table>

</x-app-layout>