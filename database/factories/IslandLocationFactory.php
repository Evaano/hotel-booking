<?php

namespace Database\Factories;

use App\Models\IslandLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class IslandLocationFactory extends Factory
{
    protected $model = IslandLocation::class;

    public function definition(): array
    {
        $locations = [
            ['name' => 'Paradise Resort & Spa', 'type' => 'hotel'],
            ['name' => 'Ocean Breeze Hotel', 'type' => 'hotel'],
            ['name' => 'Tropical Taste Restaurant', 'type' => 'restaurant'],
            ['name' => 'Seaside Grill', 'type' => 'restaurant'],
            ['name' => 'Island Adventure Theme Park', 'type' => 'theme_park'],
            ['name' => 'Main Ferry Terminal', 'type' => 'ferry_dock'],
            ['name' => 'North Beach Area', 'type' => 'beach_area'],
            ['name' => 'Sunset Beach', 'type' => 'beach_area'],
            ['name' => 'Marina Bay', 'type' => 'other'],
            ['name' => 'Island Shopping Center', 'type' => 'other'],
        ];

        $location = fake()->randomElement($locations);

        return [
            'name' => $location['name'],
            'type' => $location['type'],
            // Hulhumalé/Malé Atoll vicinity
            'latitude' => fake()->latitude(4.18, 4.30),
            'longitude' => fake()->longitude(73.49, 73.60),
            'description' => fake()->paragraph(1),
            'amenities' => fake()->randomElements([
                'Parking', 'WiFi', 'Restrooms', 'Food Service', 'ATM',
                'Gift Shop', 'First Aid', 'Wheelchair Access',
            ], rand(2, 5)),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
}
