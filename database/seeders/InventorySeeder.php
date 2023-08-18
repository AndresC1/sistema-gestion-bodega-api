<?php

namespace Database\Seeders;

use Database\Factories\InventoryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('inventories')->truncate();
        InventoryFactory::new()->count(3000)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
