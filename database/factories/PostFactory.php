<?php

namespace Database\Factories;

use App\Enums\PostType;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'content' => fake()->paragraphs(3, true),
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1, 999999),
            'type' => PostType::TEXT,
            'status' => 'draft',
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    public function text(): static
    {
        return $this->state(fn () => [
            'type' => PostType::TEXT,
        ]);
    }

    public function blog(): static
    {
        return $this->state(fn () => [
            'type' => PostType::BLOG,
        ]);
    }

    public function image(): static
    {
        return $this->state(fn () => [
            'type' => PostType::IMAGE,
        ]);
    }

    public function video(): static
    {
        return $this->state(fn () => [
            'type' => PostType::VIDEO,
        ]);
    }

    public function poll(): static
    {
        return $this->state(fn () => [
            'type' => PostType::POLL,
        ]);
    }
}