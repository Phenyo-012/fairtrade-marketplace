<x-app-layout>

<div class="bg-gray-100 min-h-screen py-6">
    <div class="max-w-5xl mx-auto px-4">

        <!-- BACK -->
        <a href="{{ route('seller.disputes.index') }}"
           class="inline-flex items-center text-sm text-gray-600 hover:text-black mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                </path>
            </svg>
            <span class="ml-2">Back to disputes</span>
        </a>

        <!-- FLASH MESSAGES -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-xl mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4">
                <ul class="list-disc ml-5 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- HEADER -->
        <div class="bg-white rounded-2xl shadow p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>
                    <h2 class="text-2xl font-bold text-gray-900">
                        Dispute #{{ $dispute->id }}
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Order #{{ $dispute->order_id }}
                    </p>
                </div>

                <div>
                    @if($dispute->status === 'open')
                        <span class="bg-red-100 text-red-700 text-sm px-4 py-2 rounded-full font-semibold">
                            Open
                        </span>
                    @elseif($dispute->status === 'under_review')
                        <span class="bg-yellow-100 text-yellow-700 text-sm px-4 py-2 rounded-full font-semibold">
                            Under Review
                        </span>
                    @elseif($dispute->status === 'resolved')
                        <span class="bg-green-100 text-green-700 text-sm px-4 py-2 rounded-full font-semibold">
                            Resolved
                        </span>
                    @elseif($dispute->status === 'rejected')
                        <span class="bg-gray-200 text-gray-700 text-sm px-4 py-2 rounded-full font-semibold">
                            Rejected
                        </span>
                    @else
                        <span class="bg-gray-100 text-gray-700 text-sm px-4 py-2 rounded-full font-semibold">
                            {{ ucfirst($dispute->status) }}
                        </span>
                    @endif
                </div>

            </div>
        </div>

        <!-- MAIN GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- LEFT: DISPUTE DETAILS -->
            <div class="lg:col-span-2 space-y-6">

                <!-- BUYER REASON -->
                <div class="bg-white rounded-2xl shadow p-6">
                    <h3 class="font-bold text-lg mb-3">
                        Buyer Complaint
                    </h3>

                    <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl text-gray-700 whitespace-pre-line">
                        {{ $dispute->reason }}
                    </div>
                </div>

                <!-- SELLER RESPONSE -->
                <div class="bg-white rounded-2xl shadow p-6">

                    <h3 class="font-bold text-lg mb-3">
                        Your Response
                    </h3>

                    @if($dispute->seller_response)

                        <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl">
                            <p class="text-gray-700 whitespace-pre-line">
                                {{ $dispute->seller_response }}
                            </p>

                            @if($dispute->seller_responded_at)
                                <p class="text-xs text-gray-500 mt-3">
                                    Submitted {{ $dispute->seller_responded_at->format('d M Y H:i') }}
                                </p>
                            @endif
                        </div>

                    @else

                        @if(in_array($dispute->status, ['resolved', 'rejected']))
                            <div class="bg-gray-100 text-gray-600 p-4 rounded-xl">
                                This dispute has already been {{ $dispute->status }}. You can no longer respond.
                            </div>
                        @else
                            <form method="POST" action="{{ route('seller.disputes.respond', $dispute) }}" class="space-y-4">
                                @csrf

                                <div>
                                    <label class="block text-sm font-semibold mb-2">
                                        Explain your side of the dispute
                                    </label>

                                    <textarea name="seller_response"
                                        class="w-full border border-gray-300 rounded-xl p-3 focus:ring focus:ring-blue-200 focus:outline-none"
                                        rows="6"
                                        placeholder="Provide shipment details, communication context, packaging information, or any evidence that helps the admin understand your side..."
                                        required>{{ old('seller_response') }}</textarea>

                                    @error('seller_response')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button class="bg-blue-600 text-white px-5 py-3 rounded-3xl hover:bg-blue-700 font-semibold">
                                    Submit Response
                                </button>
                            </form>
                        @endif

                    @endif

                </div>

                <!-- ADMIN RESOLUTION -->
                @if($dispute->resolution_notes)
                    <div class="bg-white rounded-2xl shadow p-6">
                        <h3 class="font-bold text-lg mb-3">
                            Admin Resolution Notes
                        </h3>

                        <div class="bg-green-50 border border-green-200 p-4 rounded-xl text-gray-700 whitespace-pre-line">
                            {{ $dispute->resolution_notes }}
                        </div>
                    </div>
                @endif

            </div>

            <!-- RIGHT: ORDER SUMMARY -->
            <div class="space-y-6">

                <!-- ORDER INFO -->
                <div class="bg-white rounded-2xl shadow p-6">
                    <h3 class="font-bold text-lg mb-4">
                        Order Summary
                    </h3>

                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-500">Order ID</p>
                            <p class="font-semibold">#{{ $dispute->order_id }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">Order Status</p>
                            <p class="font-semibold">
                                {{ ucfirst(str_replace('_', ' ', $dispute->order->status ?? 'Unknown')) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Opened</p>
                            <p class="font-semibold">
                                {{ $dispute->created_at->format('d M Y H:i') }}
                            </p>
                        </div>

                        @if($dispute->updated_at)
                            <div>
                                <p class="text-gray-500">Last Updated</p>
                                <p class="font-semibold">
                                    {{ $dispute->updated_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- YOUR ITEMS IN ORDER -->
                @if($dispute->order && $dispute->order->orderItems)
                    <div class="bg-white rounded-2xl shadow p-6">
                        <h3 class="font-bold text-lg mb-4">
                            Items Involved
                        </h3>

                        <div class="space-y-3">
                            @foreach($dispute->order->orderItems as $item)
                                @if($item->product && $item->product->seller_profile_id === auth()->user()->sellerProfile->id)
                                    <div class="border rounded-xl p-3">
                                        <p class="font-semibold text-sm">
                                            {{ $item->product->name }}
                                        </p>

                                        <p class="text-xs text-gray-500">
                                            Qty: {{ $item->quantity }}
                                        </p>

                                        <p class="text-sm font-bold mt-1">
                                            R{{ number_format($item->subtotal, 2) }}
                                        </p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- GUIDANCE -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 text-sm text-yellow-800">
                    <h3 class="font-bold mb-2">Seller Guidance</h3>

                    <ul class="list-disc ml-5 space-y-1">
                        <li>Be factual and professional.</li>
                        <li>Do not share private buyer information.</li>
                        <li>Explain shipping, packaging, or product details clearly.</li>
                        <li>Admins will review both sides before making a decision.</li>
                    </ul>
                </div>

            </div>

        </div>

    </div>
</div>

</x-app-layout>