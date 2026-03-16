<x-app-layout>

<div class="max-w-2xl mx-auto mt-10">

<h2 class="text-2xl font-bold mb-6">
Review Order #{{ $order->id }}
</h2>

<form method="POST" action="{{ route('reviews.store',$order) }}">

@csrf

<label class="block mb-2">Rating</label>

<select name="rating" class="border p-2 w-full mb-4">

<option value="5">⭐⭐⭐⭐⭐ (5)</option>
<option value="4">⭐⭐⭐⭐ (4)</option>
<option value="3">⭐⭐⭐ (3)</option>
<option value="2">⭐⭐ (2)</option>
<option value="1">⭐ (1)</option>

</select>

<label class="block mb-2">Comment</label>

<textarea name="comment"
          class="border p-2 w-full mb-4"
          rows="4"
          placeholder="Share your experience..."></textarea>

<button class="bg-green-600 text-black px-4 py-2 rounded">

Submit Review

</button>

</form>

</div>

</x-app-layout>