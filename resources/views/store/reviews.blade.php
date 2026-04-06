<x-app-layout>

<div class="bg-gray-100 min-h-screen py-10">
<div class="max-w-5xl mx-auto px-4">

     <!-- BACK LINK BUTTON -->
    <a href="{{ route('store.show', $seller) }}"
       class="inline-flex items-center gap-1 text-gray-500 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
        </svg>
        Back to Store
    </a>
    
    <h2 class="text-2xl font-bold mb-6">
        {{ $seller->store_name ?? 'Store' }} - Reviews
    </h2>

    <div class="bg-white rounded-2xl shadow p-6">

        @forelse($reviews as $review)

            <div class="border-b py-4">

                <!-- VERIFIED BUYER badge -->
                 <div class="flex items-center gap-2 mb-2">
                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs">
                            Verified Buyer
                        </span>

                </div>

                <div class="flex justify-between items-center">
                    <p class="text-yellow-500 font-semibold">
                        {{ $review->rating }} ⭐
                    </p>

                    <p class="text-sm text-gray-400">
                        {{ $review->created_at->format('d M Y') }}
                    </p>
                </div>

                <p class="text-gray-700 mt-2">
                    <p>Seller Comment:</p>
                    <p>{{ $review->comment }}</p>
                </p>
                <br>
                
                <p class="text-sm text-gray-500 mt-1">
                    Product: {{ $review->orderItem->product->name ?? 'N/A' }}
                </p>

            </div>

        @empty
            <p class="text-gray-500">No reviews yet.</p>
        @endforelse

        <div class="mt-6">
            {{ $reviews->links() }}
        </div>

    </div>

</div>
</div>

</x-app-layout>