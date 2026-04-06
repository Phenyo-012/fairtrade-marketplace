<x-app-layout>

<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">

    <h2 class="text-2xl font-bold mb-6">Edit Store</h2>

    @if(session('success'))
        <p class="text-green-600 mb-4">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('seller.store.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label>Store Name</label>
            <input type="text" name="store_name"
                   value="{{ $seller->store_name }}"
                   class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label>About</label>
            <textarea name="about"
                      class="w-full border p-2 rounded">{{ $seller->about }}</textarea>
        </div>

        <div class="mb-4">
            <label>Logo</label>
            <input type="file" name="logo">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Update Store
        </button>
    </form>

</div>

</x-app-layout>