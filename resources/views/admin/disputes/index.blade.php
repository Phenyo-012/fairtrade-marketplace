<x-app-layout>

<div class="max-w-5xl mx-auto mt-10">

<h2 class="text-2xl font-bold mb-6">Disputes</h2>

<table class="w-full border">

<tr class="bg-gray-200">
<th class="p-2">ID</th>
<th class="p-2">Order</th>
<th class="p-2">Buyer</th>
<th class="p-2">Reason</th>
<th class="p-2">Status</th>
<th class="p-2">Action</th>
</tr>

@foreach($disputes as $dispute)

<tr class="border-t">

<td class="p-2">{{ $dispute->id }}</td>

<td class="p-2">
Order #{{ $dispute->order->id }}
</td>

<td class="p-2">
{{ $dispute->openedBy->name ?? 'User' }}
</td>

<td class="p-2">
{{ $dispute->reason }}
</td>

<td class="p-2">

@if($dispute->status == 'open')
<span class="text-red-500">Open</span>
@elseif($dispute->status == 'under_review')
<span class="text-orange-500">Under Review</span>
@elseif($dispute->status == 'resolved')
<span class="text-green-600">Resolved</span>
@else
<span class="text-gray-500">Rejected</span>
@endif

</td>

<td class="p-2">

<a href="{{ route('admin.disputes.show', $dispute) }}"
   class="text-blue-600 underline">
View
</a>

</td>

</tr>

@endforeach

</table>

</div>

</x-app-layout>