<?php

namespace App\Http\Controllers;

use App\Models\ActivityBooking;
use App\Models\ParkActivity;
use App\Models\RoomBooking;
use App\Models\ThemeParkTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThemeParkController extends Controller
{
    /**
     * Display theme park management dashboard
     */
    public function manage()
    {
        $user = Auth::user();

        // Ensure user is a park operator or admin
        if (! $user->isParkOperator() && ! $user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Get park statistics
        $totalActivities = ParkActivity::count();
        $activeActivities = ParkActivity::where('status', 'active')->count();

        // Get today's visitors
        $todayVisitors = ThemeParkTicket::where('visit_date', now()->toDateString())
            ->where('ticket_status', '!=', 'cancelled')
            ->sum('num_tickets');

        // Get upcoming tickets
        $upcomingTickets = ThemeParkTicket::where('visit_date', '>', now()->toDateString())
            ->where('ticket_status', '!=', 'cancelled')
            ->count();

        // Get popular activities
        $popularActivities = ParkActivity::withCount(['activityBookings' => function ($query) {
            $query->where('status', '!=', 'cancelled');
        }])->orderBy('activity_bookings_count', 'desc')
            ->take(5)
            ->get();

        // Get recent bookings
        $recentBookings = ThemeParkTicket::with(['user', 'roomBooking.room.hotel'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Calculate monthly revenue
        $monthlyRevenue = ThemeParkTicket::where('ticket_status', 'confirmed')
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount');

        $monthlyActivityRevenue = ActivityBooking::where('status', 'confirmed')
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount');

        $totalMonthlyRevenue = $monthlyRevenue + $monthlyActivityRevenue;

        return view('dashboards.park-operator', compact(
            'totalActivities',
            'activeActivities',
            'todayVisitors',
            'upcomingTickets',
            'popularActivities',
            'recentBookings',
            'totalMonthlyRevenue'
        ));
    }

    /**
     * Display theme park information and activities
     */
    public function index(Request $request)
    {
        $query = ParkActivity::query()->where('status', 'active');

        // Text search
        if ($request->filled('search')) {
            $term = $request->string('search');
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->string('category'));
        }

        // Price range filter
        if ($request->filled('price_range')) {
            [$min, $max] = match ($request->string('price_range')) {
                '0-25' => [0, 25],
                '25-50' => [25, 50],
                '50-100' => [50, 100],
                '100+' => [100, null],
                default => [null, null],
            };
            if ($min !== null) {
                $query->where('price', '>=', $min);
            }
            if ($max !== null) {
                $query->where('price', '<=', $max);
            }
        }

        $activities = $query->get();
        $groupedActivities = $activities->groupBy('category');

        return view('theme-park.index', compact('groupedActivities'));
    }

    /**
     * Display a single park activity (public)
     */
    public function showActivity(ParkActivity $activity)
    {
        return view('theme-park.show-activity', compact('activity'));
    }

    /**
     * Display park activities for management (Park Operators)
     */
    public function activities()
    {
        $activities = ParkActivity::all();

        return view('theme-park.activities', compact('activities'));
    }

    /**
     * Create new park activity
     */
    public function createActivity()
    {
        return view('theme-park.create-activity');
    }

    /**
     * Store new park activity
     */
    public function storeActivity(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:ride,show,experience,dining,shopping',
            'price' => 'required|numeric|min:0',
            'capacity' => 'nullable|integer|min:1',
            'age_restriction' => 'nullable|integer|min:0',
            'height_restriction' => 'nullable|integer|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'location_coordinates' => 'nullable|array',
            'location_coordinates.lat' => 'nullable|numeric|between:-90,90',
            'location_coordinates.lng' => 'nullable|numeric|between:-180,180',
        ]);

        if (isset($validated['location_coordinates'])) {
            $validated['location_coordinates'] = json_encode($validated['location_coordinates']);
        }

        $validated['status'] = 'active';

        $activity = ParkActivity::create($validated);

        return redirect()->route('theme-park.activities')
            ->with('success', 'Park activity created successfully.');
    }

    /**
     * Edit park activity
     */
    public function editActivity(ParkActivity $activity)
    {
        return view('theme-park.edit-activity', compact('activity'));
    }

    /**
     * Update park activity
     */
    public function updateActivity(Request $request, ParkActivity $activity)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:ride,show,experience,dining,shopping',
            'price' => 'required|numeric|min:0',
            'capacity' => 'nullable|integer|min:1',
            'age_restriction' => 'nullable|integer|min:0',
            'height_restriction' => 'nullable|integer|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'location_coordinates' => 'nullable|array',
            'location_coordinates.lat' => 'nullable|numeric|between:-90,90',
            'location_coordinates.lng' => 'nullable|numeric|between:-180,180',
            'status' => 'required|in:active,inactive,maintenance',
        ]);

        if (isset($validated['location_coordinates'])) {
            $validated['location_coordinates'] = json_encode($validated['location_coordinates']);
        }

        $activity->update($validated);

        return redirect()->route('theme-park.activities')
            ->with('success', 'Park activity updated successfully.');
    }

    /**
     * Delete park activity
     */
    public function deleteActivity(ParkActivity $activity)
    {
        // Prevent delete if activity has bookings
        if ($activity->bookings()->exists()) {
            return back()->with('error', 'Cannot delete activity with existing bookings.');
        }

        $activity->delete();

        return redirect()->route('theme-park.activities')
            ->with('success', 'Park activity deleted successfully.');
    }

    /**
     * Show theme park ticket booking form
     */
    public function bookTicket()
    {
        // Check if user has a valid hotel booking
        $validBookings = RoomBooking::where('user_id', Auth::id())
            ->where('booking_status', 'confirmed')
            ->where('check_out_date', '>=', now()->toDateString())
            ->get();

        if ($validBookings->isEmpty()) {
            return redirect()->route('hotels.browse')
                ->with('error', 'You must have a confirmed hotel booking before booking theme park tickets.');
        }

        return view('theme-park.book-ticket', compact('validBookings'));
    }

    /**
     * Store theme park ticket booking
     */
    public function storeTicket(Request $request)
    {
        $validated = $request->validate([
            'room_booking_id' => 'required|exists:room_bookings,id',
            'visit_date' => 'required|date|after_or_equal:today',
            'num_tickets' => 'required|integer|min:1|max:10',
        ]);

        // Verify room booking belongs to user and is valid
        $roomBooking = RoomBooking::where('id', $validated['room_booking_id'])
            ->where('user_id', Auth::id())
            ->where('booking_status', 'confirmed')
            ->first();

        if (! $roomBooking) {
            return back()->withErrors(['room_booking_id' => 'Invalid hotel booking.']);
        }

        // Check if visit date is within hotel booking dates
        $visitDate = \Carbon\Carbon::parse($validated['visit_date']);
        $checkInDate = \Carbon\Carbon::parse($roomBooking->check_in_date);
        $checkOutDate = \Carbon\Carbon::parse($roomBooking->check_out_date);
        
        if ($visitDate->lt($checkInDate) || $visitDate->gt($checkOutDate)) {
            return back()->withErrors(['visit_date' => 'Visit date must be within your hotel stay period.']);
        }

        // Fixed theme park entrance fee
        $entranceFee = 50; // Base price per person
        $totalAmount = $entranceFee * $validated['num_tickets'];

        // Create theme park ticket
        $ticket = ThemeParkTicket::create([
            'user_id' => Auth::id(),
            'room_booking_id' => $validated['room_booking_id'],
            'visit_date' => $validated['visit_date'],
            'num_tickets' => $validated['num_tickets'],
            'total_amount' => $totalAmount,
            'ticket_status' => 'pending',
        ]);

        return redirect()->route('theme-park.tickets')
            ->with('success', 'Theme park ticket booked successfully.');
    }

    /**
     * Display user's theme park tickets
     */
    public function tickets()
    {
        $user = Auth::user();

        if ($user->isVisitor()) {
            $tickets = ThemeParkTicket::where('user_id', $user->id)
                ->with(['roomBooking.room.hotel', 'activityBookings.parkActivity'])
                ->orderBy('visit_date', 'desc')
                ->get();
        } elseif ($user->isParkOperator()) {
            $tickets = ThemeParkTicket::with(['roomBooking.room.hotel', 'user', 'activityBookings.parkActivity'])
                ->orderBy('visit_date', 'desc')
                ->get();
        } else {
            $tickets = ThemeParkTicket::with(['roomBooking.room.hotel', 'user', 'activityBookings.parkActivity'])
                ->orderBy('visit_date', 'desc')
                ->get();
        }

        return view('theme-park.tickets', compact('tickets'));
    }

    /**
     * Show a single theme park ticket
     */
    public function showTicket(ThemeParkTicket $ticket)
    {
        $user = Auth::user();
        if ($user->isVisitor() && $ticket->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }
        $ticket->load(['roomBooking.room.hotel', 'activityBookings.parkActivity', 'user']);
        return view('theme-park.show-ticket', compact('ticket'));
    }

    /**
     * Show activity booking form
     */
    public function bookActivity(ThemeParkTicket $ticket)
    {
        // Check if ticket belongs to user
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Check if ticket is valid for today or future
        if ($ticket->visit_date < now()->toDateString()) {
            return back()->with('error', 'This ticket has expired.');
        }

        $activities = ParkActivity::where('status', 'active')->get();
        $bookedActivities = $ticket->activityBookings->pluck('park_activity_id')->toArray();

        return view('theme-park.book-activity', compact('ticket', 'activities', 'bookedActivities'));
    }

    /**
     * Store activity booking
     */
    public function storeActivityBooking(Request $request, ThemeParkTicket $ticket)
    {
        // Check if ticket belongs to user
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'park_activity_id' => 'required|exists:park_activities,id',
            'booking_time' => 'nullable|date_format:H:i',
            'num_participants' => 'required|integer|min:1',
        ]);

        // Check if num_participants doesn't exceed ticket count
        if ($validated['num_participants'] > $ticket->num_tickets) {
            return back()->withErrors(['num_participants' => 'Number of participants exceeds ticket count.']);
        }

        $activity = ParkActivity::findOrFail($validated['park_activity_id']);

        // Check if already booked
        $existingBooking = ActivityBooking::where('theme_park_ticket_id', $ticket->id)
            ->where('park_activity_id', $activity->id)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($existingBooking) {
            return back()->withErrors(['park_activity_id' => 'You have already booked this activity.']);
        }

        // Check capacity if applicable
        if ($activity->capacity) {
            $bookedCount = ActivityBooking::where('park_activity_id', $activity->id)
                ->whereHas('themeParkTicket', function ($query) use ($ticket) {
                    $query->where('visit_date', $ticket->visit_date);
                })
                ->where('status', '!=', 'cancelled')
                ->sum('num_participants');

            if (($bookedCount + $validated['num_participants']) > $activity->capacity) {
                return back()->withErrors(['num_participants' => 'Not enough capacity available.']);
            }
        }

        // Calculate total amount
        $totalAmount = $activity->price * $validated['num_participants'];

        // Create booking time if provided
        $bookingTime = null;
        if (isset($validated['booking_time'])) {
            $bookingTime = Carbon::parse($ticket->visit_date.' '.$validated['booking_time']);
        }

        // Create activity booking
        $booking = ActivityBooking::create([
            'theme_park_ticket_id' => $ticket->id,
            'park_activity_id' => $activity->id,
            'booking_time' => $bookingTime,
            'num_participants' => $validated['num_participants'],
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        return redirect()->route('theme-park.ticket.activities', $ticket)
            ->with('success', 'Activity booked successfully.');
    }

    /**
     * Display ticket activities
     */
    public function ticketActivities(ThemeParkTicket $ticket)
    {
        // Check if user can view this ticket
        $user = Auth::user();
        if ($user->isVisitor() && $ticket->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        $ticket->load(['activityBookings.parkActivity']);

        return view('theme-park.ticket-activities', compact('ticket'));
    }

    /**
     * Cancel activity booking
     */
    public function cancelActivityBooking(ActivityBooking $booking)
    {
        // Check if user owns the ticket
        if ($booking->themeParkTicket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'This booking is already cancelled.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Activity booking cancelled successfully.');
    }

    /**
     * Cancel theme park ticket
     */
    public function cancelTicket(ThemeParkTicket $ticket)
    {
        $user = Auth::user();

        // Only the owner (visitor) or privileged roles (non-visitor) can pass
        if ($user->isVisitor() && $ticket->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        if ($ticket->ticket_status === 'cancelled') {
            return back()->with('error', 'This ticket is already cancelled.');
        }

        $ticket->update(['ticket_status' => 'cancelled']);

        return redirect()->route('theme-park.tickets')
            ->with('success', 'Theme park ticket cancelled successfully.');
    }

    /**
     * Verify hotel booking for theme park entry (Park Operators)
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

        // Check for theme park tickets
        $themeParkTicket = ThemeParkTicket::where('room_booking_id', $booking->id)
            ->where('visit_date', $today)
            ->where('ticket_status', '!=', 'cancelled')
            ->first();

        return response()->json([
            'valid' => true,
            'booking' => [
                'confirmation_code' => $booking->confirmation_code,
                'guest_name' => $booking->user->name,
                'hotel' => $booking->room->hotel->name,
                'check_in' => $booking->check_in_date,
                'check_out' => $booking->check_out_date,
                'has_park_ticket' => $themeParkTicket !== null,
                'park_ticket' => $themeParkTicket ? [
                    'num_tickets' => $themeParkTicket->num_tickets,
                    'status' => $themeParkTicket->ticket_status,
                ] : null,
            ],
        ]);
    }
}
