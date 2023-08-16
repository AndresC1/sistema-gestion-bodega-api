<?php

namespace Database\Seeders;

use Database\Factories\ProviderFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('providers')->truncate();
        ProviderFactory::new()->count(500)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
