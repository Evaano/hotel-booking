<?php

namespace Database\Factories;

use App\Models\Advertisement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertisementFactory extends Factory
{
    protected $model = Advertisement::class;

    public function definition(): array
    {
        $ads = [
            ['title' => 'Luxury Ocean View Suites', 'page' => 'hotels'],
            ['title' => 'Space Roller Coaster - Now Open!', 'page' => 'theme_park'],
            ['title' => 'Sunset Surfing Lessons', 'page' => 'beach_events'],
            ['title' => 'Premium Resort Experience', 'page' => 'hotels'],
            ['title' => 'Superhero 4D Adventure', 'page' => 'theme_park'],
            ['title' => 'Beach Volleyball Tournament', 'page' => 'beach_events'],
            ['title' => 'All-Inclusive Resort Packages', 'page' => 'hotels'],
            ['title' => 'Glow-in-the-Dark Night Rides', 'page' => 'theme_park'],
        ];

        $ad = fake()->randomElement($ads);

        return [
            'title' => $ad['title'],
            'description' => fake()->paragraph(2),
            'image_url' => fake()->imageUrl(800, 400, 'travel'),
            'target_page' => $ad['page'],
            'display_order' => fake()->numberBetween(1, 10),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
}
