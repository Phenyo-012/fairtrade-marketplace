<section class="space-y-6">

    <header>
        <h2 class="text-lg font-medium text-red-600">
            Delete Account
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Deleting your account will permanently remove all your data including orders, chats, and profile information.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        Delete Account
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>

        <form method="POST" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900">
                Confirm Account Deletion
            </h2>

            <p class="mt-2 text-sm text-gray-600">
                Enter your password to confirm.
            </p>

            <div class="mt-4">
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" name="password" type="password"
                    class="mt-1 block w-full" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancel
                </x-secondary-button>

                <x-danger-button>
                    Delete Account
                </x-danger-button>
            </div>

        </form>

    </x-modal>

</section>