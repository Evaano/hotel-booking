<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    public function run(): void
    {
        $advertisements = [
            [
                'title' => 'Luxury Ocean View Suites Available',
                'description' => 'Experience paradise in our premium ocean view suites with private balconies and world-class amenities.',
                'target_page' => 'hotels',
                'display_order' => 1,
            ],
            [
                'title' => 'Space Roller Coaster - Now Open!',
                'description' => 'Blast off on our newest attraction! Experience zero gravity thrills on the Space Exploration Roller Coaster.',
                'target_page' => 'theme_park',
                'display_order' => 2,
            ],
            [
                'title' => 'Sunset Surfing Lessons',
                'description' => 'Learn to surf with certified instructors during magical sunset hours. Equipment included!',
                'target_page' => 'beach_events',
                'display_order' => 3,
            ],
            [
                'title' => 'All-Inclusive Resort Packages',
                'description' => 'Book now and save! Includes accommodation, meals, and exclusive access to island attractions.',
                'target_page' => 'hotels',
                'display_order' => 4,
            ],
            [
                'title' => 'Superhero 4D Adventure',
                'description' => 'Join your favorite heroes in this immersive 4D experience with motion seats and special effects.',
                'target_page' => 'theme_park',
                'display_order' => 5,
            ],
            [
                'title' => 'Beach Volleyball Tournament',
                'description' => 'Compete in our weekly beach volleyball tournament! Prizes for winning teams.',
                'target_page' => 'beach_events',
                'display_order' => 6,
            ],
        ];

        foreach ($advertisements as $adData) {
            Advertisement::factory()->create([
                'title' => $adData['title'],
                'description' => $adData['description'],
                'image_url' => 'https://picsum.photos/seed/'.md5($adData['title']).'/800/400',
                'target_page' => $adData['target_page'],
                'display_order' => $adData['display_order'],
                'status' => 'active',
            ]);
        }
    }
}
