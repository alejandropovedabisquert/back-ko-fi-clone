<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostMedia;
use App\Models\PostVideo;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()
            ->each(function (User $user) {

                // Posts de texto
                Post::factory()
                    ->count(5)
                    ->for($user)
                    ->text()
                    ->published()
                    ->create();

                // Posts de blog
                Post::factory()
                    ->count(5)
                    ->for($user)
                    ->blog()
                    ->published()
                    ->create();

                // Posts de imágenes
                Post::factory()
                    ->count(5)
                    ->for($user)
                    ->image()
                    ->published()
                    ->has(
                        PostMedia::factory()->count(3),
                        'media'
                    )
                    ->create();

                // Posts de vídeo
                Post::factory()
                    ->count(5)
                    ->for($user)
                    ->video()
                    ->published()
                    ->has(
                        PostVideo::factory(),
                        'video'
                    )
                    ->create();

                // Posts de encuestas
                Post::factory()
                    ->count(5)
                    ->for($user)
                    ->poll()
                    ->published()
                    ->has(
                        Poll::factory()
                            ->has(
                                PollOption::factory()->count(4),
                                'options'
                            ),
                        'poll'
                    )
                    ->create();
            });
    }
}
