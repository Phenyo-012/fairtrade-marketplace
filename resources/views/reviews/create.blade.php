<x-app-layout>

<div class="max-w-2xl mx-auto mt-10">

    <h2 class="text-2xl font-bold mb-6">
        Review Order #{{ $order->id }}
    </h2>

    @if($itemsToReview->isEmpty())
        <div class="bg-green-100 text-green-700 p-4 rounded-xl">
            All products in this order have already been reviewed.
        </div>
    @else

        <form method="POST" action="{{ route('review.bulkStore') }}" enctype="multipart/form-data">
            @csrf

            @php $i = 0; @endphp

            @foreach($itemsToReview as $item)

                <div class="border p-4 rounded-xl mb-4 bg-white shadow">

                    <p class="font-semibold text-lg">
                        {{ $item->product->name }}
                    </p>

                    {{-- Hidden ID --}}
                    <input type="hidden" name="items[{{ $i }}][order_item_id]" value="{{ $item->id }}">

                    {{-- Rating --}}
                    <label class="block mt-3 text-sm font-medium">Rating</label>
                    <select name="items[{{ $i }}][rating]" class="border p-2 mt-1 rounded-lg w-full">
                        <option value="5">5 ⭐</option>
                        <option value="4">4 ⭐</option>
                        <option value="3">3 ⭐</option>
                        <option value="2">2 ⭐</option>
                        <option value="1">1 ⭐</option>
                    </select>

                    {{-- Comment --}}
                    <label class="block mt-3 text-sm font-medium">Comment</label>
                    <textarea 
                        name="items[{{ $i }}][comment]" 
                        class="border p-2 w-full mt-1 rounded-lg"
                        rows="3"
                        placeholder="Write your review..."
                    ></textarea>

                    {{-- Image --}}
                    <label class="block mt-3 text-sm font-medium">Upload Image (optional)</label>
                    <input 
                        type="file" 
                        name="items[{{ $i }}][image]" 
                        class="border p-2 w-full mt-1 rounded-lg"
                    >

                </div>

                @php $i++; @endphp

            @endforeach

            {{-- Submit --}}
            <button class="bg-blue-600 text-white px-6 py-2 rounded-3xl mt-4 hover:bg-blue-700">
                Submit All Reviews
            </button>

        </form>

    @endif

</div>

</x-app-layout>