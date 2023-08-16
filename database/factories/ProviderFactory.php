<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Municipality;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provider>
 */
class ProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $count_organizations = \App\Models\Organization::count();
        $count_cities = City::count();
        $city = City::find($this->faker->numberBetween(1, $count_cities));
        $list_municipalities = $city->municipalities;
        $municipality = Municipality::find($this->faker->numberBetween($list_municipalities[0]->id, $list_municipalities[count($list_municipalities)-1]->id));
        return [
            "name" => $this->faker->unique()->company(),
            "email" => $this->faker->unique()->companyEmail(),
            "ruc" => $this->faker->unique()->numerify('###########'). Str::random(1),
            "organization_id" => $this->faker->numberBetween(1, $count_organizations),
            "municipality_id" => $municipality->id,
            "city_id" => $city->id,
            "contact_name" => $this->faker->name(),
            "address" => $this->faker->address(),
            "phone_main" => '+(505) '.$this->faker->numberBetween(11111111, 99999999),
            "phone_secondary" => '+(505) '.$this->faker->numberBetween(11111111, 99999999),
            "details" => $this->faker->text(),
            "status" => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
