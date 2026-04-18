<x-app-layout>

<div class="max-w-5xl mx-auto mt-10">

<h2 class="text-xl font-bold mb-6">Disputes</h2>

@foreach($disputes as $dispute)
    <div class="bg-white p-4 rounded-xl shadow mb-3 flex justify-between">
        <div>
            <p>Order #{{ $dispute->order_id }}</p>
            <p class="text-sm text-gray-500">{{ $dispute->status }}</p>
        </div>

        <a href="{{ route('seller.disputes.show', $dispute) }}"
           class="w-28 bg-white text-black text-center justify-center py-2 border border-black rounded-3xl hover:bg-blue-300 transition shadow-md">
           View
        </a>
    </div>
@endforeach

</div>

</x-app-layout>