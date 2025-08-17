@extends('layouts.app')

@section('content')
    <div class="container py-8 space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900">Ferry Ticket #{{ $ticket->id }}</h1>
            <a href="{{ route('ferry.tickets') }}" class="btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Tickets
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="card">
                <div class="card-header">Ticket Details</div>
                <div class="card-body space-y-3">
                    <div class="flex justify-between"><span class="text-sm text-gray-500">Status</span><span class="text-sm font-medium">{{ ucfirst($ticket->booking_status) }}</span></div>
                    <div class="flex justify-between"><span class="text-sm text-gray-500">Travel Date</span><span class="text-sm font-medium">{{ $ticket->travel_date }}</span></div>
                    <div class="flex justify-between"><span class="text-sm text-gray-500">Passengers</span><span class="text-sm font-medium">{{ $ticket->num_passengers }}</span></div>
                    <div class="flex justify-between"><span class="text-sm text-gray-500">Total</span><span class="text-sm font-medium">${{ number_format($ticket->total_amount, 2) }}</span></div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Linked Hotel Booking</div>
                <div class="card-body space-y-3">
                    <div class="flex justify-between"><span class="text-sm text-gray-500">Hotel</span><span class="text-sm font-medium">{{ $ticket->roomBooking?->room?->hotel?->name ?? '—' }}</span></div>
                    <div class="flex justify-between"><span class="text-sm text-gray-500">Room</span><span class="text-sm font-medium">#{{ $ticket->roomBooking?->room?->room_number ?? '—' }}</span></div>
                    <div class="flex justify-between"><span class="text-sm text-gray-500">Dates</span><span class="text-sm font-medium">{{ $ticket->roomBooking?->check_in_date }} → {{ $ticket->roomBooking?->check_out_date }}</span></div>
                    <div class="pt-2 text-right">
                        @if ($ticket->roomBooking)
                            <a href="{{ route('bookings.show', $ticket->roomBooking->id) }}" class="btn-primary">View Booking</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


