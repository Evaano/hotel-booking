@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Pending Bookings
                </h1>
                <p class="text-sm text-gray-600">
                    Review and manage all pending bookings across the system
                </p>
            </div>
            <x-back-link :href="route('dashboard')">Back to Dashboard</x-back-link>
        </div>

        <!-- Session Status -->
        @if (session("success"))
            <div
                class="bg-green-50 border border-green-200 text-green-800 rounded-md p-4"
            >
                {{ session("success") }}
            </div>
        @endif

        <!-- Room Bookings Section -->
        <div class="card">
            <div
                class="p-4 border-b border-gray-200 flex items-center justify-between"
            >
                <h2 class="font-semibold text-gray-900">
                    Pending Room Bookings
                </h2>
                <span
                    class="px-3 py-1 bg-amber-100 text-amber-800 text-xs rounded-full"
                >
                    {{ count($pendingRoomBookings) }} pending
                </span>
            </div>
            <div class="p-4 overflow-x-auto">
                @if (count($pendingRoomBookings) > 0)
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">Guest</th>
                                <th class="py-2 pr-4">Hotel</th>
                                <th class="py-2 pr-4">Room</th>
                                <th class="py-2 pr-4">Dates</th>
                                <th class="py-2 pr-4">Amount</th>
                                <th class="py-2 pr-4">Created</th>
                                <th class="py-2 pr-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @foreach ($pendingRoomBookings as $booking)
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
                                        →
                                        {{ \Carbon\Carbon::parse($booking->check_out_date)->toHumanDate() }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        ${{ number_format($booking->total_amount ?? 0, 2) }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $booking->created_at->toHumanDateTime() }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        <div class="flex space-x-2">
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                        <p>No pending room bookings</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Ferry Tickets Section -->
        <div class="card">
            <div
                class="p-4 border-b border-gray-200 flex items-center justify-between"
            >
                <h2 class="font-semibold text-gray-900">
                    Pending Ferry Tickets
                </h2>
                <span
                    class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full"
                >
                    {{ count($pendingFerryTickets) }} pending
                </span>
            </div>
            <div class="p-4 overflow-x-auto">
                @if (count($pendingFerryTickets) > 0)
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">Passenger</th>
                                <th class="py-2 pr-4">Schedule</th>
                                <th class="py-2 pr-4">Travel Date</th>
                                <th class="py-2 pr-4">Passengers</th>
                                <th class="py-2 pr-4">Amount</th>
                                <th class="py-2 pr-4">Created</th>
                                <th class="py-2 pr-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @foreach ($pendingFerryTickets as $ticket)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 pr-4">
                                        {{ $ticket->user->name ?? "—" }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $ticket->ferrySchedule->departure_port ?? "—" }}
                                        →
                                        {{ $ticket->ferrySchedule->arrival_port ?? "—" }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ \Carbon\Carbon::parse($ticket->travel_date)->toHumanDate() }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $ticket->num_passengers }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        ${{ number_format($ticket->total_amount ?? 0, 2) }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $ticket->created_at->toHumanDateTime() }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        <div class="flex space-x-2">
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                        <p>No pending ferry tickets</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Theme Park Tickets Section -->
        <div class="card">
            <div
                class="p-4 border-b border-gray-200 flex items-center justify-between"
            >
                <h2 class="font-semibold text-gray-900">
                    Pending Theme Park Tickets
                </h2>
                <span
                    class="px-3 py-1 bg-purple-100 text-purple-800 text-xs rounded-full"
                >
                    {{ count($pendingParkTickets) }} pending
                </span>
            </div>
            <div class="p-4 overflow-x-auto">
                @if (count($pendingParkTickets) > 0)
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">Visitor</th>
                                <th class="py-2 pr-4">Visit Date</th>
                                <th class="py-2 pr-4">Tickets</th>
                                <th class="py-2 pr-4">Amount</th>
                                <th class="py-2 pr-4">Created</th>
                                <th class="py-2 pr-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @foreach ($pendingParkTickets as $ticket)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 pr-4">
                                        {{ $ticket->user->name ?? "—" }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ \Carbon\Carbon::parse($ticket->visit_date)->toHumanDate() }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $ticket->num_tickets }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        ${{ number_format($ticket->total_amount ?? 0, 2) }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $ticket->created_at->toHumanDateTime() }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        <div class="flex space-x-2">
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                        <p>No pending theme park tickets</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Beach Event Bookings Section -->
        <div class="card">
            <div
                class="p-4 border-b border-gray-200 flex items-center justify-between"
            >
                <h2 class="font-semibold text-gray-900">
                    Pending Beach Event Bookings
                </h2>
                <span
                    class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full"
                >
                    {{ count($pendingBeachBookings) }} pending
                </span>
            </div>
            <div class="p-4 overflow-x-auto">
                @if (count($pendingBeachBookings) > 0)
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">Participant</th>
                                <th class="py-2 pr-4">Event</th>
                                <th class="py-2 pr-4">Event Date</th>
                                <th class="py-2 pr-4">Participants</th>
                                <th class="py-2 pr-4">Amount</th>
                                <th class="py-2 pr-4">Created</th>
                                <th class="py-2 pr-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @foreach ($pendingBeachBookings as $booking)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 pr-4">
                                        {{ $booking->user->name ?? "—" }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $booking->beachEvent->title ?? "—" }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $booking->beachEvent->event_date ? \Carbon\Carbon::parse($booking->beachEvent->event_date)->toHumanDate() : "—" }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $booking->num_participants }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        ${{ number_format($booking->total_amount ?? 0, 2) }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $booking->created_at->toHumanDateTime() }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        <div class="flex space-x-2">
                                            <form
                                                action="{{ route("admin.beach-bookings.confirm", $booking->id) }}"
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
                                                action="{{ route("admin.beach-bookings.reject", $booking->id) }}"
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                        <p>No pending beach event bookings</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
