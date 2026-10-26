<?php

namespace Database\Factories;

use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vote>
 */
class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'voter_email' => $this->faker->unique()->safeEmail(),
            'voter_name' => $this->faker->name(),
            'message' => $this->faker->text(),
        ];
    }
}
