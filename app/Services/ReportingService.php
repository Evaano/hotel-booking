<?php

namespace App\Services;

use App\Models\BeachEvent;
use App\Models\BeachEventBooking;
use App\Models\FerrySchedule;
use App\Models\FerryTicket;
use App\Models\Hotel;
use App\Models\RoomBooking;
use App\Models\ThemeParkTicket;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportingService
{
    /**
     * Get hotel operator dashboard statistics
     */
    public function getHotelOperatorStats(int $operatorId, string $period = 'month'): array
    {
        $dateRange = $this->getDateRange($period);

        $hotels = Hotel::where('operator_id', $operatorId)->pluck('id');

        $stats = [
            'total_bookings' => RoomBooking::whereIn('room_id', function ($query) use ($hotels) {
                $query->select('id')->from('rooms')->whereIn('hotel_id', $hotels);
            })->whereBetween('created_at', $dateRange)->count(),

            'confirmed_bookings' => RoomBooking::whereIn('room_id', function ($query) use ($hotels) {
                $query->select('id')->from('rooms')->whereIn('hotel_id', $hotels);
            })->where('booking_status', 'confirmed')
                ->whereBetween('created_at', $dateRange)->count(),

            'total_revenue' => RoomBooking::whereIn('room_id', function ($query) use ($hotels) {
                $query->select('id')->from('rooms')->whereIn('hotel_id', $hotels);
            })->where('payment_status', 'paid')
                ->whereBetween('created_at', $dateRange)->sum('total_amount'),

            'occupancy_rate' => $this->calculateOccupancyRate($hotels, $dateRange),

            'average_booking_value' => RoomBooking::whereIn('room_id', function ($query) use ($hotels) {
                $query->select('id')->from('rooms')->whereIn('hotel_id', $hotels);
            })->whereBetween('created_at', $dateRange)->avg('total_amount'),

            'cancellation_rate' => $this->calculateCancellationRate($hotels, $dateRange),
        ];

        return $stats;
    }

    /**
     * Get ferry operator dashboard statistics
     */
    public function getFerryOperatorStats(int $operatorId, string $period = 'month'): array
    {
        $dateRange = $this->getDateRange($period);

        $schedules = FerrySchedule::where('operator_id', $operatorId)->pluck('id');

        $stats = [
            'total_tickets' => FerryTicket::whereIn('ferry_schedule_id', $schedules)
                ->whereBetween('created_at', $dateRange)->count(),

            'confirmed_tickets' => FerryTicket::whereIn('ferry_schedule_id', $schedules)
                ->where('booking_status', 'confirmed')
                ->whereBetween('created_at', $dateRange)->count(),

            'total_revenue' => FerryTicket::whereIn('ferry_schedule_id', $schedules)
                ->where('booking_status', 'confirmed')
                ->whereBetween('created_at', $dateRange)->sum('total_amount'),

            'average_capacity_utilization' => $this->calculateFerryCapacityUtilization($schedules, $dateRange),

            'popular_routes' => $this->getPopularFerryRoutes($schedules, $dateRange),

            'daily_passenger_count' => $this->getDailyPassengerCount($schedules, $dateRange),
        ];

        return $stats;
    }

    /**
     * Get theme park operator dashboard statistics
     */
    public function getThemeParkOperatorStats(string $period = 'month'): array
    {
        $dateRange = $this->getDateRange($period);

        $stats = [
            'total_tickets' => ThemeParkTicket::whereBetween('created_at', $dateRange)->count(),

            'confirmed_tickets' => ThemeParkTicket::where('ticket_status', 'confirmed')
                ->whereBetween('created_at', $dateRange)->count(),

            'total_revenue' => ThemeParkTicket::where('ticket_status', 'confirmed')
                ->whereBetween('created_at', $dateRange)->sum('total_amount'),

            'activity_bookings' => DB::table('activity_bookings')
                ->join('theme_park_tickets', 'activity_bookings.theme_park_ticket_id', '=', 'theme_park_tickets.id')
                ->whereBetween('activity_bookings.created_at', $dateRange)
                ->where('theme_park_tickets.ticket_status', 'confirmed')
                ->count(),

            'popular_activities' => $this->getPopularParkActivities($dateRange),

            'daily_visitor_count' => $this->getDailyVisitorCount($dateRange),
        ];

        return $stats;
    }

    /**
     * Get beach organizer dashboard statistics
     */
    public function getBeachOrganizerStats(int $organizerId, string $period = 'month'): array
    {
        $dateRange = $this->getDateRange($period);

        $events = BeachEvent::where('organizer_id', $organizerId)->pluck('id');

        $stats = [
            'total_events' => BeachEvent::where('organizer_id', $organizerId)
                ->whereBetween('created_at', $dateRange)->count(),

            'total_bookings' => BeachEventBooking::whereIn('beach_event_id', $events)
                ->whereBetween('created_at', $dateRange)->count(),

            'confirmed_bookings' => BeachEventBooking::whereIn('beach_event_id', $events)
                ->where('booking_status', 'confirmed')
                ->whereBetween('created_at', $dateRange)->count(),

            'total_revenue' => BeachEventBooking::whereIn('beach_event_id', $events)
                ->where('booking_status', 'confirmed')
                ->whereBetween('created_at', $dateRange)->sum('total_amount'),

            'average_event_attendance' => $this->calculateAverageEventAttendance($events, $dateRange),

            'popular_event_types' => $this->getPopularEventTypes($events, $dateRange),
        ];

        return $stats;
    }

    /**
     * Get system-wide analytics for administrators
     */
    public function getSystemWideStats(string $period = 'month'): array
    {
        $dateRange = $this->getDateRange($period);

        $stats = [
            'total_users' => DB::table('users')->count(),
            'new_users' => DB::table('users')->whereBetween('created_at', $dateRange)->count(),

            'total_hotel_bookings' => RoomBooking::whereBetween('created_at', $dateRange)->count(),
            'total_ferry_tickets' => FerryTicket::whereBetween('created_at', $dateRange)->count(),
            'total_theme_park_tickets' => ThemeParkTicket::whereBetween('created_at', $dateRange)->count(),
            'total_beach_event_bookings' => BeachEventBooking::whereBetween('created_at', $dateRange)->count(),

            'total_revenue' => RoomBooking::where('payment_status', 'paid')
                ->whereBetween('created_at', $dateRange)->sum('total_amount') +
                FerryTicket::where('booking_status', 'confirmed')
                    ->whereBetween('created_at', $dateRange)->sum('total_amount') +
                ThemeParkTicket::where('ticket_status', 'confirmed')
                    ->whereBetween('created_at', $dateRange)->sum('total_amount') +
                BeachEventBooking::where('booking_status', 'confirmed')
                    ->whereBetween('created_at', $dateRange)->sum('total_amount'),

            'top_performing_hotels' => $this->getTopPerformingHotels($dateRange),
            'top_performing_activities' => $this->getTopPerformingActivities($dateRange),
            'top_performing_events' => $this->getTopPerformingEvents($dateRange),
        ];

        return $stats;
    }

    /**
     * Generate booking trend report
     */
    public function getBookingTrends(string $type, string $period = 'month'): array
    {
        $dateRange = $this->getDateRange($period);
        $trends = [];

        switch ($type) {
            case 'hotels':
                $trends = RoomBooking::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->whereBetween('created_at', $dateRange)
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get()
                    ->pluck('count', 'date')
                    ->toArray();
                break;

            case 'ferry':
                $trends = FerryTicket::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->whereBetween('created_at', $dateRange)
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get()
                    ->pluck('count', 'date')
                    ->toArray();
                break;

            case 'theme_park':
                $trends = ThemeParkTicket::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->whereBetween('created_at', $dateRange)
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get()
                    ->pluck('count', 'date')
                    ->toArray();
                break;

            case 'beach_events':
                $trends = BeachEventBooking::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->whereBetween('created_at', $dateRange)
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get()
                    ->pluck('count', 'date')
                    ->toArray();
                break;
        }

        return $trends;
    }

    /**
     * Generate revenue report
     */
    public function getRevenueReport(string $period = 'month'): array
    {
        $dateRange = $this->getDateRange($period);

        $revenue = [
            'hotels' => RoomBooking::where('payment_status', 'paid')
                ->whereBetween('created_at', $dateRange)->sum('total_amount'),

            'ferry' => FerryTicket::where('booking_status', 'confirmed')
                ->whereBetween('created_at', $dateRange)->sum('total_amount'),

            'theme_park' => ThemeParkTicket::where('ticket_status', 'confirmed')
                ->whereBetween('created_at', $dateRange)->sum('total_amount'),

            'beach_events' => BeachEventBooking::where('booking_status', 'confirmed')
                ->whereBetween('created_at', $dateRange)->sum('total_amount'),
        ];

        $revenue['total'] = array_sum($revenue);

        return $revenue;
    }

    /**
     * Get date range based on period
     */
    private function getDateRange(string $period): array
    {
        $now = Carbon::now();

        switch ($period) {
            case 'week':
                $start = $now->copy()->startOfWeek();
                break;
            case 'month':
                $start = $now->copy()->startOfMonth();
                break;
            case 'quarter':
                $start = $now->copy()->startOfQuarter();
                break;
            case 'year':
                $start = $now->copy()->startOfYear();
                break;
            default:
                $start = $now->copy()->subDays(30);
        }

        return [$start, $now];
    }

    /**
     * Calculate hotel occupancy rate
     */
    private function calculateOccupancyRate(array $hotelIds, array $dateRange): float
    {
        $totalRooms = DB::table('rooms')->whereIn('hotel_id', $hotelIds)->count();

        if ($totalRooms === 0) {
            return 0.0;
        }

        $occupiedRooms = RoomBooking::whereIn('room_id', function ($query) use ($hotelIds) {
            $query->select('id')->from('rooms')->whereIn('hotel_id', $hotelIds);
        })->where('booking_status', 'confirmed')
            ->where('check_in_date', '<=', $dateRange[1])
            ->where('check_out_date', '>=', $dateRange[0])
            ->count();

        return round(($occupiedRooms / $totalRooms) * 100, 2);
    }

    /**
     * Calculate cancellation rate
     */
    private function calculateCancellationRate(array $hotelIds, array $dateRange): float
    {
        $totalBookings = RoomBooking::whereIn('room_id', function ($query) use ($hotelIds) {
            $query->select('id')->from('rooms')->whereIn('hotel_id', $hotelIds);
        })->whereBetween('created_at', $dateRange)->count();

        if ($totalBookings === 0) {
            return 0.0;
        }

        $cancelledBookings = RoomBooking::whereIn('room_id', function ($query) use ($hotelIds) {
            $query->select('id')->from('rooms')->whereIn('hotel_id', $hotelIds);
        })->where('booking_status', 'cancelled')
            ->whereBetween('created_at', $dateRange)->count();

        return round(($cancelledBookings / $totalBookings) * 100, 2);
    }

    /**
     * Calculate ferry capacity utilization
     */
    private function calculateFerryCapacityUtilization(array $scheduleIds, array $dateRange): float
    {
        $totalCapacity = FerrySchedule::whereIn('id', $scheduleIds)->sum('capacity');

        if ($totalCapacity === 0) {
            return 0.0;
        }

        $totalBooked = FerryTicket::whereIn('ferry_schedule_id', $scheduleIds)
            ->where('booking_status', '!=', 'cancelled')
            ->whereBetween('created_at', $dateRange)
            ->sum('num_passengers');

        return round(($totalBooked / $totalCapacity) * 100, 2);
    }

    /**
     * Get popular ferry routes
     */
    private function getPopularFerryRoutes(array $scheduleIds, array $dateRange): array
    {
        return FerryTicket::selectRaw('ferry_schedule.route, COUNT(*) as ticket_count')
            ->join('ferry_schedule', 'ferry_tickets.ferry_schedule_id', '=', 'ferry_schedule.id')
            ->whereIn('ferry_tickets.ferry_schedule_id', $scheduleIds)
            ->whereBetween('ferry_tickets.created_at', $dateRange)
            ->groupBy('ferry_schedule.route')
            ->orderByDesc('ticket_count')
            ->limit(5)
            ->get()
            ->toArray();
    }

    /**
     * Get daily passenger count
     */
    private function getDailyPassengerCount(array $scheduleIds, array $dateRange): array
    {
        return FerryTicket::selectRaw('DATE(created_at) as date, SUM(num_passengers) as total_passengers')
            ->whereIn('ferry_schedule_id', $scheduleIds)
            ->whereBetween('created_at', $dateRange)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total_passengers', 'date')
            ->toArray();
    }

    /**
     * Get popular park activities
     */
    private function getPopularParkActivities(array $dateRange): array
    {
        return DB::table('activity_bookings')
            ->selectRaw('park_activities.name, COUNT(*) as booking_count')
            ->join('theme_park_tickets', 'activity_bookings.theme_park_ticket_id', '=', 'theme_park_tickets.id')
            ->join('park_activities', 'activity_bookings.park_activity_id', '=', 'park_activities.id')
            ->whereBetween('activity_bookings.created_at', $dateRange)
            ->where('theme_park_tickets.ticket_status', 'confirmed')
            ->groupBy('park_activities.id', 'park_activities.name')
            ->orderByDesc('booking_count')
            ->limit(10)
            ->get()
            ->toArray();
    }

    /**
     * Get daily visitor count
     */
    private function getDailyVisitorCount(array $dateRange): array
    {
        return ThemeParkTicket::selectRaw('DATE(created_at) as date, SUM(num_tickets) as total_visitors')
            ->whereBetween('created_at', $dateRange)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total_visitors', 'date')
            ->toArray();
    }

    /**
     * Calculate average event attendance
     */
    private function calculateAverageEventAttendance(array $eventIds, array $dateRange): float
    {
        $totalBookings = BeachEventBooking::whereIn('beach_event_id', $eventIds)
            ->where('booking_status', 'confirmed')
            ->whereBetween('created_at', $dateRange)
            ->sum('num_participants');

        $totalEvents = BeachEvent::whereIn('id', $eventIds)
            ->whereBetween('created_at', $dateRange)->count();

        if ($totalEvents === 0) {
            return 0.0;
        }

        return round($totalBookings / $totalEvents, 2);
    }

    /**
     * Get popular event types
     */
    private function getPopularEventTypes(array $eventIds, array $dateRange): array
    {
        return BeachEvent::selectRaw('event_type, COUNT(*) as event_count')
            ->whereIn('id', $eventIds)
            ->whereBetween('created_at', $dateRange)
            ->groupBy('event_type')
            ->orderByDesc('event_count')
            ->get()
            ->toArray();
    }

    /**
     * Get top performing hotels
     */
    private function getTopPerformingHotels(array $dateRange): array
    {
        return RoomBooking::selectRaw('hotels.name, COUNT(*) as booking_count, SUM(room_bookings.total_amount) as revenue')
            ->join('rooms', 'room_bookings.room_id', '=', 'rooms.id')
            ->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
            ->whereBetween('room_bookings.created_at', $dateRange)
            ->where('room_bookings.payment_status', 'paid')
            ->groupBy('hotels.id', 'hotels.name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get()
            ->toArray();
    }

    /**
     * Get top performing activities
     */
    private function getTopPerformingActivities(array $dateRange): array
    {
        return DB::table('activity_bookings')
            ->selectRaw('park_activities.name, COUNT(*) as booking_count')
            ->join('theme_park_tickets', 'activity_bookings.theme_park_ticket_id', '=', 'theme_park_tickets.id')
            ->join('park_activities', 'activity_bookings.park_activity_id', '=', 'park_activities.id')
            ->whereBetween('activity_bookings.created_at', $dateRange)
            ->where('theme_park_tickets.ticket_status', 'confirmed')
            ->groupBy('park_activities.id', 'park_activities.name')
            ->orderByDesc('booking_count')
            ->limit(5)
            ->get()
            ->toArray();
    }

    /**
     * Get top performing events
     */
    private function getTopPerformingEvents(array $dateRange): array
    {
        return BeachEvent::selectRaw('beach_events.name, COUNT(beach_event_bookings.id) as booking_count, SUM(beach_event_bookings.total_amount) as revenue')
            ->leftJoin('beach_event_bookings', 'beach_events.id', '=', 'beach_event_bookings.beach_event_id')
            ->whereBetween('beach_events.created_at', $dateRange)
            ->where('beach_event_bookings.booking_status', 'confirmed')
            ->groupBy('beach_events.id', 'beach_events.name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get()
            ->toArray();
    }
}
