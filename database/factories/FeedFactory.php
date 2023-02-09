<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feed>
 */
class FeedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(20),
            'publication_date' => date('Y-m-d H:i:s'),
            'author' => fake()->name(),
            'image' => env('APP_URL') . '/public/images/seriesPhoto.jpg'
        ];
    }
}
