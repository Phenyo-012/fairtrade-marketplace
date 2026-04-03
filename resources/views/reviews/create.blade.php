<x-app-layout>

<div class="max-w-2xl mx-auto mt-10">

<h2 class="text-2xl font-bold mb-6">
Review Order #{{ $order->id }}
</h2>

@foreach($order->items as $item)

<div class="border p-4 rounded mb-3">

    <p class="font-semibold">{{ $item->product->name }}</p>

    @if(!$item->reviews->count())

    <form method="POST" action="{{ route('review.store', $item->id) }}" enctype="multipart/form-data"   class="mt-3">
        @csrf

        <select name="rating" class="border p-2 mb-2">
            <option value="5">5 ⭐</option>
            <option value="4">4 ⭐</option>
            <option value="3">3 ⭐</option>
            <option value="2">2 ⭐</option>
            <option value="1">1 ⭐</option>
        </select>

        <textarea name="comment" class="border p-2 w-full mb-2"></textarea>

        <input type="file" name="image" class="border p-2 w-full mb-2">

        <button class="bg-blue-600 text-white px-3 py-1 rounded">
            Submit Review
        </button>

    </form>

    @else
        <p class="text-green-600 text-sm">Already reviewed</p>
    @endif

</div>

@endforeach

</div>

</x-app-layout>