<?php

namespace Database\Seeders;

use Database\Factories\OrganizationFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('organizations')->truncate();
        OrganizationFactory::new()->count(100)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
