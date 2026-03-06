<x-app-layout>

<h2>Products Pending Approval</h2>

<table border="1">

<thead>
<tr>
<th>Name</th>
<th>Seller</th>
<th>Price</th>
<th>Action</th>
</tr>
</thead>

<tbody>

@foreach($products as $product)

<tr>

<td>{{ $product->name }}</td>

<td>{{ $product->sellerProfile->store_name }}</td>

<td>${{ $product->price }}</td>

<td>

<form method="POST" action="/admin/products/{{ $product->id }}/approve">

@csrf

<button type="submit">Approve</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</x-app-layout>