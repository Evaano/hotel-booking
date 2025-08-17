<?php

namespace App\Http\Controllers;

use App\Models\BeachEvent;
use App\Models\BeachEventBooking;
use App\Models\RoomBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BeachEventController extends Controller
{
    /**
     * Display beach event management dashboard
     */
    public function manage()
    {
        $user = Auth::user();

        // Ensure user is a beach organizer or admin
        if (! $user->isBeachOrganizer() && ! $user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Get events based on user role
        if ($user->isAdmin()) {
            // Admin sees all events
            $events = BeachEvent::all();
            $eventIds = $events->pluck('id');

            // Get upcoming events
            $upcomingEvents = BeachEvent::where('event_date', '>=', now()->toDateString())
                ->where('status', 'active')
                ->orderBy('event_date', 'asc')
                ->get();

            // Get today's events
            $todayEvents = BeachEvent::where('event_date', now()->toDateString())
                ->get();
        } else {
            // Organizer sees only their events
            $events = BeachEvent::where('organizer_id', $user->id)->get();
            $eventIds = $events->pluck('id');

            // Get upcoming events
            $upcomingEvents = BeachEvent::where('organizer_id', $user->id)
                ->where('event_date', '>=', now()->toDateString())
                ->where('status', 'active')
                ->orderBy('event_date', 'asc')
                ->get();

            // Get today's events
            $todayEvents = BeachEvent::where('organizer_id', $user->id)
                ->where('event_date', now()->toDateString())
                ->get();
        }

        // Get recent bookings
        $recentBookings = BeachEventBooking::whereIn('beach_event_id', $eventIds)
            ->with(['beachEvent', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Calculate statistics
        $totalParticipants = BeachEventBooking::whereIn('beach_event_id', $eventIds)
            ->where('booking_status', '!=', 'cancelled')
            ->sum('num_participants');

        $monthlyRevenue = BeachEventBooking::whereIn('beach_event_id', $eventIds)
            ->where('booking_status', 'confirmed')
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount');

        return view('beach-events.manage', compact(
            'events',
            'upcomingEvents',
            'todayEvents',
            'recentBookings',
            'totalParticipants',
            'monthlyRevenue'
        ));
    }

    /**
     * Display list of beach events
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = BeachEvent::query();

        if ($user && $user->isBeachOrganizer()) {
            $query->where('organizer_id', $user->id);
        } else {
            $query->where('status', 'active')
                ->where('event_date', '>=', now()->toDateString());
        }

        // Search by name/description/location
        if ($request->filled('search')) {
            $term = $request->string('search');
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%")
                    ->orWhere('location', 'like', "%{$term}%");
            });
        }

        // Event type filter
        if ($request->filled('event_type')) {
            $query->where('event_type', $request->string('event_type'));
        }

        // Price filter
        if ($request->filled('price_range')) {
            [$min, $max] = match ($request->string('price_range')) {
                '0-50' => [0, 50],
                '50-100' => [50, 100],
                '100-200' => [100, 200],
                '200+' => [200, null],
                default => [null, null],
            };
            if ($min !== null) {
                $query->where('price', '>=', $min);
            }
            if ($max !== null) {
                $query->where('price', '<=', $max);
            }
        }

        // Date range quick filter
        if ($request->filled('date_range')) {
            $today = now()->toDateString();
            $map = [
                'today' => [today()->toDateString(), today()->toDateString()],
                'tomorrow' => [today()->addDay()->toDateString(), today()->addDay()->toDateString()],
                'this_week' => [today()->toDateString(), today()->endOfWeek()->toDateString()],
                'this_month' => [today()->toDateString(), today()->endOfMonth()->toDateString()],
            ];
            if (isset($map[$request->string('date_range')->toString()])) {
                [$start, $end] = $map[$request->string('date_range')->toString()];
                $query->whereBetween('event_date', [$start, $end]);
            }
        }

        $events = $query->orderBy('event_date', 'asc')->orderBy('start_time', 'asc')->get();

        return view('beach-events.index', compact('events'));
    }

    /**
     * Show the form for creating a new beach event
     */
    public function create()
    {
        return view('beach-events.create');
    }

    /**
     * Store a newly created beach event
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_type' => 'required|in:water_sports,beach_volleyball,surfing,snorkeling,beach_party,other',
            'event_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'age_restriction' => 'nullable|integer|min:0',
        ]);

        $validated['organizer_id'] = Auth::id();
        $validated['status'] = 'active';
        $validated['equipment_included'] = $request->has('equipment_included');

        $event = BeachEvent::create($validated);

        return redirect()->route('beach-events.show', $event)
            ->with('success', 'Beach event created successfully.');
    }

    /**
     * Display the specified beach event
     */
    public function show(BeachEvent $event)
    {
        // Calculate available spots
        $bookedSpots = $event->bookings()
            ->where('booking_status', '!=', 'cancelled')
            ->sum('num_participants');

        $availableSpots = $event->capacity - $bookedSpots;

        // Check if user has already booked this event
        $userBooking = null;
        if (Auth::check()) {
            $userBooking = $event->bookings()
                ->where('user_id', Auth::id())
                ->where('booking_status', '!=', 'cancelled')
                ->first();
        }

        return view('beach-events.show', compact('event', 'availableSpots', 'userBooking'));
    }

    /**
     * Show the form for editing the specified beach event
     */
    public function edit(BeachEvent $event)
    {
        // Allow organizer or admin
        $user = Auth::user();
        if (! ($user->isAdmin() || $event->organizer_id === $user->id)) {
            abort(403, 'Unauthorized access.');
        }

        return view('beach-events.edit', compact('event'));
    }

    /**
     * Update the specified beach event
     */
    public function update(Request $request, BeachEvent $event)
    {
        // Allow organizer or admin
        $user = Auth::user();
        if (! ($user->isAdmin() || $event->organizer_id === $user->id)) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_type' => 'required|in:water_sports,beach_volleyball,surfing,snorkeling,beach_party,other',
            'event_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'age_restriction' => 'nullable|integer|min:0',
            'status' => 'required|in:active,cancelled,completed',
        ]);

        $validated['equipment_included'] = $request->has('equipment_included');

        $event->update($validated);

        return redirect()->route('beach-events.manage')
            ->with('success', 'Beach event updated successfully.');
    }

    /**
     * Remove the specified beach event
     */
    public function destroy(BeachEvent $event)
    {
        // Allow organizer or admin
        $user = Auth::user();
        if (! ($user->isAdmin() || $event->organizer_id === $user->id)) {
            abort(403, 'Unauthorized access.');
        }

        // Check if there are any bookings
        if ($event->bookings()->exists()) {
            return back()->with('error', 'Cannot delete event with existing bookings.');
        }

        $event->delete();

        return redirect()->route('beach-events.index')
            ->with('success', 'Beach event deleted successfully.');
    }

    /**
     * Show booking form for a beach event
     */
    public function bookEvent(BeachEvent $event)
    {
        // Check if user has a confirmed hotel booking
        $hasValidHotelBooking = RoomBooking::where('user_id', Auth::id())
            ->where('booking_status', 'confirmed')
            ->exists();

        if (!$hasValidHotelBooking) {
            return redirect()->route('hotels.browse')
                ->with('error', 'You must have a confirmed hotel booking before booking beach events.');
        }

        // Check if event is bookable
        if ($event->status !== 'active') {
            return back()->with('error', 'This event is not available for booking.');
        }

        if ($event->event_date < now()->toDateString()) {
            return back()->with('error', 'This event has already passed.');
        }

        // Check if booking deadline has passed (2 hours before event start)
        $eventDate = Carbon::parse($event->event_date)->toDateString();
        $startTime = $event->start_time instanceof Carbon
            ? $event->start_time->format('H:i')
            : (string) $event->start_time;
        $eventDateTime = Carbon::parse($eventDate.' '.$startTime);
        $bookingDeadline = $eventDateTime->copy()->subHours(2);

        if (now() > $bookingDeadline) {
            return back()->with('error', 'Booking deadline has passed. You can no longer book this event.');
        }

        // Calculate available spots
        $bookedSpots = $event->bookings()
            ->where('booking_status', '!=', 'cancelled')
            ->sum('num_participants');

        $availableSpots = $event->capacity - $bookedSpots;

        if ($availableSpots <= 0) {
            return back()->with('error', 'This event is fully booked.');
        }

        return view('beach-events.book', compact('event', 'availableSpots'));
    }

    /**
     * Store beach event booking
     */
    public function storeBooking(Request $request, BeachEvent $event)
    {
        // Check if user has a confirmed hotel booking
        $hasValidHotelBooking = RoomBooking::where('user_id', Auth::id())
            ->where('booking_status', 'confirmed')
            ->exists();

        if (!$hasValidHotelBooking) {
            return redirect()->route('hotels.browse')
                ->with('error', 'You must have a confirmed hotel booking before booking beach events.');
        }

        // Check if event is bookable
        if ($event->status !== 'active') {
            return back()->with('error', 'This event is not available for booking.');
        }

        if ($event->event_date < now()->toDateString()) {
            return back()->with('error', 'This event has already passed.');
        }

        // Check if booking deadline has passed (2 hours before event start)
        $eventDate = Carbon::parse($event->event_date)->toDateString();
        $startTime = $event->start_time instanceof Carbon
            ? $event->start_time->format('H:i')
            : (string) $event->start_time;
        $eventDateTime = Carbon::parse($eventDate.' '.$startTime);
        $bookingDeadline = $eventDateTime->copy()->subHours(2);

        if (now() > $bookingDeadline) {
            return back()->with('error', 'Booking deadline has passed. You can no longer book this event.');
        }

        $validated = $request->validate([
            'num_participants' => 'required|integer|min:1|max:10',
            'special_requirements' => 'nullable|string|max:500',
        ]);

        // Check if user has already booked this specific event (same event, same date)
        $existingBooking = BeachEventBooking::where('user_id', Auth::id())
            ->where('beach_event_id', $event->id)
            ->whereIn('booking_status', ['pending', 'confirmed'])
            ->first();

        if ($existingBooking) {
            return back()->with('error', 'You already have a '.strtolower($existingBooking->booking_status).' booking for this event on '.Carbon::parse($event->event_date)->format('M d, Y').'.');
        }

        // Check available capacity
        $bookedSpots = $event->bookings()
            ->where('booking_status', '!=', 'cancelled')
            ->sum('num_participants');

        $availableSpots = $event->capacity - $bookedSpots;

        if ($validated['num_participants'] > $availableSpots) {
            return back()->withErrors(['num_participants' => 'Not enough spots available.']);
        }

        // Calculate total amount
        $totalAmount = $event->price * $validated['num_participants'];

        // Create booking
        $booking = BeachEventBooking::create([
            'user_id' => Auth::id(),
            'beach_event_id' => $event->id,
            'num_participants' => $validated['num_participants'],
            'total_amount' => $totalAmount,
            'booking_status' => 'pending',
            'special_requirements' => $validated['special_requirements'] ?? null,
        ]);

        return redirect()->route('beach-events.bookings')
            ->with('success', 'Beach event booked successfully!');
    }

    /**
     * Display user's beach event bookings
     */
    public function bookings()
    {
        $user = Auth::user();

        if ($user->isVisitor()) {
            $bookings = BeachEventBooking::where('user_id', $user->id)
                ->with('beachEvent')
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($user->isBeachOrganizer()) {
            $bookings = BeachEventBooking::whereHas('beachEvent', function ($query) use ($user) {
                $query->where('organizer_id', $user->id);
            })->with(['beachEvent', 'user'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $bookings = BeachEventBooking::with(['beachEvent', 'user'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('beach-events.bookings', compact('bookings'));
    }

    /**
     * Show specific booking details
     */
    public function showBooking(BeachEventBooking $booking)
    {
        $user = Auth::user();

        // Check if user can view this booking
        if ($user->isVisitor() && $booking->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        if ($user->isBeachOrganizer() && $booking->beachEvent->organizer_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        return view('beach-events.show-booking', compact('booking'));
    }

    /**
     * Cancel beach event booking
     */
    public function cancelBooking(BeachEventBooking $booking)
    {
        $user = Auth::user();

        // Check if user can cancel this booking
        if ($user->isVisitor() && $booking->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        if ($booking->booking_status === 'cancelled') {
            return back()->with('error', 'This booking is already cancelled.');
        }

        // Check if event hasn't started yet
        $event = $booking->beachEvent;
        $eventDateTime = Carbon::parse($event->event_date.' '.$event->start_time);

        if ($eventDateTime->isPast()) {
            return back()->with('error', 'Cannot cancel booking for an event that has already started.');
        }

        $booking->update(['booking_status' => 'cancelled']);

        return redirect()->route('beach-events.bookings')
            ->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Update booking status (for organizers)
     */
    public function updateBookingStatus(Request $request, BeachEventBooking $booking)
    {
        $user = Auth::user();

        // Allow organizer owner or admin
        if (! ($user->isAdmin() || ($user->isBeachOrganizer() && $booking->beachEvent->organizer_id === $user->id))) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'booking_status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $booking->update($validated);

        return redirect()->route('beach-events.manage-bookings')
            ->with('success', 'Booking status updated successfully.');
    }

    /**
     * Display all bookings for beach organizer management
     */
    public function manageBookings()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Admin can see all participants
            $bookings = BeachEventBooking::with(['user', 'beachEvent'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Beach organizer can only see their events' participants
            $eventIds = BeachEvent::where('organizer_id', $user->id)->pluck('id');
            $bookings = BeachEventBooking::whereIn('beach_event_id', $eventIds)
                ->with(['user', 'beachEvent'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('beach-events.manage-bookings', compact('bookings'));
    }

    /**
     * Display event participants (for organizers)
     */
    public function participants(BeachEvent $event)
    {
        // Allow organizer or admin
        $user = Auth::user();
        if (! ($user->isAdmin() || $event->organizer_id === $user->id)) {
            abort(403, 'Unauthorized access.');
        }

        $bookings = $event->bookings()
            ->where('booking_status', '!=', 'cancelled')
            ->with('user')
            ->get();

        return view('beach-events.participants', compact('event', 'bookings'));
    }
}
