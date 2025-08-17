<?php

namespace Database\Factories;

use App\Models\ActivityBooking;
use App\Models\ParkActivity;
use App\Models\ThemeParkTicket;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityBookingFactory extends Factory
{
    protected $model = ActivityBooking::class;

    public function definition(): array
    {
        $numParticipants = fake()->numberBetween(1, 4);

        return [
            'theme_park_ticket_id' => ThemeParkTicket::factory(),
            'park_activity_id' => ParkActivity::factory(),
            'booking_time' => fake()->optional(0.8)->dateTimeBetween('now', '+30 days'),
            'num_participants' => $numParticipants,
            'total_amount' => fake()->randomFloat(2, 15, 100),
            'status' => fake()->randomElement(['pending', 'confirmed', 'completed', 'cancelled']),
        ];
    }
}
