@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-8">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Admin Dashboard
                </h1>
                <p class="text-sm text-gray-600">
                    System-wide management and analytics.
                </p>
            </div>
            <div class="hidden sm:flex items-center gap-2">
                <a href="{{ route('admin.pending-bookings') }}" class="btn-primary text-xs">Pending Bookings</a>
            </div>
        </div>

        <!-- Management Quick Links -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route("hotels.index") }}" class="card p-6 hover:bg-gray-50 transition duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">Hotel Bookings</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $totalHotelBookings ?? 0 }}</div>
                    </div>
                    <div class="text-primary-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-gray-500">Manage hotel reservations</div>
            </a>
            <a href="{{ route("ferry.index") }}" class="card p-6 hover:bg-gray-50 transition duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">Ferry Tickets</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $totalFerryTickets ?? 0 }}</div>
                    </div>
                    <div class="text-primary-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l2 2 4-4m12 10H3"/></svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-gray-500">
                    Manage ferry operations
                </div>
            </a>
            <a href="{{ route("theme-park.manage") }}" class="card p-6 hover:bg-gray-50 transition duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">Park Tickets</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $totalParkTickets ?? 0 }}</div>
                    </div>
                    <div class="text-primary-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M8 12h8M6 18h12"/></svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-gray-500">
                    Manage theme park activities
                </div>
            </a>
            <a href="{{ route("beach-events.manage") }}" class="card p-6 hover:bg-gray-50 transition duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">Beach Events</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $totalBeachBookings ?? 0 }}</div>
                    </div>
                    <div class="text-primary-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19c3-2 6-2 9 0 3-2 6-2 9 0M5 12a7 7 0 0114 0"/></svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-gray-600">Manage beach events</div>
            </a>
        </div>

        <!-- System Overview -->
        <div class="card">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">
                    System Overview
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="card p-6 bg-gradient-to-br from-blue-50 to-blue-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-blue-600">Total Users</div>
                                <div class="text-2xl font-bold text-blue-900">{{ $totalUsers ?? 0 }}</div>
                                <div class="text-xs text-blue-700">Registered accounts</div>
                            </div>
                            <div class="text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                            </div>
                        </div>
                    </div>
                    <div class="card p-6 bg-gradient-to-br from-green-50 to-green-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-green-600">Total Bookings</div>
                                <div class="text-2xl font-bold text-green-900">{{ ($totalRoomBookings ?? 0) + ($totalBeachBookings ?? 0) }}</div>
                                <div class="text-xs text-green-700">All reservation types</div>
                            </div>
                            <div class="text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                        </div>
                    </div>
                    <div class="card p-6 bg-gradient-to-br from-emerald-50 to-emerald-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-emerald-600">Total Revenue</div>
                                <div class="text-2xl font-bold text-emerald-900">${{ number_format($totalRevenue ?? 0, 2) }}</div>
                                <div class="text-xs text-emerald-700">From all services</div>
                            </div>
                            <div class="text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Bookings Management -->
            <div class="card">
                <div
                    class="p-4 border-b border-gray-200 flex items-center justify-between"
                >
                    <h2 class="font-semibold text-gray-900">Recent Bookings</h2>
                    <a
                        href="{{ route("bookings.index") }}"
                        class="btn-primary text-xs"
                    >
                        View All
                    </a>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">User & Hotel</th>
                                <th class="py-2 pr-4">Room & Date</th>
                                <th class="py-2 pr-4">Amount & Status</th>
                                <th class="py-2 pr-2 text-right w-12">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @forelse ($recentBookings ?? [] as $booking)
                                <tr class="border-t border-gray-200">
                                    <td class="py-3 pr-4">
                                        <div class="font-medium">{{ $booking->user->name ?? "—" }}</div>
                                        <div class="text-xs text-gray-500">{{ $booking->room->hotel->name ?? "—" }}</div>
                                    </td>
                                    <td class="py-3 pr-4">
                                        <div class="font-medium">#{{ $booking->room->room_number ?? "—" }}</div>
                                        <div class="text-xs text-gray-500">{{ $booking->created_at?->toHumanDate() }}</div>
                                    </td>
                                    <td class="py-3 pr-4">
                                        <div class="font-medium">${{ number_format($booking->total_amount ?? 0, 2) }}</div>
                                        <div class="text-xs">
                                            <span
                                                class="px-2 py-1 text-xs rounded-full {{ $booking->booking_status == "confirmed" ? "bg-green-100 text-green-800" : "bg-yellow-100 text-yellow-800" }}"
                                            >
                                                {{ ucfirst($booking->booking_status ?? "pending") }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-3 pr-2 text-right w-12">
                                        <a href="{{ route('bookings.show', $booking->id) }}" class="inline-flex items-center justify-center h-6 w-6 text-blue-600 hover:text-blue-800 transition-colors duration-200" title="View Booking">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-gray-500">
                                        No recent bookings
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Booking Confirmation Panel -->
            <div class="card">
                <div
                    class="p-4 border-b border-gray-200 flex items-center justify-between"
                >
                    <h2 class="font-semibold text-gray-900">
                        Pending Confirmations
                    </h2>
                    <a
                        href="{{ route("admin.pending-bookings") }}"
                        class="btn-primary text-xs"
                    >
                        View All ({{ $totalPendingCount }})
                    </a>
                </div>
                <div class="p-4 space-y-4">
                    <div class="space-y-3">
                        @if (count($pendingRoomBookings) > 0)
                            <!-- Pending Hotel Booking -->
                            @foreach ($pendingRoomBookings as $booking)
                                <div
                                    class="border rounded-lg p-3 border-amber-200 bg-amber-50"
                                >
                                    <div
                                        class="flex items-center justify-between mb-2"
                                    >
                                        <div class="font-medium text-amber-800">
                                            Hotel Booking #{{ $booking->id }}
                                        </div>
                                        <span
                                            class="px-2 py-1 bg-amber-100 text-amber-800 text-xs rounded-full"
                                        >
                                            Pending
                                        </span>
                                    </div>
                                    <div class="text-sm text-amber-700 mb-2">
                                        {{ $booking->user->name }} -
                                        {{ $booking->room->hotel->name }} (Room
                                        #{{ $booking->room->room_number }})
                                        <br />
                                        Check-in:
                                        {{ \Carbon\Carbon::parse($booking->check_in_date)->toHumanDate() }},
                                        Check-out:
                                        {{ \Carbon\Carbon::parse($booking->check_out_date)->toHumanDate() }}
                                    </div>
                                    <div class="flex justify-end space-x-2">
                                        <form
                                            action="{{ route("admin.room-bookings.confirm", $booking->id) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            <button
                                                type="submit"
                                                class="btn-success-outline text-xs flex items-center"
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
                                                        d="M5 13l4 4L19 7"
                                                    />
                                                </svg>
                                                Confirm
                                            </button>
                                        </form>
                                        <form
                                            action="{{ route("admin.room-bookings.reject", $booking->id) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            <button
                                                type="submit"
                                                class="btn-error-outline text-xs flex items-center"
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
                                                        d="M6 18L18 6M6 6l12 12"
                                                    />
                                                </svg>
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        @if (count($pendingFerryTickets) > 0)
                            <!-- Pending Ferry Ticket -->
                            @foreach ($pendingFerryTickets as $ticket)
                                <div
                                    class="border rounded-lg p-3 border-blue-200 bg-blue-50"
                                >
                                    <div
                                        class="flex items-center justify-between mb-2"
                                    >
                                        <div class="font-medium text-blue-800">
                                            Ferry Ticket #{{ $ticket->id }}
                                        </div>
                                        <span
                                            class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full"
                                        >
                                            Pending
                                        </span>
                                    </div>
                                    <div class="text-sm text-blue-700 mb-2">
                                        {{ $ticket->user->name }} -
                                        {{ $ticket->num_passengers }}
                                        passengers
                                        <br />
                                        Travel Date:
                                        {{ \Carbon\Carbon::parse($ticket->travel_date)->toHumanDate() }}
                                    </div>
                                    <div class="flex justify-end space-x-2">
                                        <form
                                            action="{{ route("admin.ferry-tickets.confirm", $ticket->id) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            <button
                                                type="submit"
                                                class="btn-success-outline text-xs flex items-center"
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
                                                        d="M5 13l4 4L19 7"
                                                    />
                                                </svg>
                                                Confirm
                                            </button>
                                        </form>
                                        <form
                                            action="{{ route("admin.ferry-tickets.reject", $ticket->id) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            <button
                                                type="submit"
                                                class="btn-error-outline text-xs flex items-center"
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
                                                        d="M6 18L18 6M6 6l12 12"
                                                    />
                                                </svg>
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        @if (count($pendingParkTickets) > 0)
                            <!-- Pending Theme Park Ticket -->
                            @foreach ($pendingParkTickets as $ticket)
                                <div
                                    class="border rounded-lg p-3 border-purple-200 bg-purple-50"
                                >
                                    <div
                                        class="flex items-center justify-between mb-2"
                                    >
                                        <div
                                            class="font-medium text-purple-800"
                                        >
                                            Theme Park Ticket
                                            #{{ $ticket->id }}
                                        </div>
                                        <span
                                            class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full"
                                        >
                                            Pending
                                        </span>
                                    </div>
                                    <div class="text-sm text-purple-700 mb-2">
                                        {{ $ticket->user->name }} -
                                        {{ $ticket->num_tickets }} tickets
                                        <br />
                                        Visit Date:
                                        {{ \Carbon\Carbon::parse($ticket->visit_date)->toHumanDate() }}
                                    </div>
                                    <div class="flex justify-end space-x-2">
                                        <form
                                            action="{{ route("admin.park-tickets.confirm", $ticket->id) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            <button
                                                type="submit"
                                                class="btn-success-outline text-xs flex items-center"
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
                                                        d="M5 13l4 4L19 7"
                                                    />
                                                </svg>
                                                Confirm
                                            </button>
                                        </form>
                                        <form
                                            action="{{ route("admin.park-tickets.reject", $ticket->id) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            <button
                                                type="submit"
                                                class="btn-error-outline text-xs flex items-center"
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
                                                        d="M6 18L18 6M6 6l12 12"
                                                    />
                                                </svg>
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        @if (count($pendingRoomBookings) == 0 && count($pendingFerryTickets) == 0 && count($pendingParkTickets) == 0)
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
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                <p>No pending confirmations</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <!-- User Management Section -->
        <div class="card">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="font-semibold text-gray-900">User Management</h2>
                <div class="flex items-center gap-2">
                    <a href="{{ route('users.index') }}" class="btn-secondary text-xs">View All</a>
                    <a href="{{ route('users.create') }}" class="btn-primary text-xs flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add User
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                    @forelse ($usersByRole ?? [] as $row)
                        <div class="card p-4 bg-gray-50">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">{{ $row->count ?? 0 }}</div>
                                <div class="text-sm text-gray-600">{{ ucfirst($row->role ?? "—") }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p>No user data available</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
