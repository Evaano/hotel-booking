<?php

namespace Database\Factories;

use App\Models\BeachEvent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BeachEventFactory extends Factory
{
    protected $model = BeachEvent::class;

    public function definition(): array
    {
        $events = [
            ['name' => 'Sunrise Yoga Session', 'type' => 'other', 'price' => 25.00],
            ['name' => 'Beach Volleyball Tournament', 'type' => 'beach_volleyball', 'price' => 15.00],
            ['name' => 'Sunset Surfing Lessons', 'type' => 'surfing', 'price' => 45.00],
            ['name' => 'Snorkeling Adventure', 'type' => 'snorkeling', 'price' => 35.00],
            ['name' => 'Beach Party Bonfire', 'type' => 'beach_party', 'price' => 20.00],
            ['name' => 'Jet Ski Experience', 'type' => 'water_sports', 'price' => 60.00],
            ['name' => 'Kayaking Tour', 'type' => 'water_sports', 'price' => 30.00],
            ['name' => 'Paddle Board Rental', 'type' => 'water_sports', 'price' => 25.00],
        ];

        $event = fake()->randomElement($events);
        $startTime = fake()->time('H:i');
        $endTime = fake()->time('H:i', strtotime($startTime.' +3 hours'));

        return [
            'name' => $event['name'],
            'description' => fake()->paragraph(2),
            'event_type' => $event['type'],
            'organizer_id' => User::factory(),
            'event_date' => fake()->dateTimeBetween('now', '+90 days'),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'location' => fake()->randomElement([
                'North Beach', 'South Beach', 'Coral Bay', 'Sunset Point',
                'Marina Beach', 'Rocky Cove', 'Palm Beach',
            ]),
            'capacity' => fake()->numberBetween(10, 50),
            'price' => $event['price'],
            'equipment_included' => fake()->boolean(60),
            'age_restriction' => fake()->optional(0.3)->numberBetween(12, 18),
            'status' => fake()->randomElement(['active', 'cancelled', 'completed']),
        ];
    }
}
