<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Display a listing of all rooms for hotel operators and admins.
     */
    public function allRooms()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Admin can see all rooms
            $rooms = Room::with('hotel')->get();
            $hotels = Hotel::all();
        } else {
            // Hotel operator can only see their hotels' rooms
            $hotels = Hotel::where('operator_id', $user->id)->get();
            $hotelIds = $hotels->pluck('id');
            $rooms = Room::whereIn('hotel_id', $hotelIds)->with('hotel')->get();
        }

        return view('rooms.all', compact('rooms', 'hotels'));
    }

    /**
     * Display a listing of rooms for a hotel.
     */
    public function index(Hotel $hotel)
    {
        // Check if the user is the operator of this hotel
        if (Auth::user()->isHotelOperator() && $hotel->operator_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $rooms = $hotel->rooms;

        return view('rooms.index', compact('hotel', 'rooms'));
    }

    /**
     * Show the form for creating a new room.
     */
    public function create(Hotel $hotel)
    {
        // Check if the user is the operator of this hotel
        if (Auth::user()->isHotelOperator() && $hotel->operator_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('rooms.create', compact('hotel'));
    }

    /**
     * Store a newly created room in storage.
     */
    public function store(Request $request, Hotel $hotel)
    {
        // Check if the user is the operator of this hotel
        if (Auth::user()->isHotelOperator() && $hotel->operator_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'room_number' => 'required|string|max:50',
            'room_type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'max_occupancy' => 'required|integer|min:1|max:10',
            'base_price' => 'required|numeric|min:0',
            'amenities' => 'nullable|array',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        $validated['hotel_id'] = $hotel->id;

        if (isset($validated['amenities'])) {
            $validated['amenities'] = json_encode($validated['amenities']);
        }

        $room = Room::create($validated);

        return redirect()->route('hotels.rooms.show', [$hotel, $room])
            ->with('success', 'Room created successfully.');
    }

    /**
     * Display the specified room.
     */
    public function show(Hotel $hotel, Room $room)
    {
        // Ensure the room belongs to the hotel
        if ($room->hotel_id !== $hotel->id) {
            abort(404);
        }

        return view('rooms.show', compact('hotel', 'room'));
    }

    /**
     * Show the form for editing the specified room.
     */
    public function edit(Hotel $hotel, Room $room)
    {
        // Check if the user is the operator of this hotel
        if (Auth::user()->isHotelOperator() && $hotel->operator_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Ensure the room belongs to the hotel
        if ($room->hotel_id !== $hotel->id) {
            abort(404);
        }

        return view('rooms.edit', compact('hotel', 'room'));
    }

    /**
     * Update the specified room in storage.
     */
    public function update(Request $request, Hotel $hotel, Room $room)
    {
        // Check if the user is the operator of this hotel
        if (Auth::user()->isHotelOperator() && $hotel->operator_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Ensure the room belongs to the hotel
        if ($room->hotel_id !== $hotel->id) {
            abort(404);
        }

        $validated = $request->validate([
            'room_number' => 'required|string|max:50',
            'room_type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'max_occupancy' => 'required|integer|min:1|max:10',
            'base_price' => 'required|numeric|min:0',
            'amenities' => 'nullable|array',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        if (isset($validated['amenities'])) {
            $validated['amenities'] = json_encode($validated['amenities']);
        }

        $room->update($validated);

        return redirect()->route('hotels.rooms.show', [$hotel, $room])
            ->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified room from storage.
     */
    public function destroy(Hotel $hotel, Room $room)
    {
        // Check if the user is the operator of this hotel
        if (Auth::user()->isHotelOperator() && $hotel->operator_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Ensure the room belongs to the hotel
        if ($room->hotel_id !== $hotel->id) {
            abort(404);
        }

        // Prevent delete if room has bookings
        if ($room->bookings()->exists()) {
            return back()->with('error', 'Cannot delete room with existing bookings.');
        }

        $room->delete();

        return redirect()->route('hotels.rooms.index', $hotel)
            ->with('success', 'Room deleted successfully.');
    }
}
