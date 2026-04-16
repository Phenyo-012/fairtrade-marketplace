<x-app-layout>

<div class="max-w-6xl mx-auto mt-10">

    <h2 class="text-2xl font-bold mb-6">Review Archive</h2>

    <a href="{{ route('admin.reviews') }}"
    class="inline-block mb-6 text-blue-600 hover:underline">
        ← Back to Pending Reviews
    </a>

    @foreach($reviews as $review)
        <a href="{{ route('admin.reviews.show', $review) }}">
            <div class="bg-white p-4 rounded-xl shadow mb-4 hover:shadow-md">

                <p class="font-semibold">
                    {{ $review->orderItem->product->name }}
                </p>

                <p class="text-sm">
                    {{ $review->rating }}★
                </p>

                <p class="text-xs text-gray-500">
                    {{ ucfirst($review->status) }}
                </p>

            </div>
        </a>
    @endforeach

    {{ $reviews->links() }}

</div>

</x-app-layout>