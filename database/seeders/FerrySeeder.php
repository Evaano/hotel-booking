<?php

namespace Database\Seeders;

use App\Models\FerrySchedule;
use App\Models\User;
use Illuminate\Database\Seeder;

class FerrySeeder extends Seeder
{
    public function run(): void
    {
        $ferryOperators = User::where('role', 'ferry_operator')->get();

        $schedules = [
            [
                'departure_time' => '08:00',
                'arrival_time' => '09:00',
                'route' => 'Main Island → Theme Park Island',
                'capacity' => 150,
                'price' => 25.00,
                'days_of_week' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
            ],
            [
                'departure_time' => '10:00',
                'arrival_time' => '11:00',
                'route' => 'Main Island → Theme Park Island',
                'capacity' => 150,
                'price' => 25.00,
                'days_of_week' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
            ],
            [
                'departure_time' => '14:00',
                'arrival_time' => '15:00',
                'route' => 'Theme Park Island → Main Island',
                'capacity' => 150,
                'price' => 25.00,
                'days_of_week' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
            ],
            [
                'departure_time' => '18:00',
                'arrival_time' => '19:00',
                'route' => 'Theme Park Island → Main Island',
                'capacity' => 150,
                'price' => 25.00,
                'days_of_week' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
            ],
        ];

        foreach ($schedules as $index => $scheduleData) {
            FerrySchedule::factory()->create([
                'departure_time' => $scheduleData['departure_time'],
                'arrival_time' => $scheduleData['arrival_time'],
                'route' => $scheduleData['route'],
                'capacity' => $scheduleData['capacity'],
                'price' => $scheduleData['price'],
                'days_of_week' => $scheduleData['days_of_week'],
                'operator_id' => $ferryOperators[$index % $ferryOperators->count()]->id,
                'status' => 'active',
            ]);
        }
    }
}
