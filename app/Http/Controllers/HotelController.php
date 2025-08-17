<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    /**
     * Display a listing of hotels.
     */
    public function index()
    {
        $user = Auth::user();
        $hotels = Hotel::with('rooms')->when($user->role === 'hotel_operator', function ($query) use ($user) {
            return $query->where('operator_id', $user->id);
        })->get();

        // Get bookings for hotel operator
        $bookings = collect();
        $recentBookings = collect();
        $pendingBookings = collect();
        $totalBookings = 0;
        $monthlyRevenue = 0;

        if ($user->role === 'hotel_operator' || $user->role === 'admin') {
            // Get all bookings for the operator's hotels
            $bookings = \App\Models\RoomBooking::whereHas('room.hotel', function ($query) use ($user) {
                if ($user->role === 'hotel_operator') {
                    $query->where('operator_id', $user->id);
                }
            })
                ->with(['room.hotel', 'user'])
                ->orderBy('created_at', 'desc')
                ->get();

            $totalBookings = $bookings->count();

            // Get recent bookings for the sidebar
            $recentBookings = $bookings->take(5);

            // Get pending bookings
            $pendingBookings = $bookings->where('booking_status', 'pending')->take(5);

            // Calculate monthly revenue
            $monthlyRevenue = $bookings
                ->where('booking_status', 'confirmed')
                ->where('payment_status', 'paid')
                ->where('created_at', '>=', now()->startOfMonth())
                ->sum('total_amount');
        }

        return view('hotels.index', compact('hotels', 'bookings', 'recentBookings', 'pendingBookings', 'totalBookings', 'monthlyRevenue'));
    }

    /**
     * Show the form for creating a new hotel.
     */
    public function create()
    {
        return view('hotels.create');
    }

    /**
     * Store a newly created hotel in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'amenities' => 'nullable|array',
            'rating' => 'nullable|numeric|between:0,5',
        ]);

        $validated['operator_id'] = Auth::id();
        $validated['status'] = 'active';

        if (isset($validated['amenities'])) {
            $validated['amenities'] = json_encode($validated['amenities']);
        }

        $hotel = Hotel::create($validated);

        return redirect()->route('hotels.show', $hotel)->with('success', 'Hotel created successfully.');
    }

    /**
     * Display the specified hotel.
     */
    public function show(Hotel $hotel)
    {
        $hotel->load('rooms');

        return view('hotels.show', compact('hotel'));
    }

    /**
     * Show the form for editing the specified hotel.
     */
    public function edit(Hotel $hotel)
    {
        // Check if the user is the operator of this hotel
        if (Auth::user()->role === 'hotel_operator' && $hotel->operator_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('hotels.edit', compact('hotel'));
    }

    /**
     * Update the specified hotel in storage.
     */
    public function update(Request $request, Hotel $hotel)
    {
        // Check if the user is the operator of this hotel
        if (Auth::user()->role === 'hotel_operator' && $hotel->operator_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'amenities' => 'nullable|array',
            'rating' => 'nullable|numeric|between:0,5',
            'status' => 'required|in:active,inactive',
        ]);

        if (isset($validated['amenities'])) {
            $validated['amenities'] = json_encode($validated['amenities']);
        }

        $hotel->update($validated);

        return redirect()->route('hotels.show', $hotel)->with('success', 'Hotel updated successfully.');
    }

    /**
     * Remove the specified hotel from storage.
     */
    public function destroy(Hotel $hotel)
    {
        // Check if the user is the operator of this hotel
        if (Auth::user()->role === 'hotel_operator' && $hotel->operator_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Prevent delete if rooms or bookings exist
        if ($hotel->rooms()->exists() || $hotel->bookings()->exists()) {
            return back()->with('error', 'Cannot delete hotel with existing rooms or bookings.');
        }

        $hotel->delete();

        return redirect()->route('hotels.index')->with('success', 'Hotel deleted successfully.');
    }

    /**
     * Display available hotels for visitors
     */
    public function browse(Request $request)
    {
        $query = Hotel::query()
            ->where('status', 'active')
            ->with(['rooms' => function ($roomsQuery) {
                $roomsQuery->where('status', 'available');
            }]);

        // Text search: name, address, and room type
        if ($search = trim((string) $request->get('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhereHas('rooms', function ($rq) use ($search) {
                        $rq->where('room_type', 'like', "%{$search}%");
                    });
            });
        }

        // Price range filter: matches hotels having at least one available room in range
        if ($priceRange = $request->get('price_range')) {
            [$min, $max] = match ($priceRange) {
                '0-100' => [0, 100],
                '100-200' => [100, 200],
                '200-300' => [200, 300],
                '300+' => [300, null],
                default => [null, null],
            };

            if ($min !== null || $max !== null) {
                $query->whereHas('rooms', function ($rq) use ($min, $max) {
                    $rq->where('status', 'available');
                    if ($min !== null) {
                        $rq->where('base_price', '>=', $min);
                    }
                    if ($max !== null) {
                        $rq->where('base_price', '<=', $max);
                    }
                });
            }
        }

        $hotels = $query->get();

        // Apply amenities filter in-memory to support nested arrays and cross-DB
        if ($amenityKey = $request->get('amenities')) {
            $map = [
                'pool' => 'Pool',
                'spa' => 'Spa',
                'restaurant' => 'Restaurant',
                'gym' => 'Gym',
                'beach_access' => 'Beach Access',
            ];
            if (isset($map[$amenityKey])) {
                $amenityValue = $map[$amenityKey];
                $hotels = $hotels->filter(function ($hotel) use ($amenityValue) {
                    $amenities = collect($hotel->amenities ?? [])->flatten();

                    return $amenities->contains(function ($val) use ($amenityValue) {
                        return is_string($val) && strcasecmp($val, $amenityValue) === 0;
                    });
                })->values();
            }
        }

        return view('hotels.browse', compact('hotels'));
    }
}
