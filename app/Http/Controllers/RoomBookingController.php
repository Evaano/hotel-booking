<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomBooking;
use App\Services\AuditService;
use App\Services\NotificationService;
use App\Services\PaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RoomBookingController extends Controller
{
    protected $paymentService;

    protected $notificationService;

    protected $auditService;

    public function __construct(
        PaymentService $paymentService,
        NotificationService $notificationService,
        AuditService $auditService
    ) {
        $this->paymentService = $paymentService;
        $this->notificationService = $notificationService;
        $this->auditService = $auditService;
    }

    /**
     * Display a listing of bookings.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isVisitor()) {
            // Visitors see only their own bookings
            $bookings = RoomBooking::where('user_id', $user->id)
                ->where('booking_status', '!=', 'cancelled')
                ->with(['room.hotel'])
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($user->isHotelOperator()) {
            // Hotel operators see bookings for their hotels only
            $bookings = RoomBooking::whereHas('room.hotel', function ($query) use ($user) {
                $query->where('operator_id', $user->id);
            })->with(['room.hotel', 'user'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Admins and others see all bookings
            $bookings = RoomBooking::with(['room.hotel', 'user'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create(Request $request)
    {
        $hotel = null;
        $room = null;
        $availableRooms = collect();

        if ($request->has('hotel_id')) {
            $hotel = Hotel::findOrFail($request->hotel_id);
        }

        if ($request->has('room_id')) {
            $room = Room::findOrFail($request->room_id);
            $hotel = $room->hotel;
        }

        if ($hotel) {
            $availableRooms = $hotel->rooms()
                ->where('status', 'available')
                ->orderBy('room_number')
                ->get();
        }

        $hotels = Hotel::where('status', 'active')->get();

        return view('bookings.create', compact('hotels', 'hotel', 'room', 'availableRooms'));
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'num_guests' => 'required|integer|min:1',
        ]);

        $room = Room::findOrFail($validated['room_id']);

        // Check if room is available
        if ($room->status !== 'available') {
            return back()->withErrors(['room_id' => 'This room is not available.']);
        }

        // Check if room capacity is sufficient
        if ($validated['num_guests'] > $room->max_occupancy) {
            return back()->withErrors(['num_guests' => 'Number of guests exceeds room capacity.']);
        }

        // Check for conflicting bookings
        $conflictingBooking = RoomBooking::where('room_id', $room->id)
            ->where('booking_status', '!=', 'cancelled')
            ->where(function ($query) use ($validated) {
                $query->whereBetween('check_in_date', [$validated['check_in_date'], $validated['check_out_date']])
                    ->orWhereBetween('check_out_date', [$validated['check_in_date'], $validated['check_out_date']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('check_in_date', '<=', $validated['check_in_date'])
                            ->where('check_out_date', '>=', $validated['check_out_date']);
                    });
            })
            ->exists();

        if ($conflictingBooking) {
            return back()->withErrors(['check_in_date' => 'This room is already booked for the selected dates.']);
        }

        // Calculate total amount
        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $nights = $checkIn->diffInDays($checkOut);
        $totalAmount = $room->base_price * $nights;

        // Create booking
        $booking = RoomBooking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'room_type' => $room->room_type,
            'num_guests' => $validated['num_guests'],
            'total_amount' => $totalAmount,
            'booking_status' => 'pending',
            'confirmation_code' => strtoupper(Str::random(10)),
            'payment_status' => 'pending',
        ]);

        // Log the booking creation
        $this->auditService->logBookingCreation('hotel', $booking, [
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'num_guests' => $validated['num_guests'],
            'room_number' => $room->room_number,
            'hotel_name' => $room->hotel->name,
        ]);

        // Send confirmation email
        $this->notificationService->sendBookingConfirmation($booking);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking created successfully. Your confirmation code is: '.$booking->confirmation_code);
    }

    /**
     * Display the specified booking.
     */
    public function show(RoomBooking $booking)
    {
        // Check if user can view this booking
        $user = Auth::user();
        if ($user->isVisitor() && $booking->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        if ($user->isHotelOperator()) {
            $hotel = $booking->room->hotel;
            if ($hotel->operator_id !== $user->id) {
                abort(403, 'Unauthorized access.');
            }
        }

        $booking->load(['room.hotel', 'user']);

        return view('bookings.show', compact('booking'));
    }

    /**
     * Update booking status.
     */
    public function updateStatus(Request $request, RoomBooking $booking)
    {
        $user = Auth::user();

        // Check authorization
        if ($user->isHotelOperator()) {
            $hotel = $booking->room->hotel;
            if ($hotel->operator_id !== $user->id) {
                abort(403, 'Unauthorized access.');
            }
        } elseif (! $user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'booking_status' => 'required|in:pending,confirmed,cancelled,completed',
            'payment_status' => 'nullable|in:pending,paid,refunded',
        ]);

        $booking->update($validated);

        // Update room status if booking is confirmed
        if ($booking->booking_status === 'confirmed' && $booking->check_in_date <= now()->toDateString()) {
            $booking->room->update(['status' => 'occupied']);
        } elseif ($booking->booking_status === 'completed' || $booking->booking_status === 'cancelled') {
            $booking->room->update(['status' => 'available']);
        }

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking status updated successfully.');
    }

    /**
     * Cancel a booking.
     */
    public function cancel(RoomBooking $booking)
    {
        $user = Auth::user();

        // Check if user can cancel this booking
        if ($user->isVisitor() && $booking->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        if ($booking->booking_status === 'cancelled') {
            return back()->with('error', 'This booking is already cancelled.');
        }

        $booking->update([
            'booking_status' => 'cancelled',
            'payment_status' => 'refunded',
        ]);

        // Make room available again
        $booking->room->update(['status' => 'available']);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Process payment for a booking
     */
    public function processPayment(Request $request, RoomBooking $booking)
    {
        $user = Auth::user();

        // Check if user can process payment for this booking
        if ($user->isVisitor() && $booking->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        if ($booking->payment_status === 'paid') {
            return back()->with('error', 'This booking is already paid.');
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:credit_card,debit_card,bank_transfer',
        ]);

        // Process payment
        $paymentResult = $this->paymentService->processRoomBookingPayment($booking, $validated['payment_method']);

        if ($paymentResult['success']) {
            // Log payment success
            $this->auditService->logPaymentAction('processed', 'hotel', $booking, [
                'payment_method' => $validated['payment_method'],
                'transaction_id' => $paymentResult['transaction_id'] ?? null,
            ]);

            // Send confirmation email
            $this->notificationService->sendBookingConfirmation($booking);

            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Payment processed successfully! Your booking is now confirmed.');
        }

        // Log payment failure
        $this->auditService->logPaymentAction('failed', 'hotel', $booking, [
            'payment_method' => $validated['payment_method'],
            'error' => $paymentResult['message'],
        ]);

        // Send payment failure notification
        $this->notificationService->sendPaymentFailureNotification($booking, 'hotel', $paymentResult['message']);

        return back()->withErrors(['payment' => 'Payment failed: '.$paymentResult['message']]);
    }

    /**
     * Verify booking for ferry operators and theme park operators
     */
    public function verify(Request $request)
    {
        $validated = $request->validate([
            'confirmation_code' => 'required|string',
        ]);

        $booking = RoomBooking::where('confirmation_code', $validated['confirmation_code'])
            ->where('booking_status', 'confirmed')
            ->first();

        if (! $booking) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid or unconfirmed booking.',
            ], 404);
        }

        // Check if booking dates are valid
        $today = now()->toDateString();
        if ($booking->check_in_date > $today || $booking->check_out_date < $today) {
            return response()->json([
                'valid' => false,
                'message' => 'Booking is not valid for today.',
            ], 400);
        }

        return response()->json([
            'valid' => true,
            'booking' => [
                'confirmation_code' => $booking->confirmation_code,
                'guest_name' => $booking->user->name,
                'hotel' => $booking->room->hotel->name,
                'room' => $booking->room->room_number,
                'check_in' => $booking->check_in_date,
                'check_out' => $booking->check_out_date,
                'num_guests' => $booking->num_guests,
            ],
        ]);
    }
}
