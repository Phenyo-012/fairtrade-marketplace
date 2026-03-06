<x-app-layout>

<h2>My Products</h2>

<table border="1">
<thead>
<tr>
<th>Name</th>
<th>Price</th>
<th>Stock</th>
<th>Status</th>
</tr>
</thead>

<tbody>

@foreach($products as $product)

<tr>
<td>{{ $product->name }}</td>
<td>${{ $product->price }}</td>
<td>{{ $product->stock_quantity }}</td>

<td>
@if($product->is_approved)
Approved
@else
Pending Admin Approval
@endif
</td>

</tr>

@endforeach

</tbody>
</table>

</x-app-layout>