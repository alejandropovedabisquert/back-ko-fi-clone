<?php

namespace Database\Factories;

use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Poll>
 */
class PollFactory extends Factory
{
    protected $model = Poll::class;

    public function definition(): array
    {
        return [
            'multiple_choice' => false,
            'ends_at' => fake()->optional()->dateTimeBetween(
                'now',
                '+30 days'
            ),
        ];
    }

    public function multipleChoice(): static
    {
        return $this->state(fn() => [
            'multiple_choice' => true,
        ]);
    }
}
