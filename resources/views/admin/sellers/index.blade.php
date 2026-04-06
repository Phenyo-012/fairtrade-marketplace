<x-app-layout>

<div class="max-w-5xl mx-auto mt-10">

    <h2 class="text-2xl font-bold mb-6">Seller Verification</h2>

    @foreach($sellers as $seller)
        <div class="bg-white p-4 rounded shadow mb-4">

            <p class="font-semibold">{{ $seller->store_name }}</p>
            <p class="text-sm text-gray-500">{{ $seller->about }}</p>

            <div class="mt-3 flex gap-2">

                <form method="POST" action="/admin/sellers/{{ $seller->id }}/approve">
                    @csrf
                    <button class="bg-green-600 text-white px-3 py-1 rounded">
                        Approve
                    </button>
                </form>

                <form method="POST" action="/admin/sellers/{{ $seller->id }}/reject">
                    @csrf
                    <input type="text" name="notes" placeholder="Reason"
                           class="border p-1 mr-2">
                    <button class="bg-red-600 text-white px-3 py-1 rounded">
                        Reject
                    </button>
                </form>

            </div>

        </div>
    @endforeach

</div>

</x-app-layout>