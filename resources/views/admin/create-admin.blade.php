<x-app-layout>

    <div class="max-w-lg mx-auto py-10">

        <div class="bg-white p-6 rounded-xl shadow">

            <h2 class="text-xl font-bold mb-4">Create Admin Account</h2>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.store') }}">
                @csrf

                <input type="text" name="first_name" placeholder="First Name"
                    class="w-full border border-black p-2 mb-3 rounded-xl" required>

                <input type="text" name="last_name" placeholder="Last Name"
                    class="w-full border border-black p-2 mb-3 rounded-xl" required>

                <input type="email" name="email" placeholder="Email"
                    class="w-full border border-black p-2 mb-3 rounded-xl" required>

                <input type="phone" name="phone" placeholder="Phone"
                    class="w-full border border-black p-2 mb-3 rounded-xl" required>

                <input type="password" name="password" placeholder="Password"
                    class="w-full border border-black p-2 mb-3 rounded-xl" required>

                <input type="password" name="password_confirmation" placeholder="Confirm Password"
                    class="w-full border border-black p-2 mb-4 rounded-xl" required>

                    <label for="show_password" class="inline-flex items-center mb-4">
                        <input id="show_password" type="checkbox" class="rounded-xl border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" onclick="togglePasswordVisibility()">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Show Password') }}</span>
                    </label>

                <button class="bg-black text-white px-4 py-2 rounded-3xl w-full">
                    Create Admin
                </button>
            </form>

        </div>

    </div>

    <!-- Add JavaScript to toggle password visibility -->
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.querySelector('input[name="password"]');
            const confirmPasswordInput = document.querySelector('input[name="password_confirmation"]');
            const showPasswordCheckbox = document.getElementById('show_password');

            if (showPasswordCheckbox.checked) {
                passwordInput.type = 'text';
                confirmPasswordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
                confirmPasswordInput.type = 'password';
            }
        }
    </script>

</x-app-layout>