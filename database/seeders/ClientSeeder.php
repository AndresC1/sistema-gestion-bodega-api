<?php

namespace Database\Seeders;

use Database\Factories\ClientFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('clients')->truncate();
        ClientFactory::new()->count(1000)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
