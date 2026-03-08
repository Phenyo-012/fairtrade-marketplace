<x-app-layout>

<div class="max-w-3xl mx-auto mt-10">

<h2 class="text-2xl font-bold mb-4">
Dispute #{{ $dispute->id }}
</h2>

<div class="mb-4">

<strong>Order:</strong> {{ $dispute->order->id }}

</div>

<div class="mb-4">

<strong>Reason:</strong> {{ $dispute->reason }}

</div>

<div class="mb-4">

<strong>Description:</strong>

<p class="border p-3 mt-1">
{{ $dispute->description }}
</p>

</div>

<form method="POST"
      action="{{ route('admin.disputes.resolve', $dispute) }}">

@csrf

<label class="block mb-2">Resolution Notes</label>

<textarea name="resolution_notes"
          class="border p-2 w-full mb-4"
          rows="4"
          required></textarea>

<label class="block mb-2">Decision</label>

<select name="status" class="border p-2 w-full mb-4">

<option value="resolved">Resolve Dispute</option>
<option value="rejected">Reject Dispute</option>

</select>

<button class="bg-green-600 text-black px-4 py-2 rounded">

Submit Decision

</button>

</form>

</div>

</x-app-layout>