<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $count_roles = \App\Models\Role::count();
        $count_organizations = \App\Models\Organization::count();
        return [
            'name' => fake()->name(),
            'email' => $this->faker->unique()->email(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'username' => $this->faker->unique()->userName().Str::random(5),
            'role_id' => fake()->numberBetween(1, $count_roles),
            'organization_id' => fake()->numberBetween(1, $count_organizations),
            'last_login_at' => fake()->dateTime(),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
