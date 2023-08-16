<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Organization;
use App\Models\Municipality;
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
        $organization_count = Organization::count();
        $count_cities = City::count();
        $city = City::find($this->faker->numberBetween(1, $count_cities));
        $list_municipalities = $city->municipalities;
        $municipality = Municipality::find($this->faker->numberBetween($list_municipalities[0]->id, $list_municipalities[count($list_municipalities)-1]->id));
        return [
            'name' => $this->faker->name,
            'address' => $this->faker->randomElement([$this->faker->address, null]),
            'organization_id' => $this->faker->numberBetween(1, $organization_count),
            'type' => $this->faker->randomElement(['Por mayor', 'Al detalle']),
            'phone_main' => $this->faker->randomElement([$this->faker->phoneNumber, null]),
            'phone_secondary' => $this->faker->randomElement([$this->faker->phoneNumber, null]),
            'details' => $this->faker->randomElement([$this->faker->text, null]),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'municipality_id' => $municipality->id,
            'city_id' => $city->id,
        ];
    }
}
