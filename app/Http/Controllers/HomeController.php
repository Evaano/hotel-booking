<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\BeachEvent;
use App\Models\Hotel;
use App\Models\IslandLocation;
use App\Models\ParkActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display the homepage with advertisements and map
     */
    public function index()
    {
        // Redirect authenticated users to dashboard instead of showing Home
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        // Get active advertisements
        $advertisements = Advertisement::where('status', 'active')
            ->orderBy('display_order', 'asc')
            ->get();

        // Get island locations for map
        $locations = IslandLocation::where('status', 'active')->get();

        // Get featured hotels
        $featuredHotels = Hotel::where('status', 'active')
            ->take(6)
            ->get();

        // Get upcoming beach events
        $upcomingEvents = BeachEvent::where('status', 'active')
            ->where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date', 'asc')
            ->take(4)
            ->get();

        // Get popular park activities
        $popularActivities = ParkActivity::where('status', 'active')
            ->whereIn('category', ['ride', 'experience'])
            ->take(6)
            ->get();

        return view('home', compact(
            'advertisements',
            'locations',
            'featuredHotels',
            'upcomingEvents',
            'popularActivities'
        ));
    }

    /**
     * Display the island map with all locations
     */
    public function map()
    {
        $locations = IslandLocation::where('status', 'active')->get();

        // Group locations by type
        $groupedLocations = $locations->groupBy('type');

        // Get hotels with coordinates
        $hotels = Hotel::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('status', 'active')
            ->get();

        // Get upcoming/active events and try to resolve coordinates by matching IslandLocation names
        $events = BeachEvent::where('status', 'active')
            ->where('event_date', '>=', now()->toDateString())
            ->get()
            ->map(function ($event) {
                $locationName = $event->location ?? '';

                $matched = null;
                if (! empty($locationName)) {
                    $matched = IslandLocation::where('status', 'active')
                        ->where('name', 'like', "%{$locationName}%")
                        ->first();

                    // Simple fallback alias mapping
                    if (! $matched) {
                        $aliases = [
                            'Sunset Point' => 'Sunset Beach',
                            'Marina Beach' => 'Marina Bay',
                            'North Beach' => 'North Beach Area',
                            'South Beach' => 'North Beach Area',
                        ];
                        if (isset($aliases[$locationName])) {
                            $matched = IslandLocation::where('status', 'active')
                                ->where('name', 'like', "%{$aliases[$locationName]}%")
                                ->first();
                        }
                    }
                }

                $event->latitude = $matched?->latitude;
                $event->longitude = $matched?->longitude;

                return $event;
            });

        return view('map', compact('groupedLocations', 'hotels', 'events'));
    }

    /**
     * Search functionality for the entire system
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (empty($query)) {
            return redirect()->route('home');
        }

        // Search hotels
        $hotels = Hotel::where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhere('address', 'like', "%{$query}%");
            })
            ->get();

        // Search beach events
        $beachEvents = BeachEvent::where('status', 'active')
            ->where('event_date', '>=', now()->toDateString())
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhere('location', 'like', "%{$query}%");
            })
            ->get();

        // Search park activities
        $parkActivities = ParkActivity::where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->get();

        return view('search', compact('query', 'hotels', 'beachEvents', 'parkActivities'));
    }

    /**
     * Display contact page
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Handle contact form submission
     */
    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Here you would typically send an email or store the contact message
        // For now, we'll just redirect with a success message

        return redirect()->route('contact')
            ->with('success', 'Thank you for your message. We will get back to you soon!');
    }
}
