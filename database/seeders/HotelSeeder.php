<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $hotelOperators = User::where('role', 'hotel_operator')->get();

        $hotels = [
            [
                'name' => 'Paradise Island Resort & Spa',
                'description' => 'Luxury beachfront resort with world-class amenities and stunning ocean views.',
                'address' => '123 Paradise Drive, Island Bay',
                'rating' => 4.8,
                'amenities' => ['WiFi', 'Pool', 'Spa', 'Restaurant', 'Bar', 'Beach Access', 'Room Service'],
            ],
            [
                'name' => 'Ocean Breeze Hotel',
                'description' => 'Modern hotel with comfortable accommodations and easy access to island attractions.',
                'address' => '456 Ocean View Boulevard, Island Bay',
                'rating' => 4.2,
                'amenities' => ['WiFi', 'Pool', 'Restaurant', 'Parking', 'Gym'],
            ],
            [
                'name' => 'Tropical Retreat Lodge',
                'description' => 'Boutique hotel nestled in tropical gardens with personalized service.',
                'address' => '789 Tropical Lane, Island Bay',
                'rating' => 4.5,
                'amenities' => ['WiFi', 'Pool', 'Spa', 'Bar', 'Concierge', 'Beach Access'],
            ],
        ];

        foreach ($hotels as $index => $hotelData) {
            $hotel = Hotel::factory()->create([
                'name' => $hotelData['name'],
                'description' => $hotelData['description'],
                'address' => $hotelData['address'],
                'rating' => $hotelData['rating'],
                'amenities' => $hotelData['amenities'],
                'operator_id' => $hotelOperators[$index % $hotelOperators->count()]->id,
                'status' => 'active',
            ]);

            // Create rooms for each hotel
            Room::factory(15)->create([
                'hotel_id' => $hotel->id,
                'status' => 'available',
            ]);
        }
    }
}
