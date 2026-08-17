<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostVideo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PostVideo>
 */
class PostVideoFactory extends Factory
{
    protected $model = PostVideo::class;

    public function definition(): array
    {
        return [
            'provider' => 'youtube',
            'video_id' => fake()->regexify('[A-Za-z0-9_-]{11}'),
            'thumbnail' => null,
        ];
    }
}
