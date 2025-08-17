@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Beach Organizer Dashboard
                </h1>
                <p class="text-sm text-gray-600">
                    Manage your beach events and participants
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

        <!-- Management Quick Links -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route("beach-events.index") }}" class="card p-6 hover:bg-gray-50 transition duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">My Events</div>
                        <div class="mt-2 text-2xl font-bold text-gray-900">
                            {{ ($events ?? collect())->count() }}
                        </div>
                    </div>
                    <div class="text-primary-600">
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
                                d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"
                            />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-gray-600">
                    Manage all your beach events
                </div>
            </a>
            <a href="{{ route("beach-events.manage-bookings") }}" class="card p-6 hover:bg-gray-50 transition duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">
                            Total Participants
                        </div>
                        <div class="mt-2 text-2xl font-bold text-gray-900">
                            {{ $totalParticipants ?? 0 }}
                        </div>
                    </div>
                    <div class="text-primary-600">
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
                    View and manage participants
                </div>
            </a>
            <x-stat-card label="Monthly Revenue" :value="'$' . number_format($monthlyRevenue ?? 0, 2)" hint="From event bookings" valueClass="text-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-stat-card>
        </div>

        <!-- Today's Events -->
        <div class="card">
            <div
                class="p-4 border-b border-gray-200 flex items-center justify-between"
            >
                <h2 class="font-semibold text-gray-900">Today's Events</h2>
                <div class="text-sm text-gray-600">
                    {{ now()->format("F j, Y") }}
                </div>
            </div>
            <div class="p-6">
                @if (count($todayEvents ?? []) > 0)
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"
                    >
                        @foreach ($todayEvents as $event)
                            <div
                                class="border rounded-lg p-4 bg-blue-50 border-blue-200"
                            >
                                <div class="font-medium text-blue-800">
                                    {{ $event->title ?? "—" }}
                                </div>
                                <div class="text-sm text-blue-600 mt-1">
                                    {{ $event->event_date ?? "—" }}
                                </div>
                                <div
                                    class="flex items-center justify-between mt-3"
                                >
                                    <span
                                        class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-700"
                                    >
                                        {{ ucfirst($event->status ?? "—") }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-12 w-12 mx-auto text-gray-400 mb-3"
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
                        <p>No events scheduled for today</p>
                        <a
                            href="{{ route("beach-events.create") }}"
                            class="mt-2 inline-block text-sm text-blue-600 hover:underline"
                        >
                            Create a new event
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Event Management -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Upcoming Events -->
            <div class="card">
                <div
                    class="p-4 border-b border-gray-200 flex items-center justify-between"
                >
                    <h2 class="font-semibold text-gray-900">Upcoming Events</h2>
                    <a
                        href="{{ route("beach-events.index") }}"
                        class="btn-secondary text-xs"
                    >
                        View All Events
                    </a>
                </div>
                <div class="p-4 space-y-3">
                    @forelse ($upcomingEvents ?? [] as $event)
                        <div
                            class="flex items-center justify-between border rounded-lg p-3 border-gray-200 hover:bg-gray-50 transition duration-200"
                        >
                            <div>
                                <div class="font-medium">
                                    {{ $event->title ?? "—" }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $event->event_date ?? "—" }}
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span
                                    class="text-xs px-2 py-1 rounded bg-emerald-100 text-emerald-700"
                                >
                                    {{ ucfirst($event->status ?? "—") }}
                                </span>
                                <div class="flex space-x-3">
                                    <a
                                        href="{{ route("beach-events.show", $event->id) }}"
                                        class="text-blue-600 hover:text-blue-800"
                                        title="View Event Details"
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
                                        href="{{ route("beach-events.edit", $event->id) }}"
                                        class="text-blue-600 hover:text-blue-800"
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
                                        href="#"
                                        class="text-green-600 hover:text-green-800"
                                        title="Manage Participants"
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
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <p>No upcoming events</p>
                            <a
                                href="{{ route("beach-events.create") }}"
                                class="mt-2 inline-block text-sm text-blue-600 hover:underline"
                            >
                                Create a new event
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="card">
                <div
                    class="p-4 border-b border-gray-200 flex items-center justify-between"
                >
                    <h2 class="font-semibold text-gray-900">Recent Bookings</h2>
                    <a
                        href="{{ route("beach-events.bookings") }}"
                        class="btn-secondary text-xs"
                    >
                        View All Bookings
                    </a>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">User</th>
                                <th class="py-2 pr-4">Event</th>
                                <th class="py-2 pr-4">Participants</th>
                                <th class="py-2 pr-4">Status</th>
                                <th class="py-2 pr-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @forelse ($recentBookings ?? [] as $booking)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 pr-4">
                                        {{ $booking->user->name ?? "—" }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $booking->beachEvent->title ?? "—" }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800"
                                        >
                                            {{ $booking->num_participants ?? "—" }}
                                        </span>
                                    </td>
                                    <td class="py-2 pr-4">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $booking->booking_status == "confirmed" ? "bg-green-100 text-green-800" : "bg-yellow-100 text-yellow-800" }}"
                                        >
                                            {{ ucfirst($booking->booking_status ?? "—") }}
                                        </span>
                                    </td>
                                    <td class="py-2 pr-4 text-right">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a
                                                href="{{ route("beach-events.show-booking", $booking->id) }}"
                                                class="text-blue-600 hover:text-blue-800"
                                                title="View Booking Details"
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
                                                href="#"
                                                class="text-blue-600 hover:text-blue-800"
                                                title="Edit Booking"
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
                                                href="#"
                                                class="text-green-600 hover:text-green-800"
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
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-gray-500">
                                        No recent bookings
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
