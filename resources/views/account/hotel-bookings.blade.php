@extends("layouts.app")

@section("content")
    <div class="max-w-7xl mx-auto p-6 space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900">My Hotel Bookings</h1>
            <x-back-link :href="route('dashboard')">Back to Dashboard</x-back-link>
        </div>

        <div class="card overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th class="px-4 py-3">Hotel</th>
                        <th class="px-4 py-3">Room</th>
                        <th class="px-4 py-3">Dates</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Amount</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                        @forelse ($roomBookings as $booking)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-medium">{{ $booking->room->hotel->name ?? '—' }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->room->hotel->address ?? '—' }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium">#{{ $booking->room->room_number ?? '—' }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->room->room_type ?? '—' }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium">{{ $booking->check_in_date ? \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') : '—' }}</div>
                                    <div class="text-xs text-gray-500">to {{ $booking->check_out_date ? \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') : '—' }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $booking->booking_status == 'confirmed' ? 'bg-green-100 text-green-800' : ($booking->booking_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($booking->booking_status ?? 'pending') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">${{ number_format($booking->total_amount ?? 0, 2) }}</td>
                                <td class="px-4 py-3">
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
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center space-y-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M5 18h14M7 6h10" />
                                        </svg>
                                        <p>No hotel bookings found</p>
                                        <a href="{{ route('hotels.browse') }}" class="btn-primary">Browse Hotels</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
        </div>
    </div>
@endsection