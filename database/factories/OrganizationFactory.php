<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sector;
use App\Models\Municipality;
use App\Models\City;
use Nette\Utils\Random;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $count_sectors = Sector::count();
        $count_cities = City::count();
        $city = City::find($this->faker->numberBetween(1, $count_cities));
        $list_municipalities = $city->municipalities;
        $municipality = Municipality::find($this->faker->numberBetween($list_municipalities[0]->id, $list_municipalities[count($list_municipalities)-1]->id));
        $letter_random = Random::generate(1, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        return [
            "name" => $this->faker->company(),
            "ruc" => $this->faker->unique()->numerify("#############").$letter_random,
            "address" => $this->faker->address(),
            "sector_id" => $this->faker->numberBetween(1, $count_sectors),
            "municipality_id" => $municipality->id,
            "city_id" => $city->id,
            "phone_main" => '+(505) '.$this->faker->numberBetween(11111111, 99999999),
            "phone_secondary" => '+(505) '.$this->faker->numberBetween(11111111, 99999999),
        ];
    }
}
