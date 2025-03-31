<?php

namespace Database\Factories;

use App\Models\Poll;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PollFactory extends Factory
{
    protected $model = Poll::class;

    public function definition(): array
    {
        return [
            'public_id' => $this->faker->word(),
            'admin_key' => $this->faker->word(),
            'author_name' => $this->faker->name(),
            'author_email' => $this->faker->unique()->safeEmail(),
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'anonymous_votes' => $this->faker->boolean(),
            'comments' => $this->faker->boolean(),
            'invite_only' => $this->faker->boolean(),
            'hide_results' => $this->faker->boolean(),
            'password' => bcrypt($this->faker->password()),
            'status' => $this->faker->word(),
            'deadline' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'edit_votes' => $this->faker->boolean(),
            'add_time_options' => $this->faker->boolean(),

            'user_id' => User::factory(),
        ];
    }
}
