<?php

namespace Database\Factories;

use App\Models\FerrySchedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FerryScheduleFactory extends Factory
{
    protected $model = FerrySchedule::class;

    public function definition(): array
    {
        $departureTime = fake()->time('H:i');
        $arrivalTime = fake()->time('H:i', strtotime($departureTime.' +2 hours'));

        return [
            'departure_time' => $departureTime,
            'arrival_time' => $arrivalTime,
            'route' => fake()->randomElement([
                'Main Island → Theme Park Island',
                'Theme Park Island → Main Island',
                'Main Island → Ferry Terminal',
                'Ferry Terminal → Main Island',
            ]),
            'capacity' => fake()->numberBetween(50, 200),
            'price' => fake()->randomFloat(2, 15, 45),
            'days_of_week' => fake()->randomElements([
                'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday',
            ], rand(3, 7)),
            'status' => fake()->randomElement(['active', 'inactive']),
            'operator_id' => User::factory(),
        ];
    }
}
