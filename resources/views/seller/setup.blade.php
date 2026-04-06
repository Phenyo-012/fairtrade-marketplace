<x-app-layout>

<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">

    <h2 class="text-2xl font-bold mb-6">Become a Seller</h2>

    <form method="POST" action="{{ route('seller.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Store Name</label>
            <input type="text" name="store_name" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">About</label>
            <textarea name="about" class="w-full border rounded p-2"></textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Logo</label>
            <input type="file" name="logo">
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Create Store
        </button>
    </form>

</div>

</x-app-layout>