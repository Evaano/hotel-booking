@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Beach Events Management
                </h1>
                <p class="text-sm text-gray-600">
                    Manage events and participant bookings
                </p>
            </div>
            <div class="flex space-x-3">
                <a
                    href="{{ route("beach-events.create") }}"
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
                    Create New Event
                </a>
            </div>
        </div>

        <!-- Dashboard Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a
                href="{{ route("beach-events.index") }}"
                class="card p-6 hover:bg-gray-50 transition duration-300 cursor-pointer"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">My Events</div>
                        <div class="mt-2 text-2xl font-bold text-gray-900">
                            {{ $events->count() }}
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
                    Manage beach events
                </div>
            </a>
            <a
                href="{{ route("beach-events.manage-bookings") }}"
                class="card p-6 hover:bg-gray-50 transition duration-300 cursor-pointer"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">
                            Total Participants
                        </div>
                        <div class="mt-2 text-2xl font-bold text-gray-900">
                            {{ $totalParticipants }}
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
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                            />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-gray-600">
                    View all participants
                </div>
            </a>
            <div class="card p-6 bg-blue-50">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">Today's Events</div>
                        <div class="mt-2 text-2xl font-bold text-blue-600">
                            {{ $todayEvents->count() }}
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
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                            />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-blue-700">
                    Events happening today
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
            <!-- Events Table -->
            <div class="lg:col-span-2 card">
                <div
                    class="p-4 border-b border-gray-200 flex items-center justify-between"
                >
                    <h2 class="font-semibold text-gray-900">My Events</h2>
                    <span
                        class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full"
                    >
                        {{ count($events) }} events
                    </span>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">Event Name</th>
                                <th class="py-2 pr-4">Date</th>
                                <th class="py-2 pr-4">Location</th>
                                <th class="py-2 pr-4">Status</th>
                                <th class="py-2 pr-4">Capacity</th>
                                <th class="py-2 pr-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @forelse ($events as $event)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 pr-4">
                                        {{ $event->name }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $event->event_date->format("M d, Y") }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $event->location }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $event->status === "active" ? "bg-green-100 text-green-800" : "bg-gray-100 text-gray-800" }}"
                                        >
                                            {{ ucfirst($event->status) }}
                                        </span>
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $event->capacity }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        <div
                                            class="flex items-center justify-end space-x-2"
                                        >
                                            <a
                                                href="{{ route("beach-events.show", $event) }}"
                                                class="p-1 text-blue-600 hover:text-blue-800 transition-colors duration-200"
                                                title="View Event"
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
                                                href="{{ route("beach-events.edit", $event) }}"
                                                class="p-1 text-indigo-600 hover:text-indigo-800 transition-colors duration-200"
                                                title="Edit Event"
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
                                                href="{{ route("beach-events.event-participants", $event) }}"
                                                class="p-1 text-green-600 hover:text-green-800 transition-colors duration-200"
                                                title="View Participants"
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
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                                    />
                                                </svg>
                                            </a>
                                            <form
                                                method="POST"
                                                action="{{ route("beach-events.destroy", $event) }}"
                                                onsubmit="return confirm('Are you sure you want to delete this event?');"
                                                class="inline"
                                            >
                                                @csrf
                                                @method("DELETE")
                                                <button
                                                    type="submit"
                                                    class="p-1 text-red-600 hover:text-red-800 transition-colors duration-200"
                                                    title="Delete Event"
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
                                        No events found
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
                            Upcoming Events
                        </h2>
                        <a
                            href="{{ route("beach-events.index") }}"
                            class="btn-secondary text-xs"
                        >
                            View All Events
                        </a>
                    </div>
                    <div class="p-4 space-y-4">
                        @forelse ($upcomingEvents->take(5) as $event)
                            <div class="border-b pb-3">
                                <div class="flex justify-between">
                                    <div>
                                        <h4 class="font-medium">
                                            {{ $event->name }}
                                        </h4>
                                        <p class="text-sm text-gray-600">
                                            {{ $event->event_date->format("M d, Y") }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm">
                                            {{ $event->bookings_count ?? 0 }}
                                            participants
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $event->capacity }} capacity
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">No upcoming events</p>
                        @endforelse
                    </div>
                </div>

                <div class="card">
                    <div
                        class="p-4 border-b border-gray-200 flex items-center justify-between"
                    >
                        <h2 class="font-semibold text-gray-900">
                            Recent Bookings
                        </h2>
                        <a
                            href="{{ route("beach-events.manage-bookings") }}"
                            class="btn-secondary text-xs"
                        >
                            View All Participants
                        </a>
                    </div>
                    <div class="p-4 space-y-3">
                        @forelse ($recentBookings->take(5) as $booking)
                            <div class="border-b pb-3">
                                <div class="flex justify-between">
                                    <div>
                                        <h4 class="font-medium">
                                            {{ $booking->user->name }}
                                        </h4>
                                        <p class="text-sm text-gray-600">
                                            {{ $booking->beachEvent->name }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm">
                                            {{ $booking->num_participants }}
                                            participants
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
            </div>
        </div>
    </div>
@endsection
