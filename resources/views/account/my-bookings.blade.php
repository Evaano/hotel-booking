@extends("layouts.app")

@section("content")
    <div class="max-w-7xl mx-auto p-6 space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900">My Bookings</h1>
            <x-back-link :href="route('dashboard')">Back to Dashboard</x-back-link>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="card">
                <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900">Hotel Bookings</h2>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $roomBookings->count() }}</span>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">Hotel</th>
                                <th class="py-2 pr-4">Room</th>
                                <th class="py-2 pr-4">Dates</th>
                                <th class="py-2 pr-4">Status</th>
                                <th class="py-2 pr-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @forelse ($roomBookings as $booking)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 pr-4">{{ $booking->room->hotel->name ?? '—' }}</td>
                                    <td class="py-2 pr-4">#{{ $booking->room->room_number ?? '—' }}</td>
                                    <td class="py-2 pr-4">{{ $booking->check_in_date }} → {{ $booking->check_out_date }}</td>
                                    <td class="py-2 pr-4">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $booking->booking_status === 'confirmed' ? 'bg-green-100 text-green-800' : ($booking->booking_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($booking->booking_status ?? '—') }}
                                        </span>
                                    </td>
                                    <td class="py-2 pr-4 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('bookings.show', $booking) }}" class="inline-flex items-center justify-center h-6 w-6 text-blue-600 hover:text-blue-800 transition-colors duration-200" title="View Booking">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            @if (($booking->booking_status ?? '') !== 'cancelled')
                                                <form method="POST" action="{{ route('bookings.cancel', $booking) }}" class="inline" onsubmit="return confirm('Cancel this booking?');">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center justify-center h-6 w-6 text-red-600 hover:text-red-800 transition-colors duration-200" title="Cancel Booking" aria-label="Cancel Booking">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-gray-500">No hotel bookings</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900">Ferry Tickets</h2>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $ferryTickets->count() }}</span>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">Schedule</th>
                                <th class="py-2 pr-4">Travel Date</th>
                                <th class="py-2 pr-4">Passengers</th>
                                <th class="py-2 pr-4">Status</th>
                                <th class="py-2 pr-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @forelse ($ferryTickets as $ticket)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 pr-4">#{{ $ticket->ferrySchedule->id ?? '—' }}</td>
                                    <td class="py-2 pr-4">{{ $ticket->travel_date }}</td>
                                    <td class="py-2 pr-4">{{ $ticket->num_passengers ?? '—' }}</td>
                                    <td class="py-2 pr-4">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $ticket->booking_status === 'confirmed' ? 'bg-green-100 text-green-800' : ($ticket->booking_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($ticket->booking_status ?? '—') }}
                                        </span>
                                    </td>
                                    <td class="py-2 pr-4 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('ferry.tickets.show', $ticket) }}" class="inline-flex items-center justify-center h-6 w-6 text-blue-600 hover:text-blue-800 transition-colors duration-200" title="View Ferry Ticket">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            @if (($ticket->booking_status ?? '') !== 'cancelled')
                                                <form method="POST" action="{{ route('ferry.cancel-ticket', $ticket) }}" class="inline" onsubmit="return confirm('Cancel this ferry ticket?');">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center justify-center h-6 w-6 text-red-600 hover:text-red-800 transition-colors duration-200" title="Cancel Ferry Ticket" aria-label="Cancel Ferry Ticket">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-gray-500">No ferry tickets</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900">Theme Park Tickets</h2>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $parkTickets->count() }}</span>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">Visit Date</th>
                                <th class="py-2 pr-4">Tickets</th>
                                <th class="py-2 pr-4">Status</th>
                                <th class="py-2 pr-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @forelse ($parkTickets as $ticket)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 pr-4">{{ $ticket->visit_date }}</td>
                                    <td class="py-2 pr-4">{{ $ticket->num_tickets ?? '—' }}</td>
                                    <td class="py-2 pr-4">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $ticket->ticket_status === 'confirmed' ? 'bg-green-100 text-green-800' : ($ticket->ticket_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($ticket->ticket_status ?? '—') }}
                                        </span>
                                    </td>
                                    <td class="py-2 pr-4 text-right">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('theme-park.ticket.activities', $ticket->id) }}" class="p-1 text-blue-600 hover:text-blue-800 transition-colors duration-200" title="View Activities">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            @if (($ticket->ticket_status ?? '') !== 'cancelled')
                                                <form method="POST" action="{{ route('theme-park.cancel-ticket', $ticket) }}" class="inline" onsubmit="return confirm('Cancel this park ticket?');">
                                                    @csrf
                                                    <button type="submit" class="p-1 text-red-600 hover:text-red-800 transition-colors duration-200" title="Cancel Park Ticket" aria-label="Cancel Park Ticket">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">No park tickets</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900">Activity Bookings</h2>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $activityBookings->count() }}</span>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">Activity</th>
                                <th class="py-2 pr-4">Time</th>
                                <th class="py-2 pr-4">Participants</th>
                                <th class="py-2 pr-4">Status</th>
                                <th class="py-2 pr-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @forelse ($activityBookings as $ab)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 pr-4">{{ $ab->parkActivity->name ?? '—' }}</td>
                                    <td class="py-2 pr-4">{{ $ab->booking_time?->format('Y-m-d H:i') ?? '—' }}</td>
                                    <td class="py-2 pr-4">{{ $ab->num_participants ?? '—' }}</td>
                                    <td class="py-2 pr-4">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $ab->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($ab->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($ab->status ?? '—') }}
                                        </span>
                                    </td>
                                    <td class="py-2 pr-4 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            @if (($ab->status ?? '') !== 'cancelled')
                                                <form method="POST" action="{{ route('theme-park.cancel-activity', $ab) }}" class="inline" onsubmit="return confirm('Cancel this activity booking?');">
                                                    @csrf
                                                    <button type="submit" class="p-1 text-red-600 hover:text-red-800 transition-colors duration-200" title="Cancel Activity" aria-label="Cancel Activity">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">No activity bookings</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900">Beach Event Bookings</h2>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $beachEventBookings->count() }}</span>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">Event</th>
                                <th class="py-2 pr-4">Date</th>
                                <th class="py-2 pr-4">Status</th>
                                <th class="py-2 pr-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @forelse ($beachEventBookings as $booking)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 pr-4">{{ $booking->beachEvent->title ?? '—' }}</td>
                                    <td class="py-2 pr-4">{{ $booking->beachEvent->event_date ?? '—' }}</td>
                                    <td class="py-2 pr-4">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $booking->booking_status === 'confirmed' ? 'bg-green-100 text-green-800' : ($booking->booking_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($booking->booking_status ?? '—') }}
                                        </span>
                                    </td>
                                    <td class="py-2 pr-4 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('beach-events.show-booking', $booking->id) }}" class="p-1 text-blue-600 hover:text-blue-800 transition-colors duration-200" title="View Booking">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            @if (($booking->booking_status ?? '') !== 'cancelled')
                                                <form method="POST" action="{{ route('beach-events.cancel-booking', $booking) }}" class="inline" onsubmit="return confirm('Cancel this beach event booking?');">
                                                    @csrf
                                                    <button type="submit" class="p-1 text-red-600 hover:text-red-800 transition-colors duration-200" title="Cancel Beach Event Booking" aria-label="Cancel Beach Event Booking">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">No beach event bookings</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


