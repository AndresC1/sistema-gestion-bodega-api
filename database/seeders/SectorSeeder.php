<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date_time = now();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('sectors')->truncate();
        DB::table('sectors')->insert([
            [
                "name" => "Agroindustria",
                "created_at" => "$date_time",
                "updated_at" => "$date_time"
            ],
            [
                "name" => "Panaderia",
                "created_at" => "$date_time",
                "updated_at" => "$date_time"
            ],
            [
                "name" => "Textil",
                "created_at" => "$date_time",
                "updated_at" => "$date_time"
            ]
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
