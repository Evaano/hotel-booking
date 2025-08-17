@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-8">
        <!-- Welcome Header -->
        <div class="text-center space-y-4">
            <h1 class="text-4xl font-bold text-gray-900">
                Welcome back, {{ Auth::user()->name }}!
            </h1>
            <p class="text-xl text-gray-600">
                Manage your island adventures and bookings from your personal
                dashboard.
            </p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-3xl font-bold text-primary-600">
                        {{ $userBookings->count() ?? 0 }}
                    </div>
                    <div class="text-sm text-gray-600">Total Bookings</div>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-3xl font-bold text-emerald-600">
                        {{ $userBookings->where("booking_status", "confirmed")->count() ?? 0 }}
                    </div>
                    <div class="text-sm text-gray-600">Confirmed Bookings</div>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-3xl font-bold text-blue-600">
                        {{ $userBookings->where("booking_status", "pending")->count() ?? 0 }}
                    </div>
                    <div class="text-sm text-gray-600">Pending Bookings</div>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-3xl font-bold text-purple-600">
                        {{ $userBookings->where("booking_status", "completed")->count() ?? 0 }}
                    </div>
                    <div class="text-sm text-gray-600">Completed Stays</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-2xl font-bold text-gray-900">Quick Actions</h2>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a
                        href="{{ route("hotels.browse") }}"
                        class="card hover:shadow-md transition-shadow duration-200 text-center"
                    >
                        <div class="card-body">
                            <div class="text-4xl mb-3">
                                <iconify-icon icon="mdi:hotel"></iconify-icon>
                            </div>
                            <h3 class="font-semibold text-gray-900">
                                Book a Hotel
                            </h3>
                            <p class="text-sm text-gray-600">
                                Find and reserve your perfect accommodation
                            </p>
                        </div>
                    </a>
                    <a
                        href="{{ route("ferry.schedules") }}"
                        class="card hover:shadow-md transition-shadow duration-200 text-center"
                    >
                        <div class="card-body">
                            <div class="text-4xl mb-3">
                                <iconify-icon icon="mdi:ferry"></iconify-icon>
                            </div>
                            <h3 class="font-semibold text-gray-900">
                                Book Ferry
                            </h3>
                            <p class="text-sm text-gray-600">
                                Secure your spot on the next ferry
                            </p>
                        </div>
                    </a>
                    <a
                        href="{{ route("theme-park.index") }}"
                        class="card hover:shadow-md transition-shadow duration-200 text-center"
                    >
                        <div class="card-body">
                            <div class="text-4xl mb-3">
                                <iconify-icon
                                    icon="tabler:rollercoaster"
                                ></iconify-icon>
                            </div>
                            <h3 class="font-semibold text-gray-900">
                                Theme Park
                            </h3>
                            <p class="text-sm text-gray-600">
                                Book tickets and activities
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        @if (isset($userBookings) && $userBookings->count() > 0)
            <div class="card">
                <div class="card-header">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-gray-900">
                            Recent Bookings
                        </h2>
                        <a
                            href="{{ route("bookings.index") }}"
                            class="text-sm btn-secondary"
                        >
                            View All
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Hotel
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Dates
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Amount
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($userBookings->take(5) as $booking)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div
                                                class="text-sm font-medium text-gray-900"
                                            >
                                                {{ $booking->room->hotel->name ?? "N/A" }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $booking->room->room_type ?? "N/A" }}
                                            </div>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                        >
                                            <div>
                                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format("M d, Y") }}
                                            </div>
                                            <div class="text-gray-500">
                                                to
                                                {{ \Carbon\Carbon::parse($booking->check_out_date)->format("M d, Y") }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{
                                                    $booking->booking_status === "confirmed"
                                                        ? "bg-green-100 text-green-800"
                                                        : ($booking->booking_status === "pending"
                                                            ? "bg-yellow-100 text-yellow-800"
                                                            : ($booking->booking_status === "completed"
                                                                ? "bg-blue-100 text-blue-800"
                                                                : "bg-red-100 text-red-800"))
                                                }}"
                                            >
                                                {{ ucfirst($booking->booking_status) }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                        >
                                            ${{ number_format($booking->total_amount, 2) }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium"
                                        >
                                            <a
                                                href="{{ route("bookings.show", $booking) }}"
                                                class="text-primary-600 hover:text-primary-900"
                                            >
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Upcoming Events -->
        @if (isset($upcomingEvents) && $upcomingEvents->count() > 0)
            <div class="card">
                <div class="card-header">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-gray-900">
                            Upcoming Events
                        </h2>
                        <a
                            href="{{ route("beach-events.index") }}"
                            class="text-sm btn-secondary"
                        >
                            View All
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                    >
                        @foreach ($upcomingEvents->take(3) as $event)
                            <div
                                class="card overflow-hidden hover:shadow-md transition-shadow duration-200"
                            >
                                <img
                                    src="{{ $event->image_url }}"
                                    alt="{{ $event->name }}"
                                    class="h-32 w-full object-cover"
                                />
                                <div class="card-body">
                                    <h3 class="font-semibold text-gray-900">
                                        {{ $event->name }}
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($event->event_date)->format("M d, Y") }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $event->location }}
                                    </p>
                                    <div class="mt-3">
                                        <a
                                            href="{{ route("beach-events.show", $event) }}"
                                            class="btn-primary text-sm"
                                        >
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Recent Activity -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-2xl font-bold text-gray-900">
                    Recent Activity
                </h2>
            </div>
            <div class="card-body">
                <div class="space-y-4">
                    <div
                        class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg"
                    >
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
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">
                                Welcome to Picnic Island!
                            </p>
                            <p class="text-sm text-gray-500">
                                Your account was created successfully
                            </p>
                        </div>
                        <span class="text-xs text-gray-400">
                            {{ \Carbon\Carbon::now()->diffForHumans() }}
                        </span>
                    </div>

                    @if (isset($userBookings) && $userBookings->count() > 0)
                        @foreach ($userBookings->take(3) as $booking)
                            <div
                                class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg"
                            >
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
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        Hotel booking
                                        {{ $booking->booking_status }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $booking->room->hotel->name ?? "N/A" }}
                                        -
                                        {{ $booking->room->room_type ?? "N/A" }}
                                    </p>
                                </div>
                                <span class="text-xs text-gray-400">
                                    {{ \Carbon\Carbon::parse($booking->created_at)->diffForHumans() }}
                                </span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Help & Support -->
        <div class="text-center py-8">
            <div class="card max-w-2xl mx-auto">
                <div class="card-body text-center">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        Need Help?
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Our support team is here to help you with any questions
                        or concerns.
                    </p>
                    <div class="flex gap-4 justify-center">
                        <a href="{{ route("contact") }}" class="btn-primary">
                            Contact Support
                        </a>
                        <a
                            href="{{ route("profile.edit") }}"
                            class="btn-secondary"
                        >
                            Update Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
