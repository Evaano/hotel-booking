<x-app-layout>
    <x-slot name="header">
        <h2
            class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
        >
            {{ __("My Profile") }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="container">
            <div class="max-w-3xl mx-auto">
                <div class="card">
                    <div class="card-body text-gray-900 dark:text-gray-100">
                        <dl
                            class="divide-y divide-gray-200 dark:divide-gray-700"
                        >
                            <div class="py-4 grid grid-cols-3 gap-4">
                                <dt
                                    class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                >
                                    Name
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 dark:text-gray-100 col-span-2"
                                >
                                    {{ $user->name }}
                                </dd>
                            </div>
                            <div class="py-4 grid grid-cols-3 gap-4">
                                <dt
                                    class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                >
                                    Username
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 dark:text-gray-100 col-span-2"
                                >
                                    {{ $user->username ?? "—" }}
                                </dd>
                            </div>
                            <div class="py-4 grid grid-cols-3 gap-4">
                                <dt
                                    class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                >
                                    Email
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 dark:text-gray-100 col-span-2"
                                >
                                    {{ $user->email }}
                                </dd>
                            </div>
                            <div class="py-4 grid grid-cols-3 gap-4">
                                <dt
                                    class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                >
                                    Email Verified
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 dark:text-gray-100 col-span-2"
                                >
                                    @if ($user->email_verified_at)
                                        {{ $user->email_verified_at->format("M d, Y H:i") }}
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20"
                                        >
                                            Unverified
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            <div class="py-4 grid grid-cols-3 gap-4">
                                <dt
                                    class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                >
                                    Role
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 dark:text-gray-100 col-span-2 capitalize"
                                >
                                    {{ str_replace("_", " ", $user->role) }}
                                </dd>
                            </div>
                            <div class="py-4 grid grid-cols-3 gap-4">
                                <dt
                                    class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                >
                                    Joined
                                </dt>
                                <dd
                                    class="mt-1 text-sm text-gray-900 dark:text-gray-100 col-span-2"
                                >
                                    {{ $user->created_at->format("M d, Y") }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                    <div
                        class="px-6 py-4 border-t border-muted-200/50 bg-muted-50/30 rounded-b-2xl"
                    >
                        <div class="flex items-center gap-3">
                            <a
                                href="{{ route("profile.edit") }}"
                                class="btn-primary"
                            >
                                Edit Profile
                            </a>
                            <form
                                method="post"
                                action="{{ route("profile.destroy") }}"
                                onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');"
                            >
                                @csrf
                                @method("delete")
                                <button type="submit" class="btn-error">
                                    Delete Account
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
