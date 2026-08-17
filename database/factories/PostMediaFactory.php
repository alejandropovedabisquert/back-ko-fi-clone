<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PostMedia>
 */
class PostMediaFactory extends Factory
{
    protected $model = PostMedia::class;

    public function definition(): array
    {
        return [
            'path' => 'posts/' . fake()->uuid() . '.jpg',
            'alt' => fake()->sentence(4),
            'caption' => fake()->sentence(),
            'sort_order' => 0,
        ];
    }
}
