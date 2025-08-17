<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            HotelSeeder::class,
            FerrySeeder::class,
            ParkActivitySeeder::class,
            BeachEventSeeder::class,
            BookingSeeder::class,
            AdvertisementSeeder::class,
            IslandLocationSeeder::class,
        ]);
    }
}
