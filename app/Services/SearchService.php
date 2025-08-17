<?php

namespace App\Services;

use App\Models\BeachEvent;
use App\Models\FerrySchedule;
use App\Models\Hotel;
use App\Models\ParkActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchService
{
    /**
     * Advanced hotel search with filters
     */
    public function searchHotels(Request $request): Builder
    {
        $query = Hotel::with(['rooms', 'operator'])
            ->where('status', 'active');

        // Search by name or description
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function (Builder $q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%")
                    ->orWhere('address', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->whereHas('rooms', function (Builder $q) use ($request) {
                $q->where('base_price', '>=', $request->min_price);
            });
        }

        if ($request->filled('max_price')) {
            $query->whereHas('rooms', function (Builder $q) use ($request) {
                $q->where('base_price', '<=', $request->max_price);
            });
        }

        // Filter by amenities
        if ($request->filled('amenities')) {
            $amenities = explode(',', $request->amenities);
            foreach ($amenities as $amenity) {
                $query->whereJsonContains('amenities', $amenity);
            }
        }

        // Filter by rating
        if ($request->filled('min_rating')) {
            $query->where('rating', '>=', $request->min_rating);
        }

        // Filter by room type
        if ($request->filled('room_type')) {
            $query->whereHas('rooms', function (Builder $q) use ($request) {
                $q->where('room_type', $request->room_type);
            });
        }

        // Filter by guest capacity
        if ($request->filled('min_guests')) {
            $query->whereHas('rooms', function (Builder $q) use ($request) {
                $q->where('max_occupancy', '>=', $request->min_guests);
            });
        }

        // Filter by availability dates
        if ($request->filled('check_in') && $request->filled('check_out')) {
            $checkIn = $request->check_in;
            $checkOut = $request->check_out;

            $query->whereHas('rooms', function (Builder $q) use ($checkIn, $checkOut) {
                $q->whereDoesntHave('bookings', function (Builder $subQ) use ($checkIn, $checkOut) {
                    $subQ->where('booking_status', '!=', 'cancelled')
                        ->where(function (Builder $dateQ) use ($checkIn, $checkOut) {
                            $dateQ->whereBetween('check_in_date', [$checkIn, $checkOut])
                                ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                                ->orWhere(function (Builder $overlapQ) use ($checkIn, $checkOut) {
                                    $overlapQ->where('check_in_date', '<=', $checkIn)
                                        ->where('check_out_date', '>=', $checkOut);
                                });
                        });
                });
            });
        }

        // Sort results
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');

        switch ($sortBy) {
            case 'price':
                $query->orderByRaw('(SELECT MIN(base_price) FROM rooms WHERE rooms.hotel_id = hotels.id) '.$sortOrder);
                break;
            case 'rating':
                $query->orderBy('rating', $sortOrder);
                break;
            case 'name':
            default:
                $query->orderBy('name', $sortOrder);
                break;
        }

        return $query;
    }

    /**
     * Advanced theme park activity search
     */
    public function searchParkActivities(Request $request): Builder
    {
        $query = ParkActivity::where('status', 'active');

        // Search by name or description
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function (Builder $q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by age restriction
        if ($request->filled('max_age')) {
            $query->where(function (Builder $q) use ($request) {
                $q->whereNull('age_restriction')
                    ->orWhere('age_restriction', '<=', $request->max_age);
            });
        }

        // Filter by height restriction
        if ($request->filled('min_height')) {
            $query->where(function (Builder $q) use ($request) {
                $q->whereNull('height_restriction')
                    ->orWhere('height_restriction', '<=', $request->min_height);
            });
        }

        // Filter by duration
        if ($request->filled('max_duration')) {
            $query->where(function (Builder $q) use ($request) {
                $q->whereNull('duration_minutes')
                    ->orWhere('duration_minutes', '<=', $request->max_duration);
            });
        }

        // Sort results
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');

        switch ($sortBy) {
            case 'price':
                $query->orderBy('price', $sortOrder);
                break;
            case 'duration':
                $query->orderBy('duration_minutes', $sortOrder);
                break;
            case 'name':
            default:
                $query->orderBy('name', $sortOrder);
                break;
        }

        return $query;
    }

    /**
     * Advanced beach event search
     */
    public function searchBeachEvents(Request $request): Builder
    {
        $query = BeachEvent::with('organizer')
            ->where('status', 'active');

        // Search by name or description
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function (Builder $q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%")
                    ->orWhere('location', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by event type
        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->where('event_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('event_date', '<=', $request->end_date);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by age restriction
        if ($request->filled('max_age')) {
            $query->where(function (Builder $q) use ($request) {
                $q->whereNull('age_restriction')
                    ->orWhere('age_restriction', '<=', $request->max_age);
            });
        }

        // Filter by equipment inclusion
        if ($request->filled('equipment_included')) {
            $query->where('equipment_included', $request->equipment_included);
        }

        // Filter by availability (not fully booked)
        if ($request->filled('available_only') && $request->available_only) {
            $query->whereRaw('capacity > (
                SELECT COALESCE(SUM(num_participants), 0) 
                FROM beach_event_bookings 
                WHERE beach_event_bookings.beach_event_id = beach_events.id 
                AND beach_event_bookings.booking_status != "cancelled"
            )');
        }

        // Sort results
        $sortBy = $request->get('sort_by', 'event_date');
        $sortOrder = $request->get('sort_order', 'asc');

        switch ($sortBy) {
            case 'price':
                $query->orderBy('price', $sortOrder);
                break;
            case 'name':
                $query->orderBy('name', $sortOrder);
                break;
            case 'event_date':
            default:
                $query->orderBy('event_date', $sortOrder);
                break;
        }

        return $query;
    }

    /**
     * Advanced ferry schedule search
     */
    public function searchFerrySchedules(Request $request): Builder
    {
        $query = FerrySchedule::with('operator')
            ->where('status', 'active');

        // Search by route
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('route', 'like', "%{$searchTerm}%");
        }

        // Filter by route
        if ($request->filled('route')) {
            $query->where('route', $request->route);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by capacity
        if ($request->filled('min_capacity')) {
            $query->where('capacity', '>=', $request->min_capacity);
        }

        // Filter by specific day of week
        if ($request->filled('day_of_week')) {
            $day = strtolower($request->day_of_week);
            $query->whereJsonContains('days_of_week', $day);
        }

        // Filter by departure time range
        if ($request->filled('departure_after')) {
            $query->where('departure_time', '>=', $request->departure_after);
        }

        if ($request->filled('departure_before')) {
            $query->where('departure_time', '<=', $request->departure_before);
        }

        // Sort results
        $sortBy = $request->get('sort_by', 'departure_time');
        $sortOrder = $request->get('sort_order', 'asc');

        switch ($sortBy) {
            case 'price':
                $query->orderBy('price', $sortOrder);
                break;
            case 'capacity':
                $query->orderBy('capacity', $sortOrder);
                break;
            case 'departure_time':
            default:
                $query->orderBy('departure_time', $sortOrder);
                break;
        }

        return $query;
    }

    /**
     * Get search suggestions based on user input
     */
    public function getSearchSuggestions(string $query, string $type = 'hotels'): array
    {
        $suggestions = [];

        switch ($type) {
            case 'hotels':
                $suggestions = Hotel::where('name', 'like', "%{$query}%")
                    ->orWhere('address', 'like', "%{$query}%")
                    ->limit(5)
                    ->pluck('name')
                    ->toArray();
                break;

            case 'activities':
                $suggestions = ParkActivity::where('name', 'like', "%{$query}%")
                    ->limit(5)
                    ->pluck('name')
                    ->toArray();
                break;

            case 'events':
                $suggestions = BeachEvent::where('name', 'like', "%{$query}%")
                    ->limit(5)
                    ->pluck('name')
                    ->toArray();
                break;

            case 'routes':
                $suggestions = FerrySchedule::where('route', 'like', "%{$query}%")
                    ->limit(5)
                    ->pluck('route')
                    ->unique()
                    ->values()
                    ->toArray();
                break;
        }

        return $suggestions;
    }

    /**
     * Get popular search terms
     */
    public function getPopularSearches(): array
    {
        return [
            'hotels' => ['beachfront', 'luxury', 'family-friendly', 'budget', 'resort'],
            'activities' => ['roller coaster', 'water sports', 'shows', 'dining', 'shopping'],
            'events' => ['water sports', 'beach volleyball', 'surfing', 'snorkeling', 'beach party'],
            'routes' => ['mainland to island', 'island to mainland', 'island hopping'],
        ];
    }
}
