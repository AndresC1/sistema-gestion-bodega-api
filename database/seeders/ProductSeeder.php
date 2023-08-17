<?php

namespace Database\Seeders;

use Database\Factories\ProductFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    protected $products = [
        'Pan de trigo',
        'Pan de centeno',
        'Croissant',
        'Baguette',
        'Pan de avena',
        'Tela de algodón',
        'Tela de lino',
        'Tela de seda',
        'Tela de mezclilla',
        'Camiseta de algodón',
        'Camisa de vestir',
        'Vestido de noche',
        'Pantalones vaqueros',
        'Vinagre de manzana',
        'Vinagre balsámico',
        'Vinagre de vino tinto',
        'Vinagre de sidra',
        'Harina de trigo',
        'Harina de centeno',
        'Mantequilla',
        'Levadura',
        'Avena',
        'Algodón en bruto',
        'Lino en fibras',
        'Seda natural',
        'Hilos de mezclilla',
        'Colorantes textiles',
        'Manzanas frescas',
        'Mosto de uva',
        'Vino tinto',
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
                    'name' => $product,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $this->products));
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
