<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'content' => fake()->paragraphs(4, true),
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1, 999999),
            'status' => 'draft',
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'published',
                'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            ];
        });
    }

    public function archived(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'archived',
                'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            ];
        });
    }

    public function draft(): static
    {
        return $this->state([
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}