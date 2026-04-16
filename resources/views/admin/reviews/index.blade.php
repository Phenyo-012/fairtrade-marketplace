<x-app-layout>

<div class="max-w-6xl mx-auto mt-10">

    <h2 class="text-2xl font-bold mb-6">Review Moderation</h2>

    <div class="flex justify-between items-center mb-6">

        <h2 class="text-2xl font-bold">Pending Reviews</h2>

        <a href="{{ route('admin.reviews.archive') }}"
        class="bg-gray-800 text-white px-4 py-2 rounded-xl hover:bg-gray-700 transition">
            View Archive
        </a>

    </div>

    @foreach($reviews as $review)
        <a href="{{ route('admin.reviews.show', $review) }}">
            <div class="bg-white p-4 rounded-xl shadow mb-4 hover:shadow-md transition cursor-pointer">

                <p class="font-semibold">
                    {{ $review->orderItem->product->name }}
                </p>

                <p class="text-sm text-gray-600">
                    {{ $review->rating }}★
                </p>

                <p class="text-sm text-gray-500 line-clamp-2">
                    {{ $review->comment }}
                </p>

                <p class="text-xs text-gray-400 mt-2">
                    Pending review
                </p>

            </div>
        </a>
    @endforeach

    {{ $reviews->links() }}

</div>

</x-app-layout>