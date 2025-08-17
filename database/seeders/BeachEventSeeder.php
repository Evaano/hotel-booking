<?php

namespace Database\Seeders;

use App\Models\BeachEvent;
use App\Models\User;
use Illuminate\Database\Seeder;

class BeachEventSeeder extends Seeder
{
    public function run(): void
    {
        $organizers = User::where('role', 'beach_organizer')->get();

        $events = [
            [
                'name' => 'Sunrise Yoga Session',
                'description' => 'Start your day with peaceful yoga on the beach as the sun rises over the ocean.',
                'event_type' => 'other',
                'start_time' => '06:30',
                'end_time' => '07:30',
                'location' => 'North Beach',
                'capacity' => 25,
                'price' => 25.00,
                'equipment_included' => true,
                'age_restriction' => null,
            ],
            [
                'name' => 'Beach Volleyball Tournament',
                'description' => 'Competitive beach volleyball tournament with prizes for winning teams.',
                'event_type' => 'beach_volleyball',
                'start_time' => '15:00',
                'end_time' => '18:00',
                'location' => 'South Beach',
                'capacity' => 32,
                'price' => 15.00,
                'equipment_included' => true,
                'age_restriction' => 16,
            ],
            [
                'name' => 'Sunset Surfing Lessons',
                'description' => 'Learn to surf with certified instructors during the beautiful sunset hours.',
                'event_type' => 'surfing',
                'start_time' => '17:00',
                'end_time' => '19:00',
                'location' => 'Sunset Point',
                'capacity' => 12,
                'price' => 45.00,
                'equipment_included' => true,
                'age_restriction' => 12,
            ],
            [
                'name' => 'Snorkeling Adventure',
                'description' => 'Explore the colorful coral reefs and marine life around the island.',
                'event_type' => 'snorkeling',
                'start_time' => '10:00',
                'end_time' => '12:00',
                'location' => 'Coral Bay',
                'capacity' => 20,
                'price' => 35.00,
                'equipment_included' => true,
                'age_restriction' => 8,
            ],
            [
                'name' => 'Beach Party Bonfire',
                'description' => 'Evening beach party with bonfire, music, and tropical refreshments.',
                'event_type' => 'beach_party',
                'start_time' => '19:00',
                'end_time' => '22:00',
                'location' => 'Palm Beach',
                'capacity' => 50,
                'price' => 20.00,
                'equipment_included' => false,
                'age_restriction' => 18,
            ],
            [
                'name' => 'Jet Ski Experience',
                'description' => 'High-speed jet ski adventure around the island with safety instruction.',
                'event_type' => 'water_sports',
                'start_time' => '14:00',
                'end_time' => '16:00',
                'location' => 'Marina Beach',
                'capacity' => 8,
                'price' => 60.00,
                'equipment_included' => true,
                'age_restriction' => 16,
            ],
        ];

        foreach ($events as $index => $eventData) {
            // Create multiple instances of each event on different dates
            for ($i = 0; $i < 3; $i++) {
                BeachEvent::factory()->create([
                    'name' => $eventData['name'],
                    'description' => $eventData['description'],
                    'event_type' => $eventData['event_type'],
                    'organizer_id' => $organizers[$index % $organizers->count()]->id,
                    'event_date' => now()->addDays(rand(1, 60)),
                    'start_time' => $eventData['start_time'],
                    'end_time' => $eventData['end_time'],
                    'location' => $eventData['location'],
                    'capacity' => $eventData['capacity'],
                    'price' => $eventData['price'],
                    'equipment_included' => $eventData['equipment_included'],
                    'age_restriction' => $eventData['age_restriction'],
                    'status' => 'active',
                ]);
            }
        }
    }
}
