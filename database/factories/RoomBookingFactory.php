<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RoomBookingFactory extends Factory
{
    protected $model = RoomBooking::class;

    public function definition(): array
    {
        $checkIn = fake()->dateTimeBetween('now', '+30 days');
        $checkOut = fake()->dateTimeBetween($checkIn, $checkIn->format('Y-m-d').' +7 days');

        return [
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'room_type' => fake()->randomElement(['Standard', 'Deluxe', 'Suite', 'Ocean View']),
            'num_guests' => fake()->numberBetween(1, 4),
            'total_amount' => fake()->randomFloat(2, 200, 2000),
            'booking_status' => fake()->randomElement(['pending', 'confirmed', 'cancelled', 'completed']),
            'confirmation_code' => strtoupper(Str::random(8)),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'refunded']),
            'user_id' => User::factory(),
            'room_id' => Room::factory(),
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'booking_status' => 'confirmed',
            'payment_status' => 'paid',
        ]);
    }
}
