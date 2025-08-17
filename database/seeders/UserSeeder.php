<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'System Administrator',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        // Hotel Operator
        User::factory()->create([
            'name' => 'Hotel Operator',
            'email' => 'hotel.operator@gmail.com',
            'username' => 'hotelop',
            'role' => 'hotel_operator',
            'password' => Hash::make('password123'),
        ]);

        // Ferry Operator
        User::factory()->create([
            'name' => 'Ferry Operator',
            'email' => 'ferry.operator@gmail.com',
            'username' => 'ferryop',
            'role' => 'ferry_operator',
            'password' => Hash::make('password123'),
        ]);

        // Park Operator
        User::factory()->create([
            'name' => 'Park Operator',
            'email' => 'park.operator@gmail.com',
            'username' => 'parkop',
            'role' => 'park_operator',
            'password' => Hash::make('password123'),
        ]);

        // Beach Organizer
        User::factory()->create([
            'name' => 'Beach Organizer',
            'email' => 'beach.organizer@gmail.com',
            'username' => 'beachorg',
            'role' => 'beach_organizer',
            'password' => Hash::make('password123'),
        ]);

        // Visitor
        User::factory()->create([
            'name' => 'John Visitor',
            'email' => 'visitor@gmail.com',
            'username' => 'visitor1',
            'role' => 'visitor',
            'password' => Hash::make('password123'),
        ]);
    }
}
