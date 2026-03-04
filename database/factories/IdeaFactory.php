<?php

namespace Database\Factories;

use App\IdeaStatus;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Idea>
 */
class IdeaFactory extends Factory
{
    protected $model = Idea::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(IdeaStatus::cases())->value,
            'links' => [fake()->url()],
        ];
    }
}
