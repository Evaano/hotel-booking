<?php

namespace App\Http\Controllers;

use App\Models\FerrySchedule;
use App\Models\FerryTicket;
use App\Models\RoomBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FerryController extends Controller
{
    /**
     * Display ferry management dashboard
     */
    public function index()
    {
        $user = Auth::user();

        // Ensure user is a ferry operator or admin
        if (! $user->isFerryOperator() && ! $user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Get schedules scoped by role
        if ($user->isAdmin()) {
            // Admin sees all schedules
            $schedules = FerrySchedule::all();
        } else {
            // Operator sees own schedules
            $schedules = FerrySchedule::where('operator_id', $user->id)->get();
        }
        $scheduleIds = $schedules->pluck('id');

        // Get today's tickets
        $todayTickets = FerryTicket::whereIn('ferry_schedule_id', $scheduleIds)
            ->whereDate('travel_date', now()->toDateString())
            ->where('booking_status', '!=', 'cancelled')
            ->with(['user', 'ferrySchedule'])
            ->get();

        // Get upcoming tickets
        $upcomingTickets = FerryTicket::whereIn('ferry_schedule_id', $scheduleIds)
            ->whereDate('travel_date', '>', now()->toDateString())
            ->where('booking_status', '!=', 'cancelled')
            ->count();

        // Calculate capacity utilization for today
        $todayCapacityUsed = 0;
        $todayTotalCapacity = 0;

        foreach ($schedules as $schedule) {
            $dayOfWeek = strtolower(now()->format('l'));
            $daysOfOperation = is_array($schedule->days_of_week)
                ? $schedule->days_of_week
                : (json_decode((string) $schedule->days_of_week, true) ?: []);

            if (in_array($dayOfWeek, $daysOfOperation)) {
                $todayTotalCapacity += $schedule->capacity;
                $todayCapacityUsed += FerryTicket::where('ferry_schedule_id', $schedule->id)
                    ->whereDate('travel_date', now()->toDateString())
                    ->where('booking_status', '!=', 'cancelled')
                    ->sum('num_passengers');
            }
        }

        $capacityUtilization = $todayTotalCapacity > 0
            ? round(($todayCapacityUsed / $todayTotalCapacity) * 100, 2)
            : 0;

        // Calculate monthly revenue
        $monthlyRevenue = FerryTicket::whereIn('ferry_schedule_id', $scheduleIds)
            ->where('booking_status', 'confirmed')
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount');

        return view('dashboards.ferry-operator', compact(
            'schedules',
            'todayTickets',
            'upcomingTickets',
            'capacityUtilization',
            'monthlyRevenue'
        ));
    }

    /**
     * Display ferry schedules
     */
    public function schedules(Request $request)
    {
        $user = Auth::user();

        $query = FerrySchedule::query();

        // Restrict to operator's schedules if operator
        if ($user && $user->isFerryOperator()) {
            $query->where('operator_id', $user->id);
        } else {
            // Public should only see active by default unless explicitly filtered
            if (! $request->filled('status')) {
                $query->where('status', 'active');
            }
        }

        // Route filter
        if ($request->filled('route')) {
            $query->where('route', $request->string('route'));
        }

        // Day-of-week filter (JSON array)
        if ($request->filled('day')) {
            $query->whereJsonContains('days_of_week', strtolower($request->string('day')));
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $schedules = $query->orderBy('departure_time')->get();

        return view('ferry.schedules', compact('schedules'));
    }

    /**
     * Create new ferry schedule (Ferry Operators only)
     */
    public function createSchedule()
    {
        return view('ferry.create-schedule');
    }

    /**
     * Store new ferry schedule
     */
    public function storeSchedule(Request $request)
    {
        $validated = $request->validate([
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i|after:departure_time',
            'route' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'days_of_week' => 'required|array|min:1',
            'days_of_week.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
        ]);

        $validated['operator_id'] = Auth::id();
        $validated['status'] = 'active';
        $validated['days_of_week'] = json_encode($validated['days_of_week']);

        $schedule = FerrySchedule::create($validated);

        return redirect()->route('ferry.schedules')
            ->with('success', 'Ferry schedule created successfully.');
    }

    /**
     * Edit ferry schedule
     */
    public function editSchedule(FerrySchedule $schedule)
    {
        // Check if user is the operator
        if (Auth::check() && Auth::user()->isFerryOperator() && $schedule->operator_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('ferry.edit-schedule', compact('schedule'));
    }

    /**
     * Update ferry schedule
     */
    public function updateSchedule(Request $request, FerrySchedule $schedule)
    {
        // Check if user is the operator
        if (Auth::check() && Auth::user()->isFerryOperator() && $schedule->operator_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i|after:departure_time',
            'route' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'days_of_week' => 'required|array|min:1',
            'days_of_week.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['days_of_week'] = json_encode($validated['days_of_week']);
        $schedule->update($validated);

        return redirect()->route('ferry.schedules')
            ->with('success', 'Ferry schedule updated successfully.');
    }

    /**
     * Delete ferry schedule
     */
    public function deleteSchedule(FerrySchedule $schedule)
    {
        // Check if user is the operator
        if (Auth::user()->isFerryOperator() && $schedule->operator_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Prevent delete if tickets exist
        if ($schedule->tickets()->exists()) {
            return back()->with('error', 'Cannot delete schedule with existing tickets.');
        }

        $schedule->delete();

        return redirect()->route('ferry.schedules')
            ->with('success', 'Ferry schedule deleted successfully.');
    }

    /**
     * Show ferry ticket booking form
     */
    public function bookTicket(Request $request)
    {
        // Check if user has a valid hotel booking
        $validBookings = RoomBooking::where('user_id', Auth::id())
            ->where('booking_status', 'confirmed')
            ->where('check_out_date', '>=', now()->toDateString())
            ->get();

        if ($validBookings->isEmpty()) {
            return redirect()->route('hotels.browse')
                ->with('error', 'You must have a confirmed hotel booking before booking ferry tickets.');
        }

        $schedules = FerrySchedule::where('status', 'active')->get();

        return view('ferry.book-ticket', compact('validBookings', 'schedules'));
    }

    /**
     * Store ferry ticket booking
     */
    public function storeTicket(Request $request)
    {
        $validated = $request->validate([
            'room_booking_id' => 'required|exists:room_bookings,id',
            'ferry_schedule_id' => 'required|exists:ferry_schedule,id',
            'travel_date' => 'required|date|after_or_equal:today',
            'num_passengers' => 'required|integer|min:1|max:10',
        ]);

        // Verify room booking belongs to user and is valid
        $roomBooking = RoomBooking::where('id', $validated['room_booking_id'])
            ->where('user_id', Auth::id())
            ->where('booking_status', 'confirmed')
            ->first();

        if (! $roomBooking) {
            return redirect()->route('ferry.book-ticket')->withErrors(['room_booking_id' => 'Invalid hotel booking.']);
        }

        // Check if travel date is within hotel booking dates
        $travelDate = Carbon::parse($validated['travel_date'])->toDateString();
        $checkInDate = Carbon::parse($roomBooking->check_in_date)->toDateString();
        $checkOutDate = Carbon::parse($roomBooking->check_out_date)->toDateString();
        
        if ($travelDate < $checkInDate || $travelDate > $checkOutDate) {
            return redirect()->route('ferry.book-ticket')->withErrors(['travel_date' => 'Travel date must be within your hotel stay period.']);
        }

        // Check ferry schedule availability
        $schedule = FerrySchedule::findOrFail($validated['ferry_schedule_id']);

        // Check if ferry operates on the selected day
        $dayOfWeek = strtolower(Carbon::parse($validated['travel_date'])->format('l'));
        $daysOfOperation = is_array($schedule->days_of_week)
            ? $schedule->days_of_week
            : (json_decode((string) $schedule->days_of_week, true) ?: []);

        if (! in_array($dayOfWeek, $daysOfOperation)) {
            return redirect()->route('ferry.book-ticket')->withErrors(['travel_date' => 'Ferry does not operate on this day.']);
        }

        // Check capacity
        $bookedSeats = FerryTicket::where('ferry_schedule_id', $schedule->id)
            ->where('travel_date', $validated['travel_date'])
            ->where('booking_status', '!=', 'cancelled')
            ->sum('num_passengers');

        if (($bookedSeats + $validated['num_passengers']) > $schedule->capacity) {
            return redirect()->route('ferry.book-ticket')->withErrors(['num_passengers' => 'Not enough seats available.']);
        }

        // Calculate total amount
        $totalAmount = $schedule->price * $validated['num_passengers'];

        // Create ferry ticket
        $ticket = FerryTicket::create([
            'user_id' => Auth::id(),
            'room_booking_id' => $validated['room_booking_id'],
            'ferry_schedule_id' => $validated['ferry_schedule_id'],
            'travel_date' => $validated['travel_date'],
            'num_passengers' => $validated['num_passengers'],
            'total_amount' => $totalAmount,
            'booking_status' => 'pending',
        ]);


        return redirect()->route('ferry.tickets')
            ->with('success', 'Ferry ticket booked successfully.');
    }

    /**
     * Display user's ferry tickets
     */
    public function tickets()
    {
        $user = Auth::user();

        if ($user && $user->isVisitor()) {
            $tickets = FerryTicket::where('user_id', $user->id)
                ->with(['ferrySchedule', 'roomBooking.room.hotel'])
                ->orderBy('travel_date', 'desc')
                ->get();
        } elseif ($user && $user->isFerryOperator()) {
            $tickets = FerryTicket::whereHas('ferrySchedule', function ($query) use ($user) {
                $query->where('operator_id', $user->id);
            })->with(['ferrySchedule', 'roomBooking.room.hotel', 'user'])
                ->orderBy('travel_date', 'desc')
                ->get();
        } else {
            $tickets = FerryTicket::with(['ferrySchedule', 'roomBooking.room.hotel', 'user'])
                ->orderBy('travel_date', 'desc')
                ->get();
        }

        return view('ferry.tickets', compact('tickets'));
    }

    /**
     * Show a single ferry ticket (visitor or operator/admin).
     */
    public function showTicket(FerryTicket $ticket)
    {
        $user = Auth::user();
        
        // Admin can view any ticket
        if (! $user->isAdmin()) {
            if ($user->isVisitor() && $ticket->user_id !== $user->id) {
                abort(403, 'Unauthorized access.');
            }
            if ($user->isFerryOperator() && $ticket->ferrySchedule->operator_id !== $user->id) {
                abort(403, 'Unauthorized access.');
            }
        }

        $ticket->load(['ferrySchedule', 'roomBooking.room.hotel', 'user']);

        return view('ferry.show-ticket', compact('ticket'));
    }

    /**
     * Verify hotel booking for ferry ticket (Ferry Operators)
     */
    public function verifyBooking(Request $request)
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
                'message' => 'Invalid or unconfirmed hotel booking.',
            ], 404);
        }

        // Check if booking is valid for today
        $today = now()->toDateString();
        if ($booking->check_in_date > $today || $booking->check_out_date < $today) {
            return response()->json([
                'valid' => false,
                'message' => 'Hotel booking is not valid for today.',
            ], 400);
        }

        return response()->json([
            'valid' => true,
            'booking' => [
                'confirmation_code' => $booking->confirmation_code,
                'guest_name' => $booking->user->name,
                'hotel' => $booking->room->hotel->name,
                'check_in' => $booking->check_in_date,
                'check_out' => $booking->check_out_date,
                'can_book_ferry' => true,
            ],
        ]);
    }

    /**
     * Cancel ferry ticket
     */
    public function cancelTicket(FerryTicket $ticket)
    {
        $user = Auth::user();

        // Check if user can cancel this ticket
        if ($user->isVisitor() && $ticket->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        if ($ticket->booking_status === 'cancelled') {
            return back()->with('error', 'This ticket is already cancelled.');
        }

        $ticket->update(['booking_status' => 'cancelled']);

        return redirect()->route('ferry.tickets')
            ->with('success', 'Ferry ticket cancelled successfully.');
    }
}
