<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company().' Resort',
            'description' => fake()->paragraph(3),
            'address' => fake()->address(),
            // Coordinates around Hulhumalé / Malé Atoll, Maldives
            'latitude' => fake()->latitude(4.18, 4.30),
            'longitude' => fake()->longitude(73.49, 73.60),
            'amenities' => fake()->randomElements([
                'WiFi', 'Pool', 'Spa', 'Restaurant', 'Bar', 'Gym',
                'Beach Access', 'Room Service', 'Concierge', 'Parking',
            ], rand(3, 7)),
            'rating' => fake()->randomFloat(1, 3.0, 5.0),
            'operator_id' => User::factory(),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
}
