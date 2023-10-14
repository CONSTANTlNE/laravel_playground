<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>User::all()->random()->id,
            'title'=>fake()->unique()->sentence,
            'excerpt'=>fake()->paragraph(2, true ),
            'description'=>fake()->paragraph(8, true),
            'min_to_read'=>fake()->randomNumber(1, 10),
            'is_published'=>fake()->boolean()
        ];
    }
}
