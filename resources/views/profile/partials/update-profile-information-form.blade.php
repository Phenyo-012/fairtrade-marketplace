<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account details.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- FIRST NAME -->
        <div>
            <x-input-label for="first_name" value="First Name" />
            <x-text-input id="first_name" name="first_name" type="text"
                class="mt-1 block w-full"
                :value="old('first_name', $user->first_name)"
                required />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- LAST NAME -->
        <div>
            <x-input-label for="last_name" value="Last Name" />
            <x-text-input id="last_name" name="last_name" type="text"
                class="mt-1 block w-full"
                :value="old('last_name', $user->last_name)"
                required />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- EMAIL -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-800">
                        Your email is unverified.

                        <button form="send-verification"
                            class="underline text-sm text-blue-600 hover:text-blue-800">
                            Resend verification email
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-green-600">
                            Verification link sent.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- PHONE -->
        <div>
            <x-input-label for="phone" value="Phone Number" />
            <x-text-input id="phone" name="phone" type="text"
                class="mt-1 block w-full"
                :value="old('phone', $user->phone)"
                required />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- SAVE -->
        <div class="flex items-center gap-4">
            <x-primary-button>Save Changes</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >Saved.</p>
            @endif
        </div>
    </form>
</section>