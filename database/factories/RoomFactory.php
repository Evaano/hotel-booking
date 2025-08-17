<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        $roomTypes = ['Standard', 'Deluxe', 'Suite', 'Ocean View', 'Presidential'];
        $roomType = fake()->randomElement($roomTypes);

        return [
            'room_number' => fake()->numerify('##0#'),
            'room_type' => $roomType,
            'description' => fake()->sentence(10),
            'max_occupancy' => fake()->numberBetween(1, 6),
            'base_price' => fake()->randomFloat(2, 80, 500),
            'amenities' => fake()->randomElements([
                'Air Conditioning', 'Mini Bar', 'Balcony', 'Sea View',
                'Jacuzzi', 'King Bed', 'Twin Beds', 'Work Desk', 'Safe',
            ], rand(2, 5)),
            'status' => fake()->randomElement(['available', 'occupied', 'maintenance']),
            'hotel_id' => Hotel::factory(),
        ];
    }
}
