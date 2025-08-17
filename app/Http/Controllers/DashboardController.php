<?php

namespace App\Http\Controllers;

use App\Models\ActivityBooking;
use App\Models\BeachEvent;
use App\Models\BeachEventBooking;
use App\Models\FerrySchedule;
use App\Models\FerryTicket;
use App\Models\Hotel;
use App\Models\ParkActivity;
use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\ThemeParkTicket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the appropriate dashboard based on user role
     */
    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'visitor':
                return $this->visitorDashboard();
            case 'hotel_operator':
                return $this->hotelOperatorDashboard();
            case 'ferry_operator':
                return $this->ferryOperatorDashboard();
            case 'park_operator':
                return $this->parkOperatorDashboard();
            case 'beach_organizer':
                return $this->beachOrganizerDashboard();
            case 'admin':
                return $this->adminDashboard();
            default:
                return redirect()->route('home');
        }
    }

    /**
     * Visitor Dashboard
     */
    private function visitorDashboard()
    {
        $user = Auth::user();

        // Get recent bookings
        $recentHotelBookings = RoomBooking::where('user_id', $user->id)
            ->where('booking_status', '!=', 'cancelled')
            ->with('room.hotel')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $upcomingFerryTickets = FerryTicket::where('user_id', $user->id)
            ->whereDate('travel_date', '>=', now()->toDateString())
            ->where('booking_status', '!=', 'cancelled')
            ->with('ferrySchedule')
            ->orderBy('travel_date', 'asc')
            ->take(5)
            ->get();

        $upcomingParkTickets = ThemeParkTicket::where('user_id', $user->id)
            ->whereDate('visit_date', '>=', now()->toDateString())
            ->where('ticket_status', '!=', 'cancelled')
            ->orderBy('visit_date', 'asc')
            ->take(5)
            ->get();

        $upcomingBeachEvents = BeachEventBooking::where('user_id', $user->id)
            ->where('booking_status', '!=', 'cancelled')
            ->whereHas('beachEvent', function ($query) {
                $query->whereDate('event_date', '>=', now()->toDateString());
            })
            ->with('beachEvent')
            ->take(5)
            ->get();

        // Calculate total spent
        $totalSpent = 0;
        $totalSpent += RoomBooking::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->sum('total_amount');
        $totalSpent += FerryTicket::where('user_id', $user->id)
            ->where('booking_status', 'confirmed')
            ->sum('total_amount');
        $totalSpent += ThemeParkTicket::where('user_id', $user->id)
            ->where('ticket_status', 'confirmed')
            ->sum('total_amount');
        $totalSpent += BeachEventBooking::where('user_id', $user->id)
            ->where('booking_status', 'confirmed')
            ->sum('total_amount');

        // Booking stats
        $totalBookings = RoomBooking::where('user_id', $user->id)->where('booking_status', '!=', 'cancelled')->count()
            + FerryTicket::where('user_id', $user->id)->where('booking_status', '!=', 'cancelled')->count()
            + ThemeParkTicket::where('user_id', $user->id)->where('ticket_status', '!=', 'cancelled')->count()
            + BeachEventBooking::where('user_id', $user->id)->where('booking_status', '!=', 'cancelled')->count();

        $confirmedBookings = RoomBooking::where('user_id', $user->id)
            ->where('booking_status', 'confirmed')->count()
            + FerryTicket::where('user_id', $user->id)
                ->where('booking_status', 'confirmed')->count()
            + ThemeParkTicket::where('user_id', $user->id)
                ->where('ticket_status', 'confirmed')->count()
            + BeachEventBooking::where('user_id', $user->id)
                ->where('booking_status', 'confirmed')->count();

        $pendingBookings = RoomBooking::where('user_id', $user->id)
            ->where('booking_status', 'pending')->count()
            + FerryTicket::where('user_id', $user->id)
                ->where('booking_status', 'pending')->count()
            + ThemeParkTicket::where('user_id', $user->id)
                ->where('ticket_status', 'pending')->count()
            + BeachEventBooking::where('user_id', $user->id)
                ->where('booking_status', 'pending')->count();

        $completedStays = RoomBooking::where('user_id', $user->id)
            ->where('booking_status', 'completed')
            ->count();

        return view('dashboards.visitor', compact(
            'recentHotelBookings',
            'upcomingFerryTickets',
            'upcomingParkTickets',
            'upcomingBeachEvents',
            'totalSpent',
            'totalBookings',
            'confirmedBookings',
            'pendingBookings',
            'completedStays'
        ));
    }

    /**
     * Unified view for a visitor's bookings and tickets across services.
     */
    public function myBookings()
    {
        $user = Auth::user();

        // Hotel room bookings
        $roomBookings = RoomBooking::where('user_id', $user->id)
            ->with(['room.hotel'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Ferry tickets
        $ferryTickets = FerryTicket::where('user_id', $user->id)
            ->with(['ferrySchedule'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Theme park tickets
        $parkTickets = ThemeParkTicket::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Activity bookings (resolve through the user's theme park tickets)
        $activityBookings = ActivityBooking::whereHas('themeParkTicket', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
            ->with(['parkActivity', 'themeParkTicket'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Beach event bookings
        $beachEventBookings = BeachEventBooking::where('user_id', $user->id)
            ->with(['beachEvent'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('account.my-bookings', compact(
            'roomBookings',
            'ferryTickets',
            'parkTickets',
            'activityBookings',
            'beachEventBookings'
        ));
    }

    /**
     * Display only hotel bookings for visitors
     */
    public function hotelBookings()
    {
        $user = Auth::user();

        // Hotel room bookings
        $roomBookings = RoomBooking::where('user_id', $user->id)
            ->where('booking_status', '!=', 'cancelled')
            ->with(['room.hotel'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('account.hotel-bookings', compact('roomBookings'));
    }

    /**
     * Hotel Operator Dashboard
     */
    private function hotelOperatorDashboard()
    {
        $user = Auth::user();

        // Get operator's hotels
        $hotels = Hotel::where('operator_id', $user->id)->get();
        $hotelIds = $hotels->pluck('id');

        // Get room statistics
        $totalRooms = Room::whereIn('hotel_id', $hotelIds)->count();
        $availableRooms = Room::whereIn('hotel_id', $hotelIds)
            ->where('status', 'available')
            ->count();
        $occupiedRooms = Room::whereIn('hotel_id', $hotelIds)
            ->where('status', 'occupied')
            ->count();

        // Get recent bookings
        $recentBookings = RoomBooking::whereHas('room', function ($query) use ($hotelIds) {
            $query->whereIn('hotel_id', $hotelIds);
        })->with(['room.hotel', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get today's check-ins and check-outs
        $todayCheckIns = RoomBooking::whereHas('room', function ($query) use ($hotelIds) {
            $query->whereIn('hotel_id', $hotelIds);
        })->where('check_in_date', now()->toDateString())
            ->where('booking_status', 'confirmed')
            ->count();

        $todayCheckOuts = RoomBooking::whereHas('room', function ($query) use ($hotelIds) {
            $query->whereIn('hotel_id', $hotelIds);
        })->where('check_out_date', now()->toDateString())
            ->where('booking_status', 'confirmed')
            ->count();

        // Calculate revenue
        $monthlyRevenue = RoomBooking::whereHas('room', function ($query) use ($hotelIds) {
            $query->whereIn('hotel_id', $hotelIds);
        })->where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount');

        return view('dashboards.hotel-operator', compact(
            'hotels',
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'recentBookings',
            'todayCheckIns',
            'todayCheckOuts',
            'monthlyRevenue'
        ));
    }

    /**
     * Ferry Operator Dashboard
     */
    private function ferryOperatorDashboard()
    {
        $user = Auth::user();

        // Get operator's schedules
        $schedules = FerrySchedule::where('operator_id', $user->id)->get();
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
     * Park Operator Dashboard
     */
    private function parkOperatorDashboard()
    {
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
     * Beach Organizer Dashboard
     */
    private function beachOrganizerDashboard()
    {
        $user = Auth::user();

        // Get organizer's events
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

        return view('dashboards.beach-organizer', compact(
            'events',
            'upcomingEvents',
            'todayEvents',
            'recentBookings',
            'totalParticipants',
            'monthlyRevenue'
        ));
    }

    /**
     * Admin Dashboard
     */
    private function adminDashboard()
    {
        // Get system statistics
        $totalUsers = \App\Models\User::count();
        $totalHotelBookings = RoomBooking::count();
        $totalFerryTickets = FerryTicket::where('booking_status', '!=', 'cancelled')->count();
        $totalParkTickets = ThemeParkTicket::count();
        $totalBeachBookings = BeachEventBooking::count();

        // Get revenue statistics
        $totalRevenue = 0;
        $totalRevenue += RoomBooking::where('payment_status', 'paid')->sum('total_amount');
        $totalRevenue += FerryTicket::where('booking_status', 'confirmed')->sum('total_amount');
        $totalRevenue += ThemeParkTicket::where('ticket_status', 'confirmed')->sum('total_amount');
        $totalRevenue += BeachEventBooking::where('booking_status', 'confirmed')->sum('total_amount');

        // Get recent activities
        $recentBookings = RoomBooking::with(['user', 'room.hotel'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get user distribution
        $usersByRole = \App\Models\User::selectRaw('role, count(*) as count')
            ->groupBy('role')
            ->get();

        // Get today's ferry tickets
        $todayFerryTickets = FerryTicket::whereDate('travel_date', now()->toDateString())
            ->where('booking_status', '!=', 'cancelled')
            ->with(['user', 'ferrySchedule'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get pending bookings for confirmation
        $pendingRoomBookings = RoomBooking::where('booking_status', 'pending')
            ->with(['user', 'room.hotel'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $pendingFerryTickets = FerryTicket::where('booking_status', 'pending')
            ->with(['user', 'ferrySchedule'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $pendingParkTickets = ThemeParkTicket::where('ticket_status', 'pending')
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $pendingBeachBookings = BeachEventBooking::where('booking_status', 'pending')
            ->with(['user', 'beachEvent'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Count total pending bookings
        $totalPendingCount = RoomBooking::where('booking_status', 'pending')->count() +
            FerryTicket::where('booking_status', 'pending')->count() +
            ThemeParkTicket::where('ticket_status', 'pending')->count() +
            BeachEventBooking::where('booking_status', 'pending')->count();

        return view('dashboards.admin', compact(
            'totalUsers',
            'totalHotelBookings',
            'totalFerryTickets',
            'totalParkTickets',
            'totalBeachBookings',
            'totalRevenue',
            'recentBookings',
            'usersByRole',
            'todayFerryTickets',
            'pendingRoomBookings',
            'pendingFerryTickets',
            'pendingParkTickets',
            'pendingBeachBookings',
            'totalPendingCount'
        ));
    }
}
