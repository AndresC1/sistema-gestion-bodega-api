<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $organization_count = \App\Models\Organization::count();
        return [
            'name' => $this->faker->name,
            'address' => $this->faker->randomElement([$this->faker->address, null]),
            'organization_id' => $this->faker->numberBetween(1, $organization_count),
            'type' => $this->faker->randomElement(['Por mayor', 'Al detalle']),
            'phone_main' => $this->faker->randomElement([$this->faker->phoneNumber, null]),
            'phone_secondary' => $this->faker->randomElement([$this->faker->phoneNumber, null]),
            'details' => $this->faker->randomElement([$this->faker->text, null]),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
