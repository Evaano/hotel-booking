@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Hotel Management
                </h1>
                <p class="text-sm text-gray-600">
                    Manage hotels, rooms, and bookings
                </p>
            </div>
            <div class="flex space-x-3">
                <a
                    href="{{ route("hotels.create") }}"
                    class="btn-primary flex items-center"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 mr-1"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v16m8-8H4"
                        />
                    </svg>
                    Create New Hotel
                </a>
            </div>
        </div>

        <!-- Dashboard Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="card p-6 hover:bg-gray-50 transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">My Hotels</div>
                        <div class="mt-2 text-2xl font-bold text-gray-900">
                            {{ $hotels->count() }}
                        </div>
                    </div>
                    <div class="text-blue-600">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                            />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-gray-600">
                    Manage hotel properties
                </div>
            </div>
            <div class="card p-6 hover:bg-gray-50 transition duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">Total Bookings</div>
                        <div class="mt-2 text-2xl font-bold text-gray-900">
                            {{ $totalBookings }}
                        </div>
                    </div>
                    <div class="text-blue-600">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                            />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-gray-600">
                    All hotel reservations
                </div>
            </div>
            <div class="card p-6 bg-blue-50">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">
                            Pending Bookings
                        </div>
                        <div class="mt-2 text-2xl font-bold text-blue-600">
                            {{ $pendingBookings->count() }}
                        </div>
                    </div>
                    <div class="text-blue-500">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-blue-700">
                    Bookings awaiting confirmation
                </div>
            </div>
            <div class="card p-6 bg-amber-50">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">Monthly Revenue</div>
                        <div class="mt-2 text-2xl font-bold text-amber-600">
                            ${{ number_format($monthlyRevenue, 2) }}
                        </div>
                    </div>
                    <div class="text-amber-500">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-amber-700">
                    Revenue this month
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Hotels Table -->
            <div class="lg:col-span-2 card">
                <div
                    class="p-4 border-b border-gray-200 flex items-center justify-between"
                >
                    <h2 class="font-semibold text-gray-900">My Hotels</h2>
                    <span
                        class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full"
                    >
                        {{ count($hotels) }} hotels
                    </span>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">ID</th>
                                <th class="py-2 pr-4">Name</th>
                                <th class="py-2 pr-4">Address</th>
                                <th class="py-2 pr-4">Status</th>
                                <th class="py-2 pr-4">Rooms</th>
                                <th class="py-2 pr-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @forelse ($hotels as $hotel)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 pr-4">{{ $hotel->id }}</td>
                                    <td class="py-2 pr-4">
                                        {{ $hotel->name }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ Str::limit($hotel->address, 30) }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $hotel->status === "active" ? "bg-green-100 text-green-800" : "bg-gray-100 text-gray-800" }}"
                                        >
                                            {{ ucfirst($hotel->status) }}
                                        </span>
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $hotel->rooms->count() }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        <div
                                            class="flex items-center justify-end space-x-2"
                                        >
                                            <a
                                                href="{{ route("hotels.show", $hotel) }}"
                                                class="p-1 text-blue-600 hover:text-blue-800 transition-colors duration-200"
                                                title="View Hotel"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                    />
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                    />
                                                </svg>
                                            </a>
                                            <a
                                                href="{{ route("hotels.edit", $hotel) }}"
                                                class="p-1 text-indigo-600 hover:text-indigo-800 transition-colors duration-200"
                                                title="Edit Hotel"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                    />
                                                </svg>
                                            </a>
                                            <a
                                                href="{{ route("hotels.rooms.index", $hotel) }}"
                                                class="p-1 text-green-600 hover:text-green-800 transition-colors duration-200"
                                                title="View Rooms"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                                                    />
                                                </svg>
                                            </a>
                                            <form
                                                method="POST"
                                                action="{{ route("hotels.destroy", $hotel) }}"
                                                onsubmit="return confirm('Are you sure you want to delete this hotel?');"
                                                class="inline"
                                            >
                                                @csrf
                                                @method("DELETE")
                                                <button
                                                    type="submit"
                                                    class="p-1 text-red-600 hover:text-red-800 transition-colors duration-200"
                                                    title="Delete Hotel"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                        />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="6"
                                        class="py-4 text-gray-500 text-center"
                                    >
                                        No hotels found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Side Cards -->
            <div class="space-y-6">
                <div class="card">
                    <div
                        class="p-4 border-b border-gray-200 flex items-center justify-between"
                    >
                        <h2 class="font-semibold text-gray-900">
                            Recent Bookings
                        </h2>
                    </div>
                    <div class="p-4 space-y-4">
                        @forelse ($recentBookings as $booking)
                            <div class="border-b pb-3">
                                <div class="flex justify-between">
                                    <div>
                                        <h4 class="font-medium">
                                            {{ $booking->user->name ?? "Guest" }}
                                        </h4>
                                        <p class="text-sm text-gray-600">
                                            {{ $booking->room->hotel->name ?? "Hotel" }}
                                            - Room
                                            #{{ $booking->room->room_number ?? "N/A" }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm">
                                            {{ \Carbon\Carbon::parse($booking->check_in_date)->toHumanDate() }}
                                        </p>
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $booking->booking_status === "confirmed" ? "bg-green-100 text-green-800" : ($booking->booking_status === "pending" ? "bg-yellow-100 text-yellow-800" : "bg-gray-100 text-gray-800") }}"
                                        >
                                            {{ ucfirst($booking->booking_status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">No recent bookings</p>
                        @endforelse
                    </div>
                </div>

                <div class="card">
                    <div
                        class="p-4 border-b border-gray-200 flex items-center justify-between"
                    >
                        <h2 class="font-semibold text-gray-900">
                            Pending Bookings
                        </h2>
                    </div>
                    <div class="p-4 space-y-3">
                        @forelse ($pendingBookings as $booking)
                            <div class="border-b pb-3">
                                <div class="flex justify-between">
                                    <div>
                                        <h4 class="font-medium">
                                            {{ $booking->user->name ?? "Guest" }}
                                        </h4>
                                        <p class="text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($booking->check_in_date)->toHumanDate() }}
                                            →
                                            {{ \Carbon\Carbon::parse($booking->check_out_date)->toHumanDate() }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <div
                                            class="flex space-x-2 justify-end mb-1"
                                        >
                                            <form
                                                action="{{ route("bookings.update-status", $booking) }}"
                                                method="POST"
                                                class="inline"
                                            >
                                                @csrf
                                                @method("PUT")
                                                <input
                                                    type="hidden"
                                                    name="booking_status"
                                                    value="confirmed"
                                                />
                                                <button
                                                    type="submit"
                                                    class="text-xs bg-green-100 hover:bg-green-200 text-green-800 py-1 px-2 rounded"
                                                >
                                                    Confirm
                                                </button>
                                            </form>
                                            <form
                                                action="{{ route("bookings.update-status", $booking) }}"
                                                method="POST"
                                                class="inline"
                                            >
                                                @csrf
                                                @method("PUT")
                                                <input
                                                    type="hidden"
                                                    name="booking_status"
                                                    value="cancelled"
                                                />
                                                <button
                                                    type="submit"
                                                    class="text-xs bg-red-100 hover:bg-red-200 text-red-800 py-1 px-2 rounded"
                                                >
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            ${{ number_format($booking->total_amount, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">No pending bookings</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="card">
            <div
                class="p-4 border-b border-gray-200 flex items-center justify-between"
            >
                <h2 class="font-semibold text-gray-900">All Bookings</h2>
                <span
                    class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full"
                >
                    {{ $bookings->count() }} bookings
                </span>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-500">
                        <tr>
                            <th class="py-2 pr-4">Guest</th>
                            <th class="py-2 pr-4">Hotel</th>
                            <th class="py-2 pr-4">Room</th>
                            <th class="py-2 pr-4">Check-in</th>
                            <th class="py-2 pr-4">Check-out</th>
                            <th class="py-2 pr-4">Amount</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2 pr-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-900">
                        @forelse ($bookings as $booking)
                            <tr class="border-t border-gray-200">
                                <td class="py-2 pr-4">
                                    {{ $booking->user->name ?? "—" }}
                                </td>
                                <td class="py-2 pr-4">
                                    {{ $booking->room->hotel->name ?? "—" }}
                                </td>
                                <td class="py-2 pr-4">
                                    #{{ $booking->room->room_number ?? "—" }}
                                </td>
                                <td class="py-2 pr-4">
                                    {{ \Carbon\Carbon::parse($booking->check_in_date)->toHumanDate() }}
                                </td>
                                <td class="py-2 pr-4">
                                    {{ \Carbon\Carbon::parse($booking->check_out_date)->toHumanDate() }}
                                </td>
                                <td class="py-2 pr-4">
                                    ${{ number_format($booking->total_amount, 2) }}
                                </td>
                                <td class="py-2 pr-4">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{
                                            $booking->booking_status == "confirmed"
                                                ? "bg-green-100 text-green-800"
                                                : ($booking->booking_status == "pending"
                                                    ? "bg-yellow-100 text-yellow-800"
                                                    : "bg-red-100 text-red-800")
                                        }}"
                                    >
                                        {{ ucfirst($booking->booking_status) }}
                                    </span>
                                </td>
                                <td class="py-2 pr-4">
                                    <div
                                        class="flex items-center justify-end space-x-2"
                                    >
                                        <a
                                            href="{{ route("bookings.show", $booking) }}"
                                            class="p-1 text-blue-600 hover:text-blue-800 transition-colors duration-200"
                                            title="View Booking"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                />
                                            </svg>
                                        </a>
                                        @if ($booking->booking_status == "pending")
                                            <form
                                                action="{{ route("bookings.update-status", $booking) }}"
                                                method="POST"
                                                class="inline"
                                            >
                                                @csrf
                                                @method("PUT")
                                                <input
                                                    type="hidden"
                                                    name="booking_status"
                                                    value="confirmed"
                                                />
                                                <button
                                                    type="submit"
                                                    class="p-1 text-green-600 hover:text-green-800 transition-colors duration-200"
                                                    title="Confirm Booking"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M5 13l4 4L19 7"
                                                        />
                                                    </svg>
                                                </button>
                                            </form>
                                            <form
                                                action="{{ route("bookings.update-status", $booking) }}"
                                                method="POST"
                                                class="inline"
                                            >
                                                @csrf
                                                @method("PUT")
                                                <input
                                                    type="hidden"
                                                    name="booking_status"
                                                    value="cancelled"
                                                />
                                                <button
                                                    type="submit"
                                                    class="p-1 text-red-600 hover:text-red-800 transition-colors duration-200"
                                                    title="Cancel Booking"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M6 18L18 6M6 6l12 12"
                                                        />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="8"
                                    class="py-4 text-center text-gray-500"
                                >
                                    No bookings found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
