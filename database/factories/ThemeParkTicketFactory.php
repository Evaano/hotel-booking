<?php

namespace Database\Factories;

use App\Models\RoomBooking;
use App\Models\ThemeParkTicket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThemeParkTicketFactory extends Factory
{
    protected $model = ThemeParkTicket::class;

    public function definition(): array
    {
        $numTickets = fake()->numberBetween(1, 6);
        $ticketPrice = 75.00; // Base theme park admission

        return [
            'user_id' => User::factory(),
            'room_booking_id' => RoomBooking::factory()->confirmed(),
            'visit_date' => fake()->dateTimeBetween('now', '+60 days'),
            'num_tickets' => $numTickets,
            'total_amount' => $ticketPrice * $numTickets,
            'ticket_status' => fake()->randomElement(['pending', 'confirmed', 'used', 'cancelled']),
        ];
    }
}
