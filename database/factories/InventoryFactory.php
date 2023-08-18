<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $produc_count = \App\Models\Product::count();
        $organization_count = \App\Models\Organization::count();
        $stock = $this->faker->randomFloat(4, 1, 1000);
        $stock_min = $this->faker->numberBetween(5, 10);
        $unit_of_measurement = [
            'Longitud' => ['km', 'm', 'cm', 'mm', 'mi', 'in', 'ft', 'yd'],
            'Masa/Peso' => ['kg', 'lb', 'oz', 'gr', 'cup'],
            'Volumen' => ['l', 'ml', 'gal', 'qt', 'pt'],
            'Unidad' => ['un', 'doc', 'caj', 'pq', 'bul', 'sac', 'par'],
        ];
        $product = \App\Models\Product::find($this->faker->numberBetween(1, $produc_count));
        $measurement_type = $unit_of_measurement[$product->measurement_type];
        return [
            'product_id' => $product->id,
            'organization_id' => $this->faker->numberBetween(1, $organization_count),
            'type' => $this->faker->randomElement(['MP', 'PT']),
            'stock' => $stock,
            'stock_min' => $stock_min,
            'unit_of_measurement' => $this->faker->randomElement($measurement_type),
            'location' => $this->faker->randomElement([null, 'Estante 1', 'Estante 2', 'Estante 3', 'Estante 4']),
            'date_last_modified' => now()->format('Y-m-d'),
            'lot_number' => $this->faker->randomElement(['Lote 1', 'Lote 2', 'Lote 3', 'Lote 4']),
            'note' => $this->faker->randomElement([null, $this->faker->text(200)]),
            'status' => $stock > $stock_min ? 'disponible' : 'no disponible',
            'total_value' => $this->faker->randomFloat(2, 1, 1000),
            'code' => $this->faker->randomElement(['0-B156', '0-B157', '0-B158', '0-B159']),
            'description' => $this->faker->randomElement([null, $this->faker->text(200)]),
        ];
    }
}
