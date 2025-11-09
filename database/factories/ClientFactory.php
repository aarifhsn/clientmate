<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition(): array
    {
        $priorities = ['high', 'medium', 'low'];

        return [
            'user_id' => User::factory(),
            'category_id' => Category::inRandomOrder()->first()?->id,
            'name' => $this->faker->name(),
            'linkedin_url' => 'https://www.linkedin.com/in/' . $this->faker->userName(),
            'priority' => $this->faker->randomElement($priorities),
            'activity' => 'moderate',
            'connected' => $this->faker->boolean(70),
            'is_favorite' => $this->faker->boolean(20),
            'last_visited_at' => $this->faker->optional()->dateTimeBetween('-15 days', 'now'),
            'next_follow_up' => $this->faker->optional()->dateTimeBetween('now', '+10 days'),
            'notes' => $this->faker->sentence(),
        ];

    }
}
