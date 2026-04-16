<x-app-layout>

<div class="max-w-4xl mx-auto mt-10">

    <h2 class="text-2xl font-bold mb-6">Review Details</h2>

    <div class="bg-white p-6 rounded-xl shadow">

        <p><strong>Product:</strong> {{ $review->orderItem->product->name }}</p>

        <p><strong>Buyer:</strong> {{ $review->buyer->first_name ?? 'User' }}</p>
        
        <p><strong>Buyer ID:</strong> {{ $review->buyer->id }}</p>

        <p><strong>Rating:</strong> {{ $review->rating }}★</p>

        <p><strong>Status:</strong> {{ ucfirst($review->status) }}</p>

        <p><strong>Created:</strong> {{ $review->created_at->format('d M Y H:i') }}</p>

        <div class="mt-4">
            <strong>Comment:</strong>
            <p class="mt-2 text-gray-700">
                {{ $review->comment }}
            </p>
        </div>

        @if($review->image)
            <img src="{{ asset('storage/' . $review->image) }}"
                 class="w-40 h-40 object-cover mt-4 rounded-xl">
        @endif

        @if($review->status === 'pending')
        <div class="flex gap-3 mt-6">

            <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                @csrf
                @method('PATCH')
                <button class="bg-green-600 text-white px-4 py-2 rounded-xl">
                    Approve
                </button>
            </form>

            <form method="POST" action="{{ route('admin.reviews.reject', $review) }}">
                @csrf
                @method('PATCH')
                <button class="bg-red-500 text-white px-4 py-2 rounded-xl">
                    Reject
                </button>
            </form>

        </div>
        @endif

    </div>

</div>

</x-app-layout>