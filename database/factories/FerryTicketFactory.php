<?php

namespace Database\Factories;

use App\Models\FerrySchedule;
use App\Models\FerryTicket;
use App\Models\RoomBooking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FerryTicketFactory extends Factory
{
    protected $model = FerryTicket::class;

    public function definition(): array
    {
        $numPassengers = fake()->numberBetween(1, 6);
        $basePrice = fake()->randomFloat(2, 15, 45);

        return [
            'user_id' => User::factory(),
            'room_booking_id' => RoomBooking::factory()->confirmed(),
            'ferry_schedule_id' => FerrySchedule::factory(),
            'travel_date' => fake()->dateTimeBetween('now', '+60 days'),
            'num_passengers' => $numPassengers,
            'total_amount' => $basePrice * $numPassengers,
            'booking_status' => fake()->randomElement(['pending', 'confirmed', 'cancelled']),
        ];
    }
}
