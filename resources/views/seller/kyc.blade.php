<x-app-layout>

<div class="max-w-xl mx-auto mt-10">

    <h2 class="text-2xl font-bold mb-6">Verify Your Identity</h2>

    <form method="POST" action="{{ route('seller.kyc.submit') }}" enctype="multipart/form-data">
        @csrf

        <!-- ID DOCUMENT -->
        <div class="mb-4">
            <label class="block mb-1">Upload ID Document</label>
            <input type="file" name="id_document" required class="border p-2 w-full">
        </div>

        <!-- SELFIE -->
        <div class="mb-4">
            <label class="block mb-1">Upload Selfie</label>
            <input type="file" name="selfie_document" required class="border p-2 w-full">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded-xl">
            Submit Verification
        </button>

    </form>

</div>

</x-app-layout>