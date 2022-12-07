<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $created = fake()->dateTimeBetween();
        $updated = fake()->dateTimeBetween($created);
        if (rand(0, 3)) {
            $updated = $created;
        }
        return [
            'title' => fake()->sentence,
            'body' => fake()->paragraphs(10, true),
            'created_at' => $created,
            'updated_at' => $updated
        ];
    }
}
