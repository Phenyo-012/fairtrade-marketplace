<x-app-layout>

<div class="bg-gray-100 min-h-screen py-5">

    <div class="max-w-7xl mx-auto px-4">

        <a href="{{ route('admin.dashboard') }}" class="mt-6 px-4 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                </path>
            </svg>
        </a>

        <h2 class="text-2xl font-bold mb-6">
            Seller Applications
        </h2>

        <!-- FILTERS -->
        <div class="flex gap-3 mb-6">

            <a href="?status=pending"
               class="px-4 py-2 rounded-xl {{ $status == 'pending' ? 'bg-black text-white' : 'bg-white' }}">
                Pending
            </a>

            <a href="?status=rejected"
               class="px-4 py-2 rounded-xl {{ $status == 'rejected' ? 'bg-black text-white' : 'bg-white' }}">
                Rejected
            </a>

            <a href="?status=approved"
               class="px-4 py-2 rounded-xl {{ $status == 'approved' ? 'bg-black text-white' : 'bg-white' }}">
                Approved
            </a>

        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-xl mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($sellers->isEmpty())
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <p class="text-gray-500">No seller applications found.</p>
            </div>
        @else

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($sellers as $seller)

                <div class="bg-white rounded-xl shadow p-5 flex flex-col hover:shadow-md transition">

                    <!-- LOGO -->
                    <div class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-full bg-gray-100 border">
                        @if($seller->logo)
                            <img src="{{ asset('storage/' . $seller->logo) }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-500 font-bold">
                                {{ strtoupper(substr($seller->store_name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <!-- USER INFO -->
                    <h3 class="font-bold text-lg text-gray-800">
                        {{ $seller->store_name }}
                    </h3>

                    <p class="text-sm text-gray-500">
                        Owner: {{ $seller->user->first_name }} {{ $seller->user->last_name }}
                    </p>

                    <p class="text-sm text-gray-400">
                        {{ $seller->user->email }}
                    </p>

                    <!-- STATUS -->
                    <div class="mt-3">
                        <span class="px-2 py-1 text-xs rounded-xl
                            @if($seller->verification_status == 'pending') bg-yellow-100 text-yellow-700
                            @elseif($seller->verification_status == 'approved') bg-green-100 text-green-700
                            @else bg-red-100 text-red-700
                            @endif">
                            {{ ucfirst($seller->verification_status) }}
                        </span>
                    </div>

                    <div class="mt-3">

                        <p class="text-sm font-semibold">Documents:</p>

                        <div class="flex gap-4 mt-2">

                            <a href="{{ asset('storage/' . $seller->id_document) }}" target="_blank">
                                <img src="{{ asset('storage/' . $seller->id_document) }}" class="w-24 rounded-xl border">
                            </a>

                            <a href="{{ asset('storage/' . $seller->selfie_document) }}" target="_blank">
                                <img src="{{ asset('storage/' . $seller->selfie_document) }}" class="w-24 rounded-xl border">
                            </a>

                        </div>

                    </div>

                    <!-- NOTES -->
                    @if($seller->verification_notes)
                        <p class="text-xs text-gray-500 mt-2">
                            Note: {{ $seller->verification_notes }}
                        </p>
                    @endif

                    <!-- ACTIONS -->
                    <div class="mt-auto pt-4 space-y-2">

                        <!-- APPROVE (works for rejected too) -->
                        @if($seller->verification_status !== 'approved')
                        <form method="POST" action="{{ route('admin.sellers.approve', $seller->id) }}">
                            @csrf
                            <button class="w-full bg-gray-100 text-black py-2 border border-gray-400 rounded-3xl hover:bg-green-700 transition shadow-md">
                                Approve
                            </button>
                        </form>
                        @endif

                        <!-- REJECT -->
                        @if($seller->verification_status !== 'rejected')
                        <form method="POST" action="{{ route('admin.sellers.reject', $seller->id) }}">
                            @csrf
                            <input type="text" name="notes" placeholder="Reason (optional)"
                                   class="w-full border rounded-xl p-2 mb-2 text-sm">

                            <button class="w-full bg-gray-100 text-black py-2 border border-gray-400 rounded-3xl hover:bg-red-600 transition shadow-md">
                                Reject
                            </button>
                        </form>
                        @endif

                        <a href="{{ route('admin.sellers.show', $seller->id) }}"
                            class="w-full block text-center bg-gray-100 text-black py-2 border border-gray-400 rounded-3xl hover:bg-blue-300 transition shadow-md">
                                View Seller Stats
                        </a>

                    </div>

                </div>

            @endforeach

        </div>

        @endif

    </div>

</div>

</x-app-layout>