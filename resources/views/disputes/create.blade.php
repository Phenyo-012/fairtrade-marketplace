<x-app-layout>

<div class="max-w-2xl mx-auto mt-10">

<h2 class="text-2xl font-bold mb-6">
Open Dispute for Order #{{ $order->id }}
</h2>

<form method="POST" action="{{ route('disputes.store', $order) }}">

@csrf

<label class="block mb-2">Reason</label>

<select name="reason" class="border p-2 w-full mb-4">

<option value="item_not_received">Item Not Received</option>
<option value="damaged_item">Damaged Item</option>
<option value="wrong_item">Wrong Item</option>
<option value="other">Other</option>

</select>

<label class="block mb-2">Describe the issue</label>

<textarea name="description"
          class="border p-2 w-full mb-4"
          rows="4"
          placeholder="Provide details about the issue..."
          required></textarea>

<button class="bg-red-500 text-black px-4 py-2 rounded">
Open Dispute
</button>

</form>

</div>

</x-app-layout>