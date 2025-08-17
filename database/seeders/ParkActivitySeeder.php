<?php

namespace Database\Seeders;

use App\Models\ParkActivity;
use Illuminate\Database\Seeder;

class ParkActivitySeeder extends Seeder
{
    public function run(): void
    {
        $activities = [
            [
                'name' => 'Space Exploration Roller Coaster',
                'description' => 'A high-speed roller coaster that takes visitors on a simulated journey through space with stunning visual effects.',
                'category' => 'ride',
                'price' => 25.00,
                'capacity' => 24,
                'age_restriction' => 10,
                'height_restriction' => 120,
                'duration_minutes' => 5,
            ],
            [
                'name' => 'Glow-in-the-Dark Night Ride',
                'description' => 'A mystical night-time roller coaster inspired by bioluminescent coral reefs with glowing tracks.',
                'category' => 'ride',
                'price' => 30.00,
                'capacity' => 20,
                'age_restriction' => 8,
                'height_restriction' => 110,
                'duration_minutes' => 7,
            ],
            [
                'name' => 'Water Sports Arena',
                'description' => 'Experience jet skiing, paddleboarding, kayaking, and snorkeling in our controlled water environment.',
                'category' => 'experience',
                'price' => 40.00,
                'capacity' => 50,
                'age_restriction' => 12,
                'height_restriction' => null,
                'duration_minutes' => 60,
            ],
            [
                'name' => 'Superhero 4D Experience',
                'description' => 'Join your favorite superheroes in this immersive 4D cinema experience with motion seats.',
                'category' => 'show',
                'price' => 20.00,
                'capacity' => 80,
                'age_restriction' => 6,
                'height_restriction' => null,
                'duration_minutes' => 25,
            ],
            [
                'name' => 'Pirate Adventure Show',
                'description' => 'Live action pirate show with sword fighting, acrobatics, and audience participation.',
                'category' => 'show',
                'price' => 15.00,
                'capacity' => 200,
                'age_restriction' => null,
                'height_restriction' => null,
                'duration_minutes' => 40,
            ],
            [
                'name' => 'Sky High Swing',
                'description' => 'Soar 100 feet above the island with panoramic views of the ocean and theme park.',
                'category' => 'ride',
                'price' => 22.00,
                'capacity' => 16,
                'age_restriction' => 14,
                'height_restriction' => 140,
                'duration_minutes' => 8,
            ],
            [
                'name' => 'Underwater Tunnel Walk',
                'description' => 'Walk through our glass tunnel surrounded by tropical fish and marine life.',
                'category' => 'experience',
                'price' => 18.00,
                'capacity' => 100,
                'age_restriction' => null,
                'height_restriction' => null,
                'duration_minutes' => 30,
            ],
            [
                'name' => 'Magic Castle Tour',
                'description' => 'Explore the enchanted castle with magical illusions and interactive exhibits.',
                'category' => 'experience',
                'price' => 28.00,
                'capacity' => 30,
                'age_restriction' => null,
                'height_restriction' => null,
                'duration_minutes' => 45,
            ],
            [
                'name' => 'Tropical Restaurant',
                'description' => 'Fine dining experience with local island cuisine and ocean views.',
                'category' => 'dining',
                'price' => 35.00,
                'capacity' => 120,
                'age_restriction' => null,
                'height_restriction' => null,
                'duration_minutes' => 90,
            ],
            [
                'name' => 'Adventure Gift Shop',
                'description' => 'Take home memories with exclusive theme park merchandise and souvenirs.',
                'category' => 'shopping',
                'price' => 0.00,
                'capacity' => null,
                'age_restriction' => null,
                'height_restriction' => null,
                'duration_minutes' => null,
            ],
        ];

        foreach ($activities as $activityData) {
            ParkActivity::factory()->create([
                'name' => $activityData['name'],
                'description' => $activityData['description'],
                'category' => $activityData['category'],
                'price' => $activityData['price'],
                'capacity' => $activityData['capacity'],
                'age_restriction' => $activityData['age_restriction'],
                'height_restriction' => $activityData['height_restriction'],
                'duration_minutes' => $activityData['duration_minutes'],
                'status' => 'active',
            ]);
        }
    }
}
