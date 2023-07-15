<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
//        return [
//            'name' => fake()->name(),
//            'email' => fake()->unique()->safeEmail(),
//            'email_verified_at' => now(),
//            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
//            'remember_token' => Str::random(10),
//        ];
        return [
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
            'title' => fake()->sentence(),
            'slug' => fake()->slug(),
            'excerpt' => fake()->paragraphs(2, true),
            'body' => fake()->paragraphs(6, true)
        ];
    }
}
