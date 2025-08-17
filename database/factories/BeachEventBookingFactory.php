<?php

namespace Database\Factories;

use App\Models\BeachEvent;
use App\Models\BeachEventBooking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BeachEventBookingFactory extends Factory
{
    protected $model = BeachEventBooking::class;

    public function definition(): array
    {
        $numParticipants = fake()->numberBetween(1, 4);

        return [
            'user_id' => User::factory(),
            'beach_event_id' => BeachEvent::factory(),
            'num_participants' => $numParticipants,
            'total_amount' => fake()->randomFloat(2, 15, 200),
            'booking_status' => fake()->randomElement(['pending', 'confirmed', 'cancelled', 'completed']),
            'special_requirements' => fake()->optional(0.3)->sentence(8),
        ];
    }
}
