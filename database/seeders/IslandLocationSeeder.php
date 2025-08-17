<?php

namespace Database\Seeders;

use App\Models\IslandLocation;
use Illuminate\Database\Seeder;

class IslandLocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Paradise Island Resort & Spa',
                'type' => 'hotel',
                'latitude' => 4.2768, // Near Lankanfinolhu Island, Maldives
                'longitude' => 73.5580,
                'description' => 'Luxury beachfront resort with world-class amenities',
                'amenities' => ['Parking', 'WiFi', 'Pool', 'Spa', 'Restaurant'],
            ],
            [
                'name' => 'Ocean Breeze Hotel',
                'type' => 'hotel',
                'latitude' => 4.2205, // Hulhumalé area
                'longitude' => 73.5455,
                'description' => 'Modern hotel with comfortable accommodations',
                'amenities' => ['Parking', 'WiFi', 'Pool', 'Restaurant'],
            ],
            [
                'name' => 'Tropical Taste Restaurant',
                'type' => 'restaurant',
                'latitude' => 4.2186,
                'longitude' => 73.5425,
                'description' => 'Authentic island cuisine with fresh seafood',
                'amenities' => ['WiFi', 'Outdoor Seating', 'Bar', 'Wheelchair Access'],
            ],
            [
                'name' => 'Seaside Grill',
                'type' => 'restaurant',
                'latitude' => 4.2169,
                'longitude' => 73.5472,
                'description' => 'Casual beachfront dining with stunning views',
                'amenities' => ['WiFi', 'Outdoor Seating', 'Bar'],
            ],
            [
                'name' => 'Island Adventure Theme Park',
                'type' => 'theme_park',
                'latitude' => 4.2245,
                'longitude' => 73.5515,
                'description' => 'World-class theme park with thrilling rides and shows',
                'amenities' => ['Parking', 'Restrooms', 'Food Service', 'First Aid', 'Gift Shop'],
            ],
            [
                'name' => 'Main Ferry Terminal',
                'type' => 'ferry_dock',
                'latitude' => 4.2132,
                'longitude' => 73.5289,
                'description' => 'Primary ferry terminal connecting islands',
                'amenities' => ['Parking', 'Restrooms', 'Waiting Area', 'Ticket Office'],
            ],
            [
                'name' => 'North Beach Area',
                'type' => 'beach_area',
                'latitude' => 4.2312,
                'longitude' => 73.5531,
                'description' => 'Pristine beach perfect for swimming and water sports',
                'amenities' => ['Restrooms', 'Lifeguard', 'Beach Equipment Rental'],
            ],
            [
                'name' => 'Sunset Beach',
                'type' => 'beach_area',
                'latitude' => 4.2059,
                'longitude' => 73.5384,
                'description' => 'Popular spot for watching spectacular sunsets',
                'amenities' => ['Restrooms', 'Beach Bar', 'Volleyball Court'],
            ],
            [
                'name' => 'Marina Bay',
                'type' => 'other',
                'latitude' => 4.2191,
                'longitude' => 73.5408,
                'description' => 'Full-service marina with boat rentals and tours',
                'amenities' => ['Parking', 'Restrooms', 'Fuel Station', 'Ship Store'],
            ],
            [
                'name' => 'Island Shopping Center',
                'type' => 'other',
                'latitude' => 4.2164,
                'longitude' => 73.5441,
                'description' => 'Shopping complex with local crafts and souvenirs',
                'amenities' => ['Parking', 'WiFi', 'Restrooms', 'ATM', 'Food Court'],
            ],
        ];

        foreach ($locations as $locationData) {
            IslandLocation::factory()->create([
                'name' => $locationData['name'],
                'type' => $locationData['type'],
                'latitude' => $locationData['latitude'],
                'longitude' => $locationData['longitude'],
                'description' => $locationData['description'],
                'amenities' => $locationData['amenities'],
                'status' => 'active',
            ]);
        }
    }
}
