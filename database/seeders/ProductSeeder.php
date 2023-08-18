<?php

namespace Database\Seeders;

use Database\Factories\ProductFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    protected $products = [
        ['name' => 'Pan de trigo', 'measurement_type' => 'Unidad'],
        ['name' => 'Pan de centeno', 'measurement_type' => 'Unidad'],
        ['name' => 'Croissant', 'measurement_type' => 'Unidad'],
        ['name' => 'Baguette', 'measurement_type' => 'Unidad'],
        ['name' => 'Pan de avena', 'measurement_type' => 'Unidad'],
        ['name' => 'Tela de algodón', 'measurement_type' => 'Longitud'],
        ['name' => 'Tela de lino', 'measurement_type' => 'Longitud'],
        ['name' => 'Tela de seda', 'measurement_type' => 'Longitud'],
        ['name' => 'Tela de mezclilla', 'measurement_type' => 'Longitud'],
        ['name' => 'Camiseta de algodón', 'measurement_type' => 'Unidad'],
        ['name' => 'Camisa de vestir', 'measurement_type' => 'Unidad'],
        ['name' => 'Vestido de noche', 'measurement_type' => 'Unidad'],
        ['name' => 'Pantalones vaqueros', 'measurement_type' => 'Unidad'],
        ['name' => 'Vinagre de manzana', 'measurement_type' => 'Unidad'],
        ['name' => 'Vinagre balsámico', 'measurement_type' => 'Unidad'],
        ['name' => 'Vinagre de vino tinto', 'measurement_type' => 'Unidad'],
        ['name' => 'Vinagre de sidra', 'measurement_type' => 'Unidad'],
        ['name' => 'Harina de trigo', 'measurement_type' => 'Masa/Peso'],
        ['name' => 'Harina de centeno', 'measurement_type' => 'Masa/Peso'],
        ['name' => 'Mantequilla', 'measurement_type' => 'Masa/Peso'],
        ['name' => 'Levadura', 'measurement_type' => 'Masa/Peso'],
        ['name' => 'Avena', 'measurement_type' => 'Masa/Peso'],
        ['name' => 'Algodón en bruto', 'measurement_type' => 'Masa/Peso'],
        ['name' => 'Lino en bruto', 'measurement_type' => 'Masa/Peso'],
        ['name' => 'Seda en bruto', 'measurement_type' => 'Masa/Peso'],
        ['name' => 'Hilos de algodón', 'measurement_type' => 'Volumen'],
        ['name' => 'Hilos de lino', 'measurement_type' => 'Volumen'],
        ['name' => 'Hilos de seda', 'measurement_type' => 'Volumen'],
        ['name' => 'Hilos de mezclilla', 'measurement_type' => 'Volumen'],
        ['name' => 'Colorantes textiles', 'measurement_type' => 'Volumen'],
        ['name' => 'Manzanas frescas', 'measurement_type' => 'Unidad'],
        ['name' => 'Mosto de uva', 'measurement_type' => 'Volumen'],
        ['name' => 'Vino tinto', 'measurement_type' => 'Volumen'],
        ['name' => 'Azúcar', 'measurement_type' => 'Masa/Peso'],
        ['name' => 'Sal', 'measurement_type' => 'Masa/Peso'],
        ['name' => 'Huevo', 'measurement_type' => 'Unidad'],
        ['name' => 'Leche', 'measurement_type' => 'Volumen'],
        ['name' => 'Agua', 'measurement_type' => 'Volumen'],
        ['name' => 'Miel', 'measurement_type' => 'Volumen'],
        ['name' => 'Aceite vegetal', 'measurement_type' => 'Volumen'],
        ['name' => 'Salvado de trigo', 'measurement_type' => 'Masa/Peso'],
        ['name' => 'Semillas de girasol', 'measurement_type' => 'Masa/Peso'],
        ['name' => 'Frutas secas', 'measurement_type' => 'Masa/Peso'],
        ['name' => 'Chocolate', 'measurement_type' => 'Masa/Peso'],
        ['name' => 'Canela', 'measurement_type' => 'Masa/Peso'],
        ['name' => 'Vainilla', 'measurement_type' => 'Volumen'],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('products')->truncate();
        DB::table('products')->insert(
            array_map(function ($product) {
                return [
                    'name' => $product['name'],
                    'measurement_type' => $product['measurement_type'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $this->products));
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
