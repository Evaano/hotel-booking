<?php

namespace Database\Factories;

use App\Models\ParkActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParkActivityFactory extends Factory
{
    protected $model = ParkActivity::class;

    public function definition(): array
    {
        $activities = [
            ['name' => 'Space Exploration Roller Coaster', 'category' => 'ride', 'price' => 25.00],
            ['name' => 'Glow-in-the-Dark Night Ride', 'category' => 'ride', 'price' => 30.00],
            ['name' => 'Water Sports Arena', 'category' => 'experience', 'price' => 40.00],
            ['name' => 'Superhero 4D Experience', 'category' => 'show', 'price' => 20.00],
            ['name' => 'Pirate Adventure Show', 'category' => 'show', 'price' => 15.00],
            ['name' => 'Tropical Restaurant', 'category' => 'dining', 'price' => 35.00],
            ['name' => 'Adventure Gift Shop', 'category' => 'shopping', 'price' => 0.00],
            ['name' => 'Sky High Swing', 'category' => 'ride', 'price' => 22.00],
            ['name' => 'Underwater Tunnel Walk', 'category' => 'experience', 'price' => 18.00],
            ['name' => 'Magic Castle Tour', 'category' => 'experience', 'price' => 28.00],
        ];

        $activity = fake()->randomElement($activities);

        return [
            'name' => $activity['name'],
            'description' => fake()->paragraph(2),
            'category' => $activity['category'],
            'price' => $activity['price'],
            'capacity' => fake()->numberBetween(20, 200),
            'age_restriction' => fake()->optional(0.3)->numberBetween(5, 16),
            'height_restriction' => fake()->optional(0.4)->numberBetween(100, 150),
            'duration_minutes' => fake()->numberBetween(15, 120),
            'location_coordinates' => [
                'lat' => fake()->latitude(25.0, 26.0),
                'lng' => fake()->longitude(-81.0, -80.0),
            ],
            'status' => fake()->randomElement(['active', 'inactive', 'maintenance']),
        ];
    }
}
