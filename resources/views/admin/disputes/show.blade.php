<x-app-layout>

    <div class="bg-gray-100 min-h-screen">
        <div class="max-w-5xl mx-auto px-4">

            <!-- BACK TO DISPUTES -->
            <a href="{{ route('admin.disputes') }}" class="px-4 py-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                  <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                  </path>
                  </svg>
            </a>

            <div class="bg-white rounded-xl shadow p-6 mb-6">

                <div class="flex items-start justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-3xl font-bold">
                            Dispute #{{ $dispute->id }}
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Order #{{ $dispute->order->id ?? 'N/A' }}
                        </p>
                    </div>

                    <span class="text-xs font-semibold px-3 py-1 rounded-full
                        {{ $dispute->status === 'open' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $dispute->status === 'under_review' ? 'bg-orange-100 text-orange-700' : '' }}
                        {{ $dispute->status === 'resolved' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $dispute->status === 'rejected' ? 'bg-gray-200 text-gray-700' : '' }}">
                        {{ ucfirst(str_replace('_', ' ', $dispute->status)) }}
                    </span>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mb-6">

                    <div class="bg-gray-50 rounded-xl p-4">
                        <h3 class="font-bold mb-3">Opened By</h3>

                        <p class="font-medium">
                            {{ $dispute->openedBy->first_name ?? $dispute->openedBy->name ?? 'User' }}
                            {{ $dispute->openedBy->last_name ?? '' }}
                        </p>

                        <p class="text-sm text-gray-500">
                            {{ $dispute->openedBy->email ?? 'No email available' }}
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4">
                        <h3 class="font-bold mb-3">Order Details</h3>

                        <p class="text-sm">
                            <span class="text-gray-500">Order:</span>
                            #{{ $dispute->order->id ?? 'N/A' }}
                        </p>

                        <p class="text-sm">
                            <span class="text-gray-500">Order Status:</span>
                            {{ ucfirst(str_replace('_', ' ', $dispute->order->status ?? 'unknown')) }}
                        </p>

                        <p class="text-sm">
                            <span class="text-gray-500">Total:</span>
                            R{{ number_format($dispute->order->total_amount ?? 0, 2) }}
                        </p>
                    </div>

                </div>

                <div class="mb-6">
                    <h3 class="font-bold mb-2">Reason for Dispute</h3>

                    <div class="bg-gray-50 border rounded-xl p-4 text-gray-700 whitespace-pre-line">
                        {{ $dispute->reason }}
                    </div>
                </div>

                @if($dispute->seller_response)
                    <div class="mb-6">
                        <h3 class="font-bold mb-2">Seller Response</h3>

                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-gray-700 whitespace-pre-line">
                            {{ $dispute->seller_response }}
                        </div>
                    </div>
                @endif

                @if($dispute->resolution_notes)
                    <div class="mb-6">
                        <h3 class="font-bold mb-2">Resolution Notes</h3>

                        <div class="bg-green-50 border border-green-100 rounded-xl p-4 text-gray-700 whitespace-pre-line">
                            {{ $dispute->resolution_notes }}
                        </div>
                    </div>
                @endif

            </div>

            @if(!in_array($dispute->status, ['resolved', 'rejected']))
                <div class="bg-white rounded-xl shadow p-6">

                    <h3 class="text-xl font-bold mb-4">
                        Admin Decision
                    </h3>

                    <form method="POST"
                          action="{{ route('admin.disputes.resolve', $dispute) }}">

                        @csrf

                        <label class="block mb-2 font-medium">Resolution Notes</label>

                        <textarea name="resolution_notes"
                                  class="border border-gray-300 p-3 w-full mb-4 rounded-xl focus:ring focus:ring-blue-200 focus:outline-none"
                                  rows="5"
                                  placeholder="Explain the decision clearly..."
                                  required>{{ old('resolution_notes') }}</textarea>

                        @error('resolution_notes')
                            <p class="text-red-500 text-sm mb-3">{{ $message }}</p>
                        @enderror

                        <label class="block mb-2 font-medium">Decision</label>

                        <select name="status"
                                class="border border-gray-300 p-3 w-full mb-6 rounded-xl focus:ring focus:ring-blue-200 focus:outline-none"
                                required>
                            <option value="resolved" {{ old('status') === 'resolved' ? 'selected' : '' }}>
                                Resolve Dispute
                            </option>
                            <option value="rejected" {{ old('status') === 'rejected' ? 'selected' : '' }}>
                                Reject Dispute
                            </option>
                        </select>

                        @error('status')
                            <p class="text-red-500 text-sm mb-3">{{ $message }}</p>
                        @enderror

                        <button class="bg-green-600 hover:bg-green-700 text-black font-semibold px-6 py-3 rounded-3xl shadow-md transition">
                            Submit Decision
                        </button>

                    </form>

                </div>
            @else
                <div class="bg-gray-200 text-gray-700 rounded-xl shadow p-6">
                    This dispute has already been {{ str_replace('_', ' ', $dispute->status) }}.
                </div>
            @endif

        </div>
    </div>

</x-app-layout>