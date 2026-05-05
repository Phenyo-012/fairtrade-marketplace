<x-app-layout>

<div class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-4xl mx-auto px-4">

        <!-- BACK LINK -->
        <div class="mb-6">
            <a href="{{ route('orders.show', $order) }}"
               class="text-black hover:underline text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                    </path>
                </svg>
            </a>
        </div>

        <!-- HEADER -->
        <div class="bg-white p-6 rounded-2xl shadow mb-6">
            <h2 class="text-2xl font-bold text-gray-900">
                Review Your Order
            </h2>

            <p class="text-gray-500 text-sm mt-1">
                Order #{{ $order->id }} • Share your experience with each product.
            </p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
                <p class="font-semibold mb-2">Please fix the following:</p>
                <ul class="list-disc ml-5 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($itemsToReview->isEmpty())

            <!-- EMPTY STATE -->
            <div class="bg-white p-10 rounded-2xl shadow text-center">

                <h3 class="text-xl font-bold text-gray-900">
                    All products reviewed
                </h3>

                <p class="text-gray-500 mt-2">
                    You have already reviewed every product in this order.
                </p>

                <a href="{{ route('orders.show', $order) }}"
                   class="inline-block mt-6 bg-black text-white px-6 py-3 rounded-3xl hover:bg-gray-800 transition">
                    Return to Order
                </a>
            </div>

        @else

            <form method="POST" action="{{ route('review.bulkStore') }}" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">

                    @foreach($itemsToReview as $i => $item)

                        @php
                            $product = $item->product;
                            $image = $product?->images?->first();
                        @endphp

                        <div class="bg-white rounded-2xl shadow p-6">

                            <!-- PRODUCT SUMMARY -->
                            <div class="flex gap-4 mb-5">

                                <!-- IMAGE -->
                                <div class="w-24 h-24 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                                    @if($image)
                                        <img src="{{ \App\Support\ImageUrl::make($image->image_path ?? null, 'placeholder.png') }}"
                                            alt="{{ $product->name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <img src="{{ asset('placeholder.png') }}"
                                            alt="No image"
                                            class="w-full h-full object-cover">
                                    @endif
                                </div>

                                <!-- DETAILS -->
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg text-gray-900">
                                        {{ $product->name ?? $item->product_name ?? 'Deleted Product' }}
                                    </h3>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Quantity: {{ $item->quantity }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        Purchased for:
                                        <span class="font-semibold text-gray-800">
                                            R{{ number_format($item->subtotal, 2) }}
                                        </span>
                                    </p>
                                </div>

                            </div>

                            <input type="hidden"
                                   name="items[{{ $i }}][order_item_id]"
                                   value="{{ $item->id }}">

                            <!-- RATING -->
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Rating
                                </label>

                                <select name="items[{{ $i }}][rating]"
                                        class="w-full border border-gray-300 p-3 rounded-3xl focus:ring focus:ring-blue-200 focus:outline-none"
                                        required>
                                    <option value="5" {{ old("items.$i.rating") == 5 ? 'selected' : '' }}>
                                        5 stars — Excellent
                                    </option>
                                    <option value="4" {{ old("items.$i.rating") == 4 ? 'selected' : '' }}>
                                        4 stars — Good
                                    </option>
                                    <option value="3" {{ old("items.$i.rating") == 3 ? 'selected' : '' }}>
                                        3 stars — Average
                                    </option>
                                    <option value="2" {{ old("items.$i.rating") == 2 ? 'selected' : '' }}>
                                        2 stars — Poor
                                    </option>
                                    <option value="1" {{ old("items.$i.rating") == 1 ? 'selected' : '' }}>
                                        1 star — Very poor
                                    </option>
                                </select>
                            </div>

                            <!-- COMMENT -->
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Comment
                                </label>

                                <textarea name="items[{{ $i }}][comment]"
                                          class="w-full border border-gray-300 p-3 rounded-3xl focus:ring focus:ring-blue-200 focus:outline-none"
                                          rows="4"
                                          placeholder="Tell other buyers about the product quality, delivery, packaging, or seller service...">{{ old("items.$i.comment") }}</textarea>
                            </div>

                        </div>

                    @endforeach

                </div>

                <!-- SUBMIT AREA -->
                <div class="bg-white rounded-2xl shadow p-6 mt-6 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">

                    <p class="text-sm text-gray-500">
                        Your reviews will be submitted for moderation before appearing publicly.
                    </p>

                    <button class="bg-blue-600 text-white px-6 py-3 rounded-3xl hover:bg-blue-700 transition font-semibold">
                        Submit All Reviews
                    </button>

                </div>

            </form>

        @endif

    </div>
</div>

</x-app-layout>