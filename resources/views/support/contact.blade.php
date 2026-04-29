<x-app-layout>

    <div class="bg-gray-100 min-h-screen py-10">
        <div class="max-w-3xl mx-auto px-4">

            <div class="bg-white rounded-2xl shadow p-6 md:p-8">
                <h1 class="text-3xl font-bold mb-2">Contact Support</h1>
                <p class="text-gray-600 mb-6">
                    Need help with an order, account, seller issue, or something else? 
                    Send us a message and our team will review it.
                </p>

                @if(session('success'))
                    <div class="bg-green-100 text-green-800 px-4 py-3 rounded-xl mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('support.store') }}" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Full Name</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', auth()->user()->first_name . ' ' . auth()->user()->last_name ?? '') }}"
                                class="w-full border border-gray-300 rounded-3xl p-3"
                                required
                            >
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Email Address</label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', auth()->user()->email ?? '') }}"
                                class="w-full border border-gray-300 rounded-3xl p-3"
                                required
                            >
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Subject</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" 
                            class="w-full border border-gray-300 rounded-3xl p-3" required>
                        @error('subject')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Category</label>
                        <select name="category" class="w-full border border-gray-300 rounded-3xl p-3" required>
                            <option value="general" {{ old('category') === 'general' ? 'selected' : '' }}>General</option>
                            <option value="order" {{ old('category') === 'order' ? 'selected' : '' }}>Order Issue</option>
                            <option value="payment" {{ old('category') === 'payment' ? 'selected' : '' }}>Payment / Escrow</option>
                            <option value="seller" {{ old('category') === 'seller' ? 'selected' : '' }}>Seller Issue</option>
                            <option value="buyer" {{ old('category') === 'buyer' ? 'selected' : '' }}>Buyer Issue</option>
                            <option value="account" {{ old('category') === 'account' ? 'selected' : '' }}>Account</option>
                            <option value="technical" {{ old('category') === 'technical' ? 'selected' : '' }}>Technical Problem</option>
                            <option value="dispute" {{ old('category') === 'dispute' ? 'selected' : '' }}>Dispute</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Message</label>
                        <textarea name="message" rows="7" class="w-full border border-gray-300 rounded-3xl p-3"
                            placeholder="Describe the issue in as much detail as possible..." required>{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button class="bg-black text-white px-6 py-3 rounded-3xl shadow hover:bg-gray-800 transition">
                            Submit Request
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    
</x-app-layout>