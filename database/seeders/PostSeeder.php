<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                Post::factory()
                    ->count(5)
                    ->for($user)
                    ->published()
                    ->create();
            });
    }
}
