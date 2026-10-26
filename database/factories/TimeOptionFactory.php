<?php

namespace Database\Factories;

use App\Models\TimeOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TimeOption>
 */
class TimeOptionFactory extends Factory
{
    protected $model = TimeOption::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
        ];
    }
}
