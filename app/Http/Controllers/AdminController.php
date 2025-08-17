<?php

namespace App\Http\Controllers;

use App\Models\BeachEventBooking;
use App\Models\FerryTicket;
use App\Models\RoomBooking;
use App\Models\ThemeParkTicket;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Constructor to ensure only admins can access these methods
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (! Auth::user() || ! Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized action.');
            }

            return $next($request);
        });
    }

    /**
     * Display a list of all pending bookings
     */
    public function pendingBookings()
    {
        // Get pending room bookings
        $pendingRoomBookings = RoomBooking::where('booking_status', 'pending')
            ->with(['user', 'room.hotel'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get pending ferry tickets
        $pendingFerryTickets = FerryTicket::where('booking_status', 'pending')
            ->with(['user', 'ferrySchedule', 'roomBooking'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get pending theme park tickets
        $pendingParkTickets = ThemeParkTicket::where('ticket_status', 'pending')
            ->with(['user', 'roomBooking'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get pending beach event bookings
        $pendingBeachBookings = BeachEventBooking::where('booking_status', 'pending')
            ->with(['user', 'beachEvent'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pending-bookings', compact(
            'pendingRoomBookings',
            'pendingFerryTickets',
            'pendingParkTickets',
            'pendingBeachBookings'
        ));
    }

    /**
     * Confirm a room booking
     */
    public function confirmRoomBooking($id)
    {
        $booking = RoomBooking::findOrFail($id);
        $booking->booking_status = 'confirmed';
        $booking->save();

        // Update room status to occupied for the booking dates
        $room = $booking->room;
        $room->status = 'occupied';
        $room->save();

        return redirect()->back()->with('success', 'Room booking confirmed successfully.');
    }

    /**
     * Reject a room booking
     */
    public function rejectRoomBooking($id)
    {
        $booking = RoomBooking::findOrFail($id);
        $booking->booking_status = 'rejected';
        $booking->save();

        return redirect()->back()->with('success', 'Room booking rejected.');
    }

    /**
     * Confirm a ferry ticket
     */
    public function confirmFerryTicket($id)
    {
        $ticket = FerryTicket::findOrFail($id);
        $ticket->booking_status = 'confirmed';
        $ticket->save();

        return redirect()->back()->with('success', 'Ferry ticket confirmed successfully.');
    }

    /**
     * Reject a ferry ticket
     */
    public function rejectFerryTicket($id)
    {
        $ticket = FerryTicket::findOrFail($id);
        $ticket->booking_status = 'rejected';
        $ticket->save();

        return redirect()->back()->with('success', 'Ferry ticket rejected.');
    }

    /**
     * Confirm a theme park ticket
     */
    public function confirmParkTicket($id)
    {
        $ticket = ThemeParkTicket::findOrFail($id);
        $ticket->ticket_status = 'confirmed';
        $ticket->save();

        return redirect()->back()->with('success', 'Theme park ticket confirmed successfully.');
    }

    /**
     * Reject a theme park ticket
     */
    public function rejectParkTicket($id)
    {
        $ticket = ThemeParkTicket::findOrFail($id);
        $ticket->ticket_status = 'rejected';
        $ticket->save();

        return redirect()->back()->with('success', 'Theme park ticket rejected.');
    }

    /**
     * Confirm a beach event booking
     */
    public function confirmBeachBooking($id)
    {
        $booking = BeachEventBooking::findOrFail($id);
        $booking->booking_status = 'confirmed';
        $booking->save();

        return redirect()->back()->with('success', 'Beach event booking confirmed successfully.');
    }

    /**
     * Reject a beach event booking
     */
    public function rejectBeachBooking($id)
    {
        $booking = BeachEventBooking::findOrFail($id);
        $booking->booking_status = 'rejected';
        $booking->save();

        return redirect()->back()->with('success', 'Beach event booking rejected.');
    }

    /**
     * Get pending bookings count for dashboard
     */
    public function getPendingBookingsCount()
    {
        $pendingRoomBookings = RoomBooking::where('booking_status', 'pending')->count();
        $pendingFerryTickets = FerryTicket::where('booking_status', 'pending')->count();
        $pendingParkTickets = ThemeParkTicket::where('ticket_status', 'pending')->count();
        $pendingBeachBookings = BeachEventBooking::where('booking_status', 'pending')->count();

        $totalPending = $pendingRoomBookings + $pendingFerryTickets + $pendingParkTickets + $pendingBeachBookings;

        return [
            'room_bookings' => $pendingRoomBookings,
            'ferry_tickets' => $pendingFerryTickets,
            'park_tickets' => $pendingParkTickets,
            'beach_bookings' => $pendingBeachBookings,
            'total' => $totalPending,
        ];
    }
}
