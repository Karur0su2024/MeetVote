<?php

namespace Database\Factories;

use App\Models\PollQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PollQuestion>
 */
class PollQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => $this->faker->text(),
        ];
    }
}
