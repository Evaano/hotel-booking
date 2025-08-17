<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __("Update Password") }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Ensure your account is using a long, random password to stay secure.") }}
        </p>
    </header>

    <!-- General Errors -->
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md">
            <h4 class="text-sm font-medium text-red-800 mb-2">
                Please fix the following errors:
            </h4>
            <ul class="text-sm text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="post"
        action="{{ route("password.update") }}"
        class="mt-6 space-y-6"
    >
        @csrf
        @method("put")

        <div>
            <x-input-label
                for="current_password"
                :value="__('Current Password')"
            />
            <x-text-input
                id="current_password"
                name="current_password"
                type="password"
                class="mt-1 block w-full"
                autocomplete="current-password"
            />
            <x-input-error
                :messages="$errors->get('current_password')"
                class="mt-2"
            />
        </div>

        <div>
            <x-input-label for="password" :value="__('New Password')" />
            <x-text-input
                id="password"
                name="password"
                type="password"
                class="mt-1 block w-full"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label
                for="password_confirmation"
                :value="__('Confirm Password')"
            />
            <x-text-input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-1 block w-full"
                autocomplete="new-password"
            />
            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"
            />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button type="submit">
                {{ __("Save") }}
            </x-primary-button>

            @if (session("status") === "password-updated")
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => (show = false), 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >
                    {{ __("Password updated successfully!") }}
                </p>
            @endif
        </div>
    </form>
</section>
