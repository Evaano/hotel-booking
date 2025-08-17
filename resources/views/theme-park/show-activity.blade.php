@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-8">
        <!-- Activity Header -->
        <div class="space-y-4">
            <div class="flex items-center gap-4">
                <a
                    href="{{ route("theme-park.index") }}"
                    class="text-primary-600 hover:text-primary-700"
                >
                    <svg
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>
                </a>
                <h1 class="text-4xl font-bold text-gray-900">
                    {{ $activity->name }}
                </h1>
            </div>
            <div class="flex items-center gap-4 text-gray-600">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800"
                >
                    {{ ucfirst($activity->category) }}
                </span>
                @if ($activity->status === "active")
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800"
                    >
                        Open Now
                    </span>
                @else
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800"
                    >
                        {{ ucfirst($activity->status) }}
                    </span>
                @endif
            </div>
        </div>

        <!-- Activity Image -->
        <div class="card overflow-hidden">
            <img
                src="{{ $activity->image_url }}"
                alt="{{ $activity->name }}"
                class="w-full h-96 object-cover"
            />
        </div>

        <!-- Activity Information Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Description -->
                @if ($activity->description)
                    <div class="card">
                        <div class="card-header">
                            <h2 class="text-2xl font-bold text-gray-900">
                                About This Activity
                            </h2>
                        </div>
                        <div class="card-body">
                            <p class="text-gray-700 leading-relaxed">
                                {{ $activity->description }}
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Activity Details -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-2xl font-bold text-gray-900">
                            Activity Details
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                @if ($activity->duration_minutes)
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center"
                                        >
                                            <svg
                                                class="w-5 h-5 text-primary-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">
                                                Duration
                                            </p>
                                            <p
                                                class="font-medium text-gray-900"
                                            >
                                                {{ $activity->duration_minutes }}
                                                minutes
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if ($activity->capacity)
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center"
                                        >
                                            <svg
                                                class="w-5 h-5 text-emerald-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                                />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">
                                                Capacity
                                            </p>
                                            <p
                                                class="font-medium text-gray-900"
                                            >
                                                {{ number_format($activity->capacity) }}
                                                people
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if ($activity->location_coordinates)
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center"
                                        >
                                            <svg
                                                class="w-5 h-5 text-blue-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                                />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">
                                                Location
                                            </p>
                                            <p
                                                class="font-medium text-gray-900"
                                            >
                                                Theme Park Area
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="space-y-4">
                                @if ($activity->price)
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center"
                                        >
                                            <svg
                                                class="w-5 h-5 text-emerald-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"
                                                />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">
                                                Price
                                            </p>
                                            <p
                                                class="font-medium text-gray-900"
                                            >
                                                ${{ number_format($activity->price, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if ($activity->age_restriction)
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center"
                                        >
                                            <svg
                                                class="w-5 h-5 text-yellow-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                                />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">
                                                Age Requirement
                                            </p>
                                            <p
                                                class="font-medium text-gray-900"
                                            >
                                                {{ $activity->age_restriction }}+
                                                years old
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if ($activity->height_restriction)
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center"
                                        >
                                            <svg
                                                class="w-5 h-5 text-purple-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"
                                                />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">
                                                Height Requirement
                                            </p>
                                            <p
                                                class="font-medium text-gray-900"
                                            >
                                                Min
                                                {{ $activity->height_restriction }}cm
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Safety Information -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-2xl font-bold text-gray-900">
                            Safety & Guidelines
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            <div
                                class="bg-blue-50 border border-blue-200 rounded-lg p-4"
                            >
                                <h3 class="font-semibold text-blue-900 mb-2">
                                    Important Safety Information
                                </h3>
                                <ul class="space-y-2 text-blue-800 text-sm">
                                    <li class="flex items-start gap-2">
                                        <svg
                                            class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                                            />
                                        </svg>
                                        Follow all posted safety instructions
                                        and staff directions
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg
                                            class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                                            />
                                        </svg>
                                        Secure loose items before participating
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg
                                            class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                                            />
                                        </svg>
                                        Stay within designated areas and follow
                                        marked paths
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg
                                            class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                                            />
                                        </svg>
                                        Report any safety concerns to staff
                                        immediately
                                    </li>
                                </ul>
                            </div>

                            @if ($activity->age_restriction || $activity->height_restriction)
                                <div
                                    class="bg-yellow-50 border border-yellow-200 rounded-lg p-4"
                                >
                                    <h3
                                        class="font-semibold text-yellow-900 mb-2"
                                    >
                                        Restrictions & Requirements
                                    </h3>
                                    <ul
                                        class="space-y-2 text-yellow-800 text-sm"
                                    >
                                        @if ($activity->age_restriction)
                                            <li class="flex items-center gap-2">
                                                <svg
                                                    class="w-4 h-4 text-yellow-600"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                                    />
                                                </svg>
                                                Minimum age:
                                                {{ $activity->age_restriction }}
                                                years old
                                            </li>
                                        @endif

                                        @if ($activity->height_restriction)
                                            <li class="flex items-center gap-2">
                                                <svg
                                                    class="w-4 h-4 text-yellow-600"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"
                                                    />
                                                </svg>
                                                Minimum height:
                                                {{ $activity->height_restriction }}cm
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- What to Expect -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-2xl font-bold text-gray-900">
                            What to Expect
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <h3 class="font-semibold text-gray-900">
                                    Before the Activity:
                                </h3>
                                <ul class="space-y-2 text-gray-600 text-sm">
                                    <li class="flex items-center gap-2">
                                        <svg
                                            class="w-4 h-4 text-emerald-500"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 13l4 4L19 7"
                                            />
                                        </svg>
                                        Check-in at the activity entrance
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg
                                            class="w-4 h-4 text-emerald-500"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 13l4 4L19 7"
                                            />
                                        </svg>
                                        Safety briefing and instructions
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg
                                            class="w-4 h-4 text-emerald-500"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 13l4 4L19 7"
                                            />
                                        </svg>
                                        Equipment fitting and adjustment
                                    </li>
                                </ul>
                            </div>
                            <div class="space-y-3">
                                <h3 class="font-semibold text-gray-900">
                                    During the Activity:
                                </h3>
                                <ul class="space-y-2 text-gray-600 text-sm">
                                    <li class="flex items-center gap-2">
                                        <svg
                                            class="w-4 h-4 text-emerald-500"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 13l4 4L19 7"
                                            />
                                        </svg>
                                        Professional staff supervision
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg
                                            class="w-4 h-4 text-emerald-500"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 13l4 4L19 7"
                                            />
                                        </svg>
                                        Continuous safety monitoring
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg
                                            class="w-4 h-4 text-emerald-500"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 13l4 4L19 7"
                                            />
                                        </svg>
                                        Emergency response available
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Pricing & Booking Card -->
                <div class="card">
                    <div class="card-body text-center">
                        @if ($activity->price)
                            <div
                                class="text-4xl font-bold text-emerald-600 mb-2"
                            >
                                ${{ number_format($activity->price, 2) }}
                            </div>
                            <div class="text-gray-500 mb-4">per person</div>
                        @else
                            <div
                                class="text-3xl font-bold text-emerald-600 mb-2"
                            >
                                Free Activity
                            </div>
                            <div class="text-gray-500 mb-4">
                                No additional cost
                            </div>
                        @endif

                        <div class="space-y-3 text-sm text-gray-600 mb-6">
                            <div class="flex justify-between">
                                <span>Category:</span>
                                <span class="font-medium">
                                    {{ ucfirst($activity->category) }}
                                </span>
                            </div>
                            @if ($activity->duration_minutes)
                                <div class="flex justify-between">
                                    <span>Duration:</span>
                                    <span class="font-medium">
                                        {{ $activity->duration_minutes }}
                                        minutes
                                    </span>
                                </div>
                            @endif

                            @if ($activity->capacity)
                                <div class="flex justify-between">
                                    <span>Capacity:</span>
                                    <span class="font-medium">
                                        {{ number_format($activity->capacity) }}
                                        people
                                    </span>
                                </div>
                            @endif
                        </div>

                        @auth
                            <a
                                href="{{ route("theme-park.book-ticket") }}"
                                class="w-full btn-primary mb-3"
                            >
                                Book Theme Park Ticket
                            </a>
                            <a
                                href="{{ route("theme-park.tickets") }}"
                                class="w-full btn-secondary"
                            >
                                Book This Activity
                            </a>
                        @else
                            <a
                                href="{{ route("login") }}"
                                class="w-full btn-primary mb-3"
                            >
                                Login to Book
                            </a>
                            <a
                                href="{{ route("register") }}"
                                class="w-full btn-secondary"
                            >
                                Create Account
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Activity Status -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Activity Status
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">
                                    Status:
                                </span>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $activity->status === "active" ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800" }}"
                                >
                                    {{ ucfirst($activity->status) }}
                                </span>
                            </div>
                            @if ($activity->status === "maintenance")
                                <div
                                    class="bg-yellow-50 border border-yellow-200 rounded-lg p-3"
                                >
                                    <p class="text-sm text-yellow-800">
                                        This activity is currently under
                                        maintenance. Please check back later.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Facts -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Quick Facts
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Type:</span>
                                <span class="font-medium text-gray-900">
                                    {{ ucfirst($activity->category) }}
                                </span>
                            </div>
                            @if ($activity->age_restriction)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Min Age:</span>
                                    <span class="font-medium text-gray-900">
                                        {{ $activity->age_restriction }}+
                                    </span>
                                </div>
                            @endif

                            @if ($activity->height_restriction)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        Min Height:
                                    </span>
                                    <span class="font-medium text-gray-900">
                                        {{ $activity->height_restriction }}cm
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Contact Support -->
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            Need Help?
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Questions about this activity?
                        </p>
                        <a
                            href="{{ route("contact") }}"
                            class="btn-secondary w-full"
                        >
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center py-8">
            <div class="card max-w-2xl mx-auto">
                <div class="card-body text-center">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        Explore More Activities
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Discover all the amazing attractions in our theme park!
                    </p>
                    <div class="flex gap-4 justify-center">
                        <a
                            href="{{ route("theme-park.index") }}"
                            class="btn-primary"
                        >
                            Browse All Activities
                        </a>
                        <a href="{{ route("map") }}" class="btn-secondary">
                            View Park Map
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
