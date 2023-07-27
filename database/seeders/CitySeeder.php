<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('cities')->truncate();
        $Cities = [
            ['name'=>'Boaco'],
            ['name'=>'Carazo'],
            ['name'=>'Chinandega'],
            ['name'=>'Chontales'],
            ['name'=>'Atlantico Norte'],
            ['name'=>'Atlantico Sur'],
            ['name'=>'Esteli'],
            ['name'=>'Granada'],
            ['name'=>'Jinotega'],
            ['name'=>'Leon'],
            ['name'=>'Madriz'],
            ['name'=>'Managua'],
            ['name'=>'Masaya'],
            ['name'=>'Matagalpa'],
            ['name'=>'Nueva Segovia'],
            ['name'=>'Río San Juan'],
            ['name'=>'Rivas']
        ];
        DB::table('cities')->insert($Cities);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}