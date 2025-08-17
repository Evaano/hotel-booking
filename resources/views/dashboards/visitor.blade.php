@extends('layouts.app')

@section('content')
    <div class="container py-8 space-y-8">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Visitor Dashboard</h1>
                <p class="text-sm text-gray-600">Welcome back! Here's a quick overview.</p>
            </div>
            <div class="hidden sm:flex items-center gap-2">
                <a href="{{ route('my.bookings') }}" class="btn-primary text-xs">My Bookings</a>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-stat-card label="Total Spent" :value="'$' . number_format($totalSpent ?? 0, 2)" valueClass="text-emerald-600" />
            <x-stat-card label="Total Bookings" :value="$totalBookings ?? 0" />
            <x-stat-card label="Confirmed" :value="$confirmedBookings ?? 0" />
            <x-stat-card label="Pending" :value="$pendingBookings ?? 0" />
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="font-semibold text-gray-900">Quick Actions</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <a href="{{ route('hotels.browse') }}" class="card p-6 hover:bg-gray-50 transition duration-300 cursor-pointer">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-500">Hotels</div>
                                <div class="mt-2 font-medium text-gray-900">Browse & Book</div>
                            </div>
                            <div class="text-primary-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M5 18h14M7 6h10"/></svg>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('ferry.schedules') }}" class="card p-6 hover:bg-gray-50 transition duration-300 cursor-pointer">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-500">Ferry</div>
                                <div class="mt-2 font-medium text-gray-900">View Schedules</div>
                            </div>
                            <div class="text-primary-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l2 2 4-4m0 0l2 2 4-4m0 0l2 2 4-4M4 21h16"/></svg>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('theme-park.index') }}" class="card p-6 hover:bg-gray-50 transition duration-300 cursor-pointer">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-500">Theme Park</div>
                                <div class="mt-2 font-medium text-gray-900">Tickets & Activities</div>
                            </div>
                            <div class="text-primary-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M6 18h12M8 12h8"/></svg>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('beach-events.index') }}" class="card p-6 hover:bg-gray-50 transition duration-300 cursor-pointer">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-500">Beach Events</div>
                                <div class="mt-2 font-medium text-gray-900">Explore Events</div>
                            </div>
                            <div class="text-primary-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19c3-2 6-2 9 0 3-2 6-2 9 0M5 12a7 7 0 0114 0"/></svg>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Personal Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="card">
                <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900">Recent Hotel Bookings</h2>
                    <a href="{{ route('hotel.bookings') }}" class="btn-primary text-xs">View All</a>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">Hotel</th>
                                <th class="py-2 pr-4">Room</th>
                                <th class="py-2 pr-4">Dates</th>
                                <th class="py-2 pr-4">Status</th>
                                <th class="py-2 pr-2 text-right w-12">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @forelse ($recentHotelBookings ?? [] as $booking)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 pr-4">{{ $booking->room?->hotel?->name ?? '—' }}</td>
                                    <td class="py-2 pr-4">#{{ $booking->room?->room_number ?? '—' }}</td>
                                    <td class="py-2 pr-4">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }} → {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $booking->booking_status == 'confirmed' ? 'bg-green-100 text-green-800' : ($booking->booking_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($booking->booking_status ?? '—') }}
                                        </span>
                                    </td>
                                    <td class="py-2 pr-2 text-right w-12">
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
                                    <td colspan="5" class="py-4 text-gray-500">No recent bookings</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900">Upcoming Ferry Tickets</h2>
                    <a href="{{ route('ferry.tickets') }}" class="btn-primary text-xs">View All</a>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">Schedule</th>
                                <th class="py-2 pr-4">Travel Date</th>
                                <th class="py-2 pr-4">Passengers</th>
                                <th class="py-2 pr-2 text-right w-12">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @forelse ($upcomingFerryTickets ?? [] as $ticket)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 pr-4">#{{ $ticket->ferrySchedule?->id ?? '—' }}</td>
                                    <td class="py-2 pr-4">{{ \Carbon\Carbon::parse($ticket->travel_date)->format('M d, Y') }}</td>
                                    <td class="py-2 pr-4">{{ $ticket->num_passengers ?? '—' }}</td>
                                    <td class="py-2 pr-2 text-right w-12">
                                        <a href="{{ route('ferry.tickets.show', $ticket->id) }}" class="inline-flex items-center justify-center h-6 w-6 text-blue-600 hover:text-blue-800 transition-colors duration-200" title="View Ticket">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-gray-500">No upcoming ferry tickets</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900">Upcoming Park Tickets</h2>
                    <a href="{{ route('theme-park.tickets') }}" class="btn-primary text-xs">View All</a>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">Visit Date</th>
                                <th class="py-2 pr-4">Tickets</th>
                                <th class="py-2 pr-4">Status</th>
                                <th class="py-2 pr-2 text-right w-12">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @forelse ($upcomingParkTickets ?? [] as $ticket)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 pr-4">{{ \Carbon\Carbon::parse($ticket->visit_date)->format('M d, Y') }}</td>
                                    <td class="py-2 pr-4">{{ $ticket->num_tickets ?? '—' }}</td>
                                    <td class="py-2 pr-4">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $ticket->ticket_status == 'confirmed' ? 'bg-green-100 text-green-800' : ($ticket->ticket_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($ticket->ticket_status ?? '—') }}
                                        </span>
                                    </td>
                                    <td class="py-2 pr-2 text-right w-12">
                                        <a href="{{ route('theme-park.tickets.show', $ticket->id) }}" class="inline-flex items-center justify-center h-6 w-6 text-blue-600 hover:text-blue-800 transition-colors duration-200" title="View Ticket">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-gray-500">No upcoming park tickets</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900">Upcoming Beach Events</h2>
                    <a href="{{ route('beach-events.bookings') }}" class="btn-primary text-xs">View All</a>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">Event</th>
                                <th class="py-2 pr-4">Date</th>
                                <th class="py-2 pr-4">Status</th>
                                <th class="py-2 pr-2 text-right w-12">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @forelse ($upcomingBeachEvents ?? [] as $booking)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 pr-4">{{ $booking->beachEvent?->name ?? '—' }}</td>
                                    <td class="py-2 pr-4">{{ $booking->beachEvent?->event_date ? \Carbon\Carbon::parse($booking->beachEvent->event_date)->format('M d, Y') : '—' }}</td>
                                    <td class="py-2 pr-4">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $booking->booking_status == 'confirmed' ? 'bg-green-100 text-green-800' : ($booking->booking_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($booking->booking_status ?? '—') }}
                                        </span>
                                    </td>
                                    <td class="py-2 pr-2 text-right w-12">
                                        <a href="{{ route('beach-events.show-booking', $booking->id) }}" class="inline-flex items-center justify-center h-6 w-6 text-blue-600 hover:text-blue-800 transition-colors duration-200" title="View Booking">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-gray-500">No upcoming beach events</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
